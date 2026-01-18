@extends('layouts.admin')
@section('title', 'Suppliers')
@section('page-title', 'Suppliers')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">All Suppliers</h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Supplier</button>
    </div>
    <div class="text-center py-8 text-gray-500">
        <i class="fas fa-truck text-4xl mb-4"></i>
        <p>No suppliers found</p>
    </div>
</div>
@endsection