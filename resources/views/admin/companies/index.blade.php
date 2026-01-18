@extends('layouts.admin')

@section('title', 'Company Management')
@section('page-title', 'Companies')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">All Companies</h2>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Add Company
            </button>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($companies as $company)
            <div class="bg-gray-50 rounded-lg p-6 border">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-building text-blue-600"></i>
                    </div>
                    <div class="flex space-x-2">
                        <button class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $company }}</h3>
                <div class="text-sm text-gray-600 space-y-1">
                    <p><i class="fas fa-map-marker-alt mr-2"></i>Location: N/A</p>
                    <p><i class="fas fa-phone mr-2"></i>Phone: N/A</p>
                    <p><i class="fas fa-envelope mr-2"></i>Email: N/A</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded">View Transfers</button>
                    <button class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded">Contact</button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                <i class="fas fa-building text-4xl mb-4"></i>
                <p>No companies found</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection