<?php

namespace App\Http\Controllers;

use App\Models\MaterialTransferRequest;
use Illuminate\Http\Request;

class MaterialTransferController extends Controller
{
    public function index()
    {
        return view('material-transfer.routes');
    }

    public function create($route)
    {
        $nextSlNo = $this->getNextSlNo($route);
        return view('material-transfer.create', compact('route', 'nextSlNo'));
    }

    public function show($route)
    {
        $requests = MaterialTransferRequest::where('transfer_route', $route)->orderBy('sl_no')->get();
        return view('material-transfer.show', compact('requests', 'route'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transfer_route' => 'required|string',
            'ref_no' => 'nullable|string',
            'transfer_date' => 'nullable|date',
            'company_name' => 'nullable|string',
            'items.*.sl_no' => 'required|integer',
            'items.*.part_no' => 'required|string',
            'items.*.showroom_requirement' => 'required|numeric|min:0',
            'items.*.unit' => 'required|string',
            'items.*.allocatable_qty' => 'required|numeric|min:0',
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
            MaterialTransferRequest::create($item);
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
            'allocatable_qty' => 'required|numeric|min:0',
            'actual_qty_received' => 'nullable|numeric|min:0',
            'st' => 'boolean',
            'rt' => 'boolean'
        ]);

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

        return back()->with('success', 'Item approved successfully!');
    }
}