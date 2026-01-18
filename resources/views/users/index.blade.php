<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="w-4/5 mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">User Management</h1>
            <div class="flex gap-2 items-center">
                <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                <a href="{{ route('users.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Add User</a>
                <a href="{{ route('material-transfer.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">User View</a>
                <a href="{{ route('material-transfer.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                </form>
            </div>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded text-xs 
                                    @if($user->role === 'admin') bg-blue-100 text-blue-800
                                    @elseif($user->role === 'store') bg-green-100 text-green-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>