@extends('layouts.admin')

@section('title', 'Roles & Permissions')
@section('page-title', 'Roles & Permissions')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Available Roles</h3>
        <div class="space-y-3">
            @foreach($roles as $role)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                <div>
                    <h4 class="font-medium">{{ ucfirst($role) }}</h4>
                    <p class="text-sm text-gray-600">{{ ucfirst($role) }} role permissions</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800">Edit</button>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">User Role Distribution</h3>
        <div class="space-y-3">
            @foreach($users->groupBy('role') as $role => $roleUsers)
            <div class="flex items-center justify-between">
                <span class="text-gray-600">{{ ucfirst($role) }}</span>
                <span class="font-semibold">{{ $roleUsers->count() }} users</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection