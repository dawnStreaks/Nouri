<?php

namespace App\Http\Controllers;

use App\Models\MaterialTransferRequest;
use Illuminate\Http\Request;

class MaterialTransferController extends Controller
{
    public function index()
    {
        $routes = [
            'mab-to-ahmadi' => 'MAB to Ahmadi',
            'ahmadi-to-mab' => 'Ahmadi to MAB',
            'mab-to-etd-ardhiya' => 'MAB to ETD Ardhiya',
            'etd-ardhiya-to-mab' => 'ETD Ardhiya to MAB',
            'ahmadi-to-etd-ardhiya' => 'Ahmadi to ETD Ardhiya',
            'etd-ardhiya-to-ahmadi' => 'ETD Ardhiya to Ahmadi'
        ];

        $routeStats = [];
        foreach ($routes as $routeKey => $routeName) {
            $total = MaterialTransferRequest::where('transfer_route', $routeKey)->count();
            $pending = MaterialTransferRequest::where('transfer_route', $routeKey)->where('is_approved', false)->count();
            $approved = MaterialTransferRequest::where('transfer_route', $routeKey)->where('is_approved', true)->count();
            
            $routeStats[$routeKey] = [
                'name' => $routeName,
                'total' => $total,
                'pending' => $pending,
                'approved' => $approved
            ];
        }

        return view('material-transfer.routes', compact('routeStats'));
    }

    public function create($route)
    {
        $nextSlNo = $this->getNextSlNo($route);
        return view('material-transfer.create', compact('route', 'nextSlNo'));
    }

    public function show($route)
    {
        $requests = MaterialTransferRequest::where('transfer_route', $route)
            ->orderBy('created_at', 'desc')
            ->orderBy('sl_no', 'desc')
            ->get();
        $groupedRequests = $requests->groupBy(function ($request) {
            if (!empty($request->transfer_voucher_number)) {
                return 'voucher:' . $request->transfer_voucher_number;
            }
            if (!empty($request->ref_no)) {
                return 'ref:' . $request->ref_no;
            }

            $date = $request->transfer_date ? $request->transfer_date->format('Y-m-d') : 'no-date';
            $company = $request->company_name ?: 'no-company';
            $created = $request->created_at ? $request->created_at->format('Y-m-d') : 'no-created';

            return 'meta:' . $date . '|' . $company . '|' . $created;
        });

        $totalRequests = $groupedRequests->count();
        $approvedRequests = $groupedRequests->filter(function ($group) {
            return $group->every(function ($item) {
                return $item->is_approved;
            });
        })->count();
        $pendingRequests = $totalRequests - $approvedRequests;
        $totalQty = $requests->sum('allocatable_qty');

        return view('material-transfer.show', compact(
            'requests',
            'route',
            'groupedRequests',
            'totalRequests',
            'approvedRequests',
            'pendingRequests',
            'totalQty'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transfer_route' => 'required|string',
            'ref_no' => 'nullable|string',
            'transfer_date' => 'nullable|date',
            'company_name' => 'nullable|string',
            'transfer_voucher_number' => 'nullable|string',
            'items.*.sl_no' => 'required|integer',
            'items.*.part_no' => 'required|string',
            'items.*.showroom_requirement' => 'required|numeric|min:0',
            'items.*.unit' => 'required|string',
            'items.*.allocatable_qty' => 'nullable|numeric|min:0',
            'items.*.actual_qty_received' => 'nullable|numeric|min:0',
            'items.*.st' => 'boolean',
            'items.*.rt' => 'boolean'
        ]);

        // Check for duplicate S.No within the same transfer route
        $existingSlNos = MaterialTransferRequest::where('transfer_route', $validated['transfer_route'])
            ->pluck('sl_no')->toArray();
        
        foreach ($validated['items'] as $item) {
            if (in_array($item['sl_no'], $existingSlNos)) {
                return back()->withErrors(['items' => "S.No {$item['sl_no']} already exists for this transfer route."])->withInput();
            }
            $existingSlNos[] = $item['sl_no']; // Add to check for duplicates within current submission
        }
        
        foreach ($validated['items'] as $item) {
            $item['transfer_route'] = $validated['transfer_route'];
            $item['ref_no'] = $validated['ref_no'];
            $item['transfer_date'] = $validated['transfer_date'];
            $item['company_name'] = $validated['company_name'];
            $item['transfer_voucher_number'] = $validated['transfer_voucher_number'];
            $transfer = MaterialTransferRequest::create($item);
            
            // Fire event for email notification
            event(new \App\Events\MaterialTransferRequested($transfer));
        }

        return redirect()->route('material-transfer.show', $validated['transfer_route'])->with('success', 'Material transfer request saved successfully!');
    }

    public function getNextSlNo($route)
    {
        $maxSlNo = MaterialTransferRequest::where('transfer_route', $route)->max('sl_no') ?? 0;
        return $maxSlNo + 1;
    }

    public function edit($id)
    {
        $request = MaterialTransferRequest::findOrFail($id);
        return view('material-transfer.edit', compact('request'));
    }

    public function update(Request $request, $id)
    {
        $item = MaterialTransferRequest::findOrFail($id);
        
        $validated = $request->validate([
            'ref_no' => 'nullable|string',
            'transfer_date' => 'nullable|date',
            'company_name' => 'nullable|string',
            'part_no' => 'required|string',
            'showroom_requirement' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'allocatable_qty' => 'nullable|numeric|min:0',
            'actual_qty_received' => 'nullable|numeric|min:0',
            'st' => 'nullable',
            'rt' => 'nullable'
        ]);

        $validated['st'] = $request->has('st') ? ($request->input('st') == '1') : false;
        $validated['rt'] = $request->has('rt') ? ($request->input('rt') == '1') : false;

        $item->update($validated);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('material-transfer.show', $item->transfer_route)->with('success', 'Item updated successfully!');
    }

    public function approve(Request $request, $id)
    {
        $item = MaterialTransferRequest::findOrFail($id);
        $item->update([
            'is_approved' => true,
            'approved_by' => $request->input('approved_by', 'Admin'),
            'approved_at' => now()
        ]);

        // Send email notification to all users
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            \Mail::to($user->email)->send(new \App\Mail\TransferApprovedMail($item));
        }

        return back()->with('success', 'Item approved successfully!');
    }

    public function readyForCollection(Request $request, $id)
    {
        $item = MaterialTransferRequest::findOrFail($id);
        $item->update([
            'st' => true,
            'collection_status' => 'ready_for_collection'
        ]);

        return back()->with('success', 'Item marked as ready for collection!');
    }

    public function collect(Request $request, $id)
    {
        $item = MaterialTransferRequest::findOrFail($id);
        $item->update([
            'st' => true,
            'collection_status' => 'collected',
            'collected_by' => auth()->user()->name,
            'collected_at' => now()
        ]);

        return back()->with('success', 'Item marked as ready for collection!');
    }

    public function finish(Request $request, $id)
    {
        $item = MaterialTransferRequest::findOrFail($id);
        $item->update(['collection_status' => 'completed']);

        return back()->with('success', 'Transfer completed successfully!');
    }

    public function received(Request $request, $id)
    {
        $item = MaterialTransferRequest::findOrFail($id);
        $item->update([
            'collection_status' => 'received',
            'rt' => true
        ]);

        return back()->with('success', 'Item marked as received successfully!');
    }
}
