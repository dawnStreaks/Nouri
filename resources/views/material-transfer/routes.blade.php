<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Transfer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="w-4/5 mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Material Transfer Dashboard</h1>
            <div class="flex gap-2 items-center">
                <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Admin Access</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                </form>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $colors = ['blue', 'green', 'purple', 'orange', 'red', 'indigo'];
                $userRole = auth()->user()->role;
            @endphp
            @foreach($routeStats as $routeKey => $stats)
                @php
                    $color = $colors[$loop->index % count($colors)];
                    $highlight = false;
                    $highlightCount = 0;
                    $highlightLabel = '';
                    
                    if ($userRole === 'admin' && $stats['pending'] > 0) {
                        $highlight = true;
                        $highlightCount = $stats['pending'];
                        $highlightLabel = 'Pending Approval';
                    } elseif ($userRole === 'store' && $stats['awaitingCollection'] > 0) {
                        $highlight = true;
                        $highlightCount = $stats['awaitingCollection'];
                        $highlightLabel = 'Ready to Mark';
                    } elseif ($userRole === 'delivery' && $stats['collected'] > 0) {
                        $highlight = true;
                        $highlightCount = $stats['collected'];
                        $highlightLabel = 'Ready to Receive';
                    }
                @endphp
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 {{ $highlight ? 'ring-4 ring-yellow-400 animate-pulse' : '' }}">
                    <div class="bg-{{ $color }}-500 text-white p-4 relative">
                        <h3 class="text-lg font-semibold">{{ $stats['name'] }}</h3>
                        @if($highlight)
                            <span class="absolute top-2 right-2 bg-yellow-400 text-gray-900 px-2 py-1 rounded-full text-xs font-bold">
                                {{ $highlightCount }} {{ $highlightLabel }}
                            </span>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                                <div class="text-xs text-gray-600">Total</div>
                            </div>
                            <div class="text-center {{ $userRole === 'admin' && $stats['pending'] > 0 ? 'bg-yellow-100 rounded p-1' : '' }}">
                                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                                <div class="text-xs text-gray-600">Pending</div>
                            </div>
                            <div class="text-center {{ $userRole === 'store' && $stats['awaitingCollection'] > 0 ? 'bg-green-100 rounded p-1' : '' }}">
                                <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
                                <div class="text-xs text-gray-600">Approved</div>
                            </div>
                        </div>
                        @if($userRole === 'delivery')
                            <div class="text-center mb-4 {{ $stats['collected'] > 0 ? 'bg-orange-100 rounded p-2' : '' }}">
                                <div class="text-2xl font-bold text-orange-600">{{ $stats['collected'] }}</div>
                                <div class="text-xs text-gray-600">Ready for Delivery</div>
                            </div>
                        @endif
                        <div class="flex gap-2">
                            <a href="{{ route('material-transfer.show', $routeKey) }}" 
                               class="flex-1 bg-{{ $color }}-500 hover:bg-{{ $color }}-600 text-white text-center py-2 px-4 rounded transition duration-200">
                                View Records
                            </a>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('material-transfer.create', $routeKey) }}" 
                                   class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded transition duration-200">
                                    Add New
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>