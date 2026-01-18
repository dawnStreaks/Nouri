@extends('layouts.admin')
@section('title', 'Departments')
@section('page-title', 'Departments')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">All Departments</h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Department</button>
    </div>
    <div class="text-center py-8 text-gray-500">
        <i class="fas fa-sitemap text-4xl mb-4"></i>
        <p>No departments found</p>
    </div>
</div>
@endsection