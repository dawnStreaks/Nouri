<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8 mx-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Add New User</h2>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Role</label>
                <select name="role" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    <option value="">Select Role</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="store" {{ old('role') === 'store' ? 'selected' : '' }}>Store</option>
                    <option value="delivery" {{ old('role') === 'delivery' ? 'selected' : '' }}>Delivery</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
            </div>
            
            <button type="submit" class="w-full bg-green-500 text-white py-3 px-4 rounded-lg hover:bg-green-600 transition duration-200 font-medium">Create User</button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:text-blue-600 transition duration-200">Back to Users</a>
        </div>
    </div>
</body>
</html>