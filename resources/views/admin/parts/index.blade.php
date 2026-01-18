@extends('layouts.admin')

@section('title', 'Parts Management')
@section('page-title', 'Parts Management')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">All Parts</h2>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Add New Part
            </button>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($parts as $part)
            <div class="bg-gray-50 rounded-lg p-4 border">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-medium text-gray-900">{{ $part }}</h3>
                    <div class="flex space-x-1">
                        <button class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="text-sm text-gray-600">
                    <p>Part Number: {{ $part }}</p>
                    <p class="mt-1">Status: <span class="text-green-600">Active</span></p>
                </div>
                <div class="mt-3 flex space-x-2">
                    <button class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">View Details</button>
                    <button class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Stock History</button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                <i class="fas fa-cogs text-4xl mb-4"></i>
                <p>No parts found</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection