<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialTransferRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_transfers' => MaterialTransferRequest::count(),
            'pending_transfers' => MaterialTransferRequest::where('collection_status', 'pending')->count(),
            'completed_transfers' => MaterialTransferRequest::where('collection_status', 'completed')->count(),
            'total_users' => User::count(),
        ];

        $recent_transfers = MaterialTransferRequest::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_transfers'));
    }

    // Transfer Management
    public function transfersIndex()
    {
        $transfers = MaterialTransferRequest::with('statusLogs')->paginate(20);
        return view('admin.transfers.index', compact('transfers'));
    }

    public function transfersCreate()
    {
        return view('admin.transfers.create');
    }

    public function transfersPending()
    {
        $transfers = MaterialTransferRequest::where('collection_status', 'pending')->paginate(20);
        return view('admin.transfers.pending', compact('transfers'));
    }

    public function transfersRoutes()
    {
        // Define all available transfer routes
        $routes = [
            'mab-to-ahmadi' => 'MAB to Ahmadi',
            'ahmadi-to-mab' => 'Ahmadi to MAB',
            'mab-to-etd-ardhiya' => 'MAB to ETD Ardhiya',
            'etd-ardhiya-to-mab' => 'ETD Ardhiya to MAB',
            'ahmadi-to-etd-ardhiya' => 'Ahmadi to ETD Ardhiya',
            'etd-ardhiya-to-ahmadi' => 'ETD Ardhiya to Ahmadi'
        ];
        
        // Get transfer counts for each route
        $routeCounts = MaterialTransferRequest::selectRaw('transfer_route, COUNT(*) as count')
            ->groupBy('transfer_route')
            ->pluck('count', 'transfer_route');
            
        return view('admin.transfers.routes', compact('routes', 'routeCounts'));
    }

    // User Management
    public function usersIndex()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        return view('admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,store,delivery',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,store,delivery',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role']
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function rolesIndex()
    {
        $roles = ['admin', 'store', 'delivery'];
        $users = User::all();
        return view('admin.roles.index', compact('roles', 'users'));
    }

    // Inventory Management
    public function partsIndex()
    {
        $parts = MaterialTransferRequest::select('part_no')
            ->distinct()
            ->pluck('part_no');
        return view('admin.parts.index', compact('parts'));
    }

    public function inventoryIndex()
    {
        $inventory = MaterialTransferRequest::selectRaw('
            part_no,
            SUM(allocatable_qty) as total_allocated,
            SUM(actual_qty_received) as total_received,
            COUNT(*) as transfer_count
        ')
        ->groupBy('part_no')
        ->get();
        
        return view('admin.inventory.index', compact('inventory'));
    }

    public function suppliersIndex()
    {
        return view('admin.suppliers.index');
    }

    // Company Management
    public function companiesIndex()
    {
        $companies = MaterialTransferRequest::select('company_name')
            ->distinct()
            ->whereNotNull('company_name')
            ->pluck('company_name');
        return view('admin.companies.index', compact('companies'));
    }

    public function companyTransfers($company)
    {
        $transfers = MaterialTransferRequest::where('company_name', $company)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.companies.transfers', compact('transfers', 'company'));
    }

    public function departmentsIndex()
    {
        return view('admin.departments.index');
    }

    // Reports
    public function reportsTransfers()
    {
        $transferStats = MaterialTransferRequest::selectRaw('
            collection_status,
            COUNT(*) as count,
            SUM(allocatable_qty) as total_qty
        ')
        ->groupBy('collection_status')
        ->get();

        return view('admin.reports.transfers', compact('transferStats'));
    }

    public function reportsInventory()
    {
        return view('admin.reports.inventory');
    }

    public function reportsUsers()
    {
        $userStats = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->get();
        return view('admin.reports.users', compact('userStats'));
    }

    // System
    public function settingsIndex()
    {
        return view('admin.settings.index');
    }

    public function logsIndex()
    {
        return view('admin.logs.index');
    }

    public function backupIndex()
    {
        return view('admin.backup.index');
    }
}