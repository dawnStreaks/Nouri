@extends('layouts.admin')

@section('title', 'Transfer Reports')
@section('page-title', 'Transfer Reports')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Status Overview -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Transfer Status Overview</h3>
        <div class="space-y-3">
            @foreach($transferStats as $stat)
            <div class="flex items-center justify-between">
                <span class="text-gray-600">{{ ucfirst($stat->collection_status) }}</span>
                <div class="flex items-center">
                    <span class="text-lg font-semibold mr-2">{{ $stat->count }}</span>
                    <span class="text-sm text-gray-500">({{ number_format($stat->total_qty, 2) }} qty)</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Quick Statistics</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Total Transfers</span>
                <span class="text-lg font-semibold">{{ $transferStats->sum('count') }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Total Quantity</span>
                <span class="text-lg font-semibold">{{ number_format($transferStats->sum('total_qty'), 2) }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">Completion Rate</span>
                @php
                    $completed = $transferStats->where('collection_status', 'completed')->first();
                    $total = $transferStats->sum('count');
                    $rate = $total > 0 ? (($completed->count ?? 0) / $total) * 100 : 0;
                @endphp
                <span class="text-lg font-semibold">{{ number_format($rate, 1) }}%</span>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Reports -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Detailed Reports</h2>
            <div class="flex space-x-2">
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    <i class="fas fa-download mr-2"></i>Export PDF
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </button>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                <select class="w-full border border-gray-300 rounded px-3 py-2">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 3 months</option>
                    <option>Custom range</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full border border-gray-300 rounded px-3 py-2">
                    <option>All statuses</option>
                    <option>Pending</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Route</label>
                <select class="w-full border border-gray-300 rounded px-3 py-2">
                    <option>All routes</option>
                    <option>Store to Showroom</option>
                    <option>Showroom to Store</option>
                </select>
            </div>
        </div>

        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-chart-bar text-4xl mb-4"></i>
            <p>Select filters above to generate detailed reports</p>
        </div>
    </div>
</div>
@endsection