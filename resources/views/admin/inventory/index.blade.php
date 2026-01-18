@extends('layouts.admin')

@section('title', 'Inventory Management')
@section('page-title', 'Stock Levels')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Inventory Overview</h2>
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                <i class="fas fa-download mr-2"></i>Export Report
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Part No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Allocated</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Received</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transfer Count</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($inventory as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->part_no }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->total_allocated, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->total_received, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->transfer_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $percentage = $item->total_allocated > 0 ? ($item->total_received / $item->total_allocated) * 100 : 0;
                        @endphp
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($percentage >= 90) bg-green-100 text-green-800
                            @elseif($percentage >= 50) bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ number_format($percentage, 1) }}%
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-900">View Details</a>
                            <a href="#" class="text-green-600 hover:text-green-900">Update Stock</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No inventory data found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection