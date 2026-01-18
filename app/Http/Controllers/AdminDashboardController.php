<?php

namespace App\Http\Controllers;

use App\Models\MaterialTransferRequest;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_transfers' => MaterialTransferRequest::count(),
            'pending_transfers' => MaterialTransferRequest::where('collection_status', 'pending')->count(),
            'completed_transfers' => MaterialTransferRequest::where('collection_status', 'completed')->count(),
            'total_users' => User::count(),
        ];

        $recent_transfers = MaterialTransferRequest::with('statusLogs.user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_transfers'));
    }
}