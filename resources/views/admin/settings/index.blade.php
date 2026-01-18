@extends('layouts.admin')

@section('title', 'System Settings')
@section('page-title', 'System Settings')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Settings Menu -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Settings Categories</h3>
        <nav class="space-y-2">
            <a href="#general" class="block p-2 rounded hover:bg-gray-100 text-blue-600">
                <i class="fas fa-cog mr-2"></i>General Settings
            </a>
            <a href="#notifications" class="block p-2 rounded hover:bg-gray-100">
                <i class="fas fa-bell mr-2"></i>Notifications
            </a>
            <a href="#security" class="block p-2 rounded hover:bg-gray-100">
                <i class="fas fa-shield-alt mr-2"></i>Security
            </a>
            <a href="#email" class="block p-2 rounded hover:bg-gray-100">
                <i class="fas fa-envelope mr-2"></i>Email Settings
            </a>
            <a href="#backup" class="block p-2 rounded hover:bg-gray-100">
                <i class="fas fa-database mr-2"></i>Backup Settings
            </a>
        </nav>
    </div>

    <!-- Settings Content -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-6">General Settings</h3>
        
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Application Name</label>
                <input type="text" value="Material Transfer System" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Transfer Route</label>
                <select class="w-full border border-gray-300 rounded px-3 py-2">
                    <option>Store to Showroom</option>
                    <option>Showroom to Store</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Auto-approve Transfers</label>
                <div class="flex items-center">
                    <input type="checkbox" class="rounded mr-2">
                    <span class="text-sm text-gray-600">Automatically approve transfers below threshold</span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Approval Threshold</label>
                <input type="number" value="1000" class="w-full border border-gray-300 rounded px-3 py-2">
                <p class="text-sm text-gray-500 mt-1">Transfers above this value require manual approval</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Units</label>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox" checked class="rounded mr-2">
                        <span class="text-sm">Nos</span>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" checked class="rounded mr-2">
                        <span class="text-sm">Pcs</span>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" class="rounded mr-2">
                        <span class="text-sm">Kg</span>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" class="rounded mr-2">
                        <span class="text-sm">Ltr</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection