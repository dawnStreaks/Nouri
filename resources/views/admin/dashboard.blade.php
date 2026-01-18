@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Transfers -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-exchange-alt text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Transfers</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['total_transfers'] }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Transfers -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Pending</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_transfers'] }}</p>
            </div>
        </div>
    </div>

    <!-- Completed Transfers -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Completed</h3>
                <p class="text-3xl font-bold text-green-600">{{ $stats['completed_transfers'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.transfers.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
            <i class="fas fa-plus text-blue-600 mr-3"></i>
            <span class="font-medium text-blue-800">Create New Transfer</span>
        </a>
        <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
            <i class="fas fa-user-plus text-green-600 mr-3"></i>
            <span class="font-medium text-green-800">Add New User</span>
        </a>
        <a href="{{ route('admin.reports.transfers') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
            <i class="fas fa-chart-bar text-purple-600 mr-3"></i>
            <span class="font-medium text-purple-800">View Reports</span>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
    @if($recent_transfers->count() > 0)
        <div class="space-y-3">
            @foreach($recent_transfers as $transfer)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                <div>
                    <p class="font-medium">{{ $transfer->part_no }}</p>
                    <p class="text-sm text-gray-600">{{ $transfer->transfer_route }} - {{ $transfer->created_at->diffForHumans() }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                    {{ ucfirst($transfer->collection_status) }}
                </span>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-600">
            <p>No recent transfer activities.</p>
        </div>
    @endif
</div>
@endsection