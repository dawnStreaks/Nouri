@extends('layouts.admin')

@section('title', 'Transfer Routes')
@section('page-title', 'Transfer Routes')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($routes as $route)
        <div class="bg-gray-50 rounded-lg p-6 border">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-route text-blue-600"></i>
                </div>
                <button class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ ucwords(str_replace('-', ' ', $route)) }}</h3>
            <div class="text-sm text-gray-600 mb-4">
                <p>Route: {{ $route }}</p>
                <p>Status: Active</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('material-transfer.create', $route) }}" class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded">Create Transfer</a>
                <a href="{{ route('material-transfer.show', $route) }}" class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded">View Records</a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-8 text-gray-500">
            <i class="fas fa-route text-4xl mb-4"></i>
            <p>No transfer routes found</p>
        </div>
        @endforelse
    </div>
</div>
@endsection