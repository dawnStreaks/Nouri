<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col">
            <!-- Logo/Header -->
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-xl font-bold">Admin Panel</h2>
                <p class="text-sm text-gray-300">{{ auth()->user()->name }}</p>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto">
                <ul class="p-4 space-y-2">
                    <!-- Home -->
                    <li>
                        <a href="{{ route('material-transfer.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-home mr-3"></i>
                            Home
                        </a>
                    </li>
                    
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                    </li>

                    <!-- Material Transfer Management -->
                    <li>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-4 mb-2">Transfer Management</div>
                    </li>
                    <li>
                        <a href="{{ route('admin.transfers.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.transfers.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-exchange-alt mr-3"></i>
                            All Transfers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transfers.create') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-plus mr-3"></i>
                            Create Transfer
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transfers.pending') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-clock mr-3"></i>
                            Pending Approvals
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transfers.routes') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-route mr-3"></i>
                            Transfer Routes
                        </a>
                    </li>

                    <!-- User Management -->
                    <li>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-4 mb-2">User Management</div>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-users mr-3"></i>
                            All Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.create') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-user-plus mr-3"></i>
                            Add User
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.roles.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-user-shield mr-3"></i>
                            Roles & Permissions
                        </a>
                    </li>

                    <!-- Inventory Management -->
                    <li>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-4 mb-2">Inventory</div>
                    </li>
                    <li>
                        <a href="{{ route('admin.parts.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-cogs mr-3"></i>
                            Parts Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.inventory.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-warehouse mr-3"></i>
                            Stock Levels
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.suppliers.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-truck mr-3"></i>
                            Suppliers
                        </a>
                    </li>

                    <!-- Company Management -->
                    <li>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-4 mb-2">Company</div>
                    </li>
                    <li>
                        <a href="{{ route('admin.companies.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-building mr-3"></i>
                            Companies
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.departments.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-sitemap mr-3"></i>
                            Departments
                        </a>
                    </li>

                    <!-- Reports & Analytics -->
                    <li>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-4 mb-2">Reports</div>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.transfers') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-chart-bar mr-3"></i>
                            Transfer Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.inventory') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-chart-line mr-3"></i>
                            Inventory Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.users') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-chart-pie mr-3"></i>
                            User Activity
                        </a>
                    </li>

                    <!-- System Settings -->
                    <li>
                        <div class="text-xs text-gray-400 uppercase tracking-wider mt-4 mb-2">System</div>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-cog mr-3"></i>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.logs.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-file-alt mr-3"></i>
                            System Logs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.backup.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-database mr-3"></i>
                            Backup & Restore
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Actions -->
            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full p-2 rounded hover:bg-gray-700 text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            {{ now()->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>