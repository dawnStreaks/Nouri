@extends('layouts.admin')
@section('title', 'Backup & Restore')
@section('page-title', 'Backup & Restore')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="text-center p-6 border-2 border-dashed border-gray-300 rounded">
            <i class="fas fa-download text-4xl text-blue-600 mb-4"></i>
            <h3 class="text-lg font-semibold mb-2">Create Backup</h3>
            <p class="text-gray-600 mb-4">Generate a backup of your database</p>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Backup</button>
        </div>
        <div class="text-center p-6 border-2 border-dashed border-gray-300 rounded">
            <i class="fas fa-upload text-4xl text-green-600 mb-4"></i>
            <h3 class="text-lg font-semibold mb-2">Restore Backup</h3>
            <p class="text-gray-600 mb-4">Restore from a backup file</p>
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Restore Backup</button>
        </div>
    </div>
</div>
@endsection