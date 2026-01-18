@extends('layouts.admin')
@section('title', 'User Reports')
@section('page-title', 'User Activity Reports')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">User Statistics</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($userStats as $stat)
        <div class="bg-gray-50 p-4 rounded">
            <h4 class="font-medium">{{ ucfirst($stat->role) }}</h4>
            <p class="text-2xl font-bold text-blue-600">{{ $stat->count }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection