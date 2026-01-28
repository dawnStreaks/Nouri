<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Transfer Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            <i class="fas fa-exchange-alt text-blue-600 mr-2"></i>
                            {{ ucwords(str_replace('-', ' ', $route)) }} Records
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">Manage and track transfer requests</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-user mr-1"></i>
                            {{ auth()->user()->name }} 
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs ml-1">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-cog mr-1"></i>Admin Access
                            </a>
                            <a href="{{ route('material-transfer.create', $route) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-plus mr-1"></i>Add New
                            </a>
                        @endif
                        <a href="{{ route('material-transfer.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            <i class="fas fa-arrow-left mr-1"></i>Back
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-sign-out-alt mr-1"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                <button onclick="filterByStatus('all')" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition cursor-pointer text-left">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-list text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Total Requests</p>
                            <p class="text-xl font-semibold">{{ $totalRequests }}</p>
                        </div>
                    </div>
                </button>
                <button onclick="filterByStatus('approved')" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition cursor-pointer text-left">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Approved</p>
                            <p class="text-xl font-semibold">{{ $approvedRequests }}</p>
                        </div>
                    </div>
                </button>
                <button onclick="filterByStatus('pending')" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition cursor-pointer text-left">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-xl font-semibold">{{ $pendingRequests }}</p>
                        </div>
                    </div>
                </button>
                <button onclick="filterByStatus('ready_for_collection')" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition cursor-pointer text-left">
                    <div class="flex items-center">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <i class="fas fa-box text-indigo-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Ready</p>
                            <p class="text-xl font-semibold">{{ $readyForCollection }}</p>
                        </div>
                    </div>
                </button>
                <button onclick="filterByStatus('collected')" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition cursor-pointer text-left">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <i class="fas fa-hand-holding text-orange-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Collected</p>
                            <p class="text-xl font-semibold">{{ $collected }}</p>
                        </div>
                    </div>
                </button>
                <button onclick="filterByStatus('completed')" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition cursor-pointer text-left">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <i class="fas fa-check-circle text-purple-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Completed</p>
                            <p class="text-xl font-semibold">{{ $completed }}</p>
                        </div>
                    </div>
                </button>
            </div>

            <!-- Data Table -->
            <div class="space-y-4">
                @foreach($groupedRequests as $group)
                    @php
                        $header = $group->first();
                        $groupApproved = $group->every(function ($item) { return $item->is_approved; });
                    @endphp
                    <details class="bg-white rounded-lg shadow overflow-hidden" @if($loop->first) open @endif data-group-index="{{ $loop->index }}">
                        <summary class="px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4 cursor-pointer">
                            <div class="flex flex-wrap items-center gap-6">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Ref No.</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $header->ref_no ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Voucher No.</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $header->transfer_voucher_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Date</p>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $header->transfer_date ? (is_string($header->transfer_date) ? $header->transfer_date : $header->transfer_date->format('Y-m-d')) : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Company</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $header->company_name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <button onclick="event.stopPropagation(); editGroup({{ $loop->index }})" class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs transition group-edit-btn-{{ $loop->index }}">
                                    <i class="fas fa-edit mr-1"></i>Edit All
                                </button>
                                <button onclick="event.stopPropagation(); saveGroup({{ $loop->index }})" class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs transition group-save-btn-{{ $loop->index }}" style="display:none">
                                    <i class="fas fa-save mr-1"></i>Save All
                                </button>
                                <button onclick="event.stopPropagation(); cancelGroup({{ $loop->index }})" class="inline-flex items-center px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-md text-xs transition group-cancel-btn-{{ $loop->index }}" style="display:none">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </button>
                                <button onclick="event.stopPropagation(); printGroup({{ $loop->index }})" class="inline-flex items-center px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-xs transition">
                                    <i class="fas fa-print mr-1"></i>Print
                                </button>
                                @if(!$groupApproved && auth()->user()->role === 'admin')
                                    <form method="POST" action="{{ route('material-transfer.approve-group') }}" class="inline" onclick="event.stopPropagation();">
                                        @csrf
                                        @foreach($group as $item)
                                            <input type="hidden" name="ids[]" value="{{ $item->id }}">
                                        @endforeach
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs transition">
                                            <i class="fas fa-check mr-1"></i>Approve All
                                        </button>
                                    </form>
                                @endif
                                @if(auth()->user()->role === 'store' && $groupApproved && $group->every(fn($i) => $i->actual_qty_received && $i->collection_status !== 'collected'))
                                    <form method="POST" action="{{ route('material-transfer.collect-group') }}" class="inline" onclick="event.stopPropagation();">
                                        @csrf
                                        @foreach($group as $item)
                                            <input type="hidden" name="ids[]" value="{{ $item->id }}">
                                        @endforeach
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded-md text-xs transition">
                                            <i class="fas fa-hand-holding mr-1"></i>Ready All
                                        </button>
                                    </form>
                                @endif
                                @if(auth()->user()->role === 'delivery' && $group->every(fn($i) => $i->collection_status === 'collected'))
                                    <form method="POST" action="{{ route('material-transfer.received-group') }}" class="inline" onclick="event.stopPropagation();">
                                        @csrf
                                        @foreach($group as $item)
                                            <input type="hidden" name="ids[]" value="{{ $item->id }}">
                                        @endforeach
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs transition">
                                            <i class="fas fa-check-circle mr-1"></i>Receive All
                                        </button>
                                    </form>
                                @endif
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                    <i class="fas fa-layer-group mr-1"></i>{{ $group->count() }} Items
                                </span>
                                @if($groupApproved)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @endif
                            </div>
                        </summary>
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Ref No.</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">SL No.</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">Company</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">Part No.</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Req. Qty</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">Unit</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Alloc. Qty</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Actual Qty</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">ST</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">RT</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($group as $request)
                                        <tr class="hover:bg-gray-50" data-id="{{ $request->id }}">
                                            <td class="px-6 py-6 text-sm font-medium text-gray-900" data-field="ref_no">{{ $request->ref_no ?? '-' }}</td>
                                            <td class="px-6 py-6 text-sm text-gray-900">{{ $request->sl_no }}</td>
                                            <td class="px-6 py-6 text-sm text-gray-900" data-field="transfer_date">{{ $request->transfer_date ? (is_string($request->transfer_date) ? $request->transfer_date : $request->transfer_date->format('Y-m-d')) : '-' }}</td>
                                            <td class="px-6 py-6 text-sm text-gray-900" data-field="company_name">{{ $request->company_name ?? '-' }}</td>
                                            <td class="px-6 py-6 text-sm font-medium text-blue-600" data-field="part_no">{{ $request->part_no }}</td>
                                            <td class="px-6 py-6 text-sm text-gray-900" data-field="showroom_requirement">{{ number_format($request->showroom_requirement, 2) }}</td>
                                            <td class="px-6 py-6 text-sm text-gray-900" data-field="unit">
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $request->unit }}</span>
                                            </td>
                                            <td class="px-6 py-6 text-sm text-gray-900" data-field="allocatable_qty">{{ number_format($request->allocatable_qty, 2) }}</td>
                                            <td class="px-6 py-6 text-sm text-gray-900" data-field="actual_qty_received">{{ $request->actual_qty_received ? number_format($request->actual_qty_received, 2) : '-' }}</td>
                                            <td class="px-6 py-6 text-sm" data-field="st">
                                                @if($request->st)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                        <i class="fas fa-check mr-1"></i>Yes
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">
                                                        <i class="fas fa-times mr-1"></i>No
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-6 text-sm" data-field="rt">
                                                @if($request->rt)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                        <i class="fas fa-check mr-1"></i>Yes
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">
                                                        <i class="fas fa-times mr-1"></i>No
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-6">
                                                @if($request->is_approved)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-100 text-green-800 approval-status" data-status="approved">
                                                        <i class="fas fa-check-circle mr-1"></i>Approved
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800 approval-status" data-status="pending">
                                                        <i class="fas fa-clock mr-1"></i>Pending
                                                    </span>
                                                @endif
                                                <span class="collection-status" data-status="{{ $request->collection_status }}"></span>
                                            </td>
                                            <td class="px-6 py-6">
                                                <div class="flex items-center space-x-2 flex-wrap gap-2">
                                                    @if(auth()->user()->role === 'delivery' && $request->is_approved && !$request->st)
                                                        <form method="POST" action="{{ route('material-transfer.ready-for-collection', $request->id) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition">
                                                                <i class="fas fa-box mr-1"></i>Ready for Collection
                                                            </button>
                                                        </form>
                                                    @elseif(auth()->user()->role === 'delivery')
                                                        @if($request->collection_status === 'collected')
                                                            <form method="POST" action="{{ route('material-transfer.received', $request->id) }}" class="inline">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 transition">
                                                                    <i class="fas fa-check-circle mr-1"></i>Received
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <button onclick="editRow({{ $request->id }})" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700 transition edit-btn">
                                                            <i class="fas fa-edit mr-1"></i>Edit
                                                        </button>
                                                        <button onclick="saveRow({{ $request->id }})" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 transition save-btn" style="display:none">
                                                            <i class="fas fa-save mr-1"></i>Save
                                                        </button>
                                                        <button onclick="cancelEdit({{ $request->id }})" class="inline-flex items-center px-3 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700 transition cancel-btn" style="display:none">
                                                            <i class="fas fa-times mr-1"></i>Cancel
                                                        </button>
                                                    @endif
                                                    <button onclick="printMemo({{ $request->id }})" class="inline-flex items-center px-3 py-2 bg-purple-600 text-white rounded-md text-sm hover:bg-purple-700 transition">
                                                        <i class="fas fa-print mr-1"></i>Print
                                                    </button>
                                                    @if(!$request->is_approved && auth()->user()->role === 'admin' && $request->allocatable_qty)
                                                        <form method="POST" action="{{ route('material-transfer.approve', $request->id) }}" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="approved_by" value="{{ auth()->user()->name }}">
                                                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 transition">
                                                                <i class="fas fa-check mr-1"></i>Approve
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if(auth()->user()->role === 'store' && $request->actual_qty_received && $request->collection_status !== 'collected')
                                                        <form method="POST" action="{{ route('material-transfer.collect', $request->id) }}" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="collected_by" value="{{ auth()->user()->name }}">
                                                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-orange-600 text-white rounded-md text-sm hover:bg-orange-700 transition">
                                                                <i class="fas fa-hand-holding mr-1"></i>Ready for Collection
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if(auth()->user()->role === 'admin' && $request->collection_status === 'completed' && !$request->is_completed)
                                                <form method="POST" action="{{ route('material-transfer.finish', $request->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700 transition">
                                                        <i class="fas fa-check-double mr-1"></i>Complete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function filterByStatus(status) {
            const allDetails = document.querySelectorAll('details');
            
            allDetails.forEach(detail => {
                const rows = detail.querySelectorAll('tbody tr');
                let hasVisibleRows = false;
                
                rows.forEach(row => {
                    const approvalStatus = row.querySelector('.approval-status')?.dataset.status;
                    const collectionStatus = row.querySelector('.collection-status')?.dataset.status;
                    
                    let shouldShow = false;
                    
                    if (status === 'all') {
                        shouldShow = true;
                    } else if (status === 'approved') {
                        shouldShow = approvalStatus === 'approved';
                    } else if (status === 'pending') {
                        shouldShow = approvalStatus === 'pending';
                    } else if (status === 'ready_for_collection' || status === 'collected' || status === 'completed') {
                        shouldShow = collectionStatus === status;
                    }
                    
                    row.style.display = shouldShow ? '' : 'none';
                    if (shouldShow) hasVisibleRows = true;
                });
                
                detail.style.display = hasVisibleRows ? '' : 'none';
            });
        }

        function editGroup(groupIndex) {
            const details = document.querySelector(`details[data-group-index="${groupIndex}"]`);
            const rows = details.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const id = row.getAttribute('data-id');
                editRow(id);
            });
            
            details.querySelector(`.group-edit-btn-${groupIndex}`).style.display = 'none';
            details.querySelector(`.group-save-btn-${groupIndex}`).style.display = 'inline-flex';
            details.querySelector(`.group-cancel-btn-${groupIndex}`).style.display = 'inline-flex';
        }

        function saveGroup(groupIndex) {
            const details = document.querySelector(`details[data-group-index="${groupIndex}"]`);
            const rows = details.querySelectorAll('tbody tr');
            let completed = 0;
            
            rows.forEach(row => {
                const id = row.getAttribute('data-id');
                const formData = new FormData();
                
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT');
                
                row.querySelectorAll('td[data-field]').forEach(cell => {
                    const field = cell.getAttribute('data-field');
                    const input = cell.querySelector('input, select');
                    if (input) {
                        formData.append(field, input.value);
                    }
                });
                
                fetch(`{{ url('/') }}/update/${id}`, {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (response.ok) {
                        completed++;
                        if (completed === rows.length) {
                            location.reload();
                        }
                    }
                });
            });
        }

        function cancelGroup(groupIndex) {
            location.reload();
        }

        function printGroup(groupIndex) {
            const details = document.querySelector(`details[data-group-index="${groupIndex}"]`);
            const rows = details.querySelectorAll('tbody tr');
            const items = [];
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                items.push({
                    refNo: cells[0].textContent.trim(),
                    slNo: cells[1].textContent.trim(),
                    date: cells[2].textContent.trim(),
                    company: cells[3].textContent.trim(),
                    partNo: cells[4].textContent.trim(),
                    showroomReq: cells[5].textContent.trim(),
                    unit: cells[6].textContent.trim(),
                    allocatableQty: cells[7].textContent.trim(),
                    actualQty: cells[8].textContent.trim(),
                    st: cells[9].textContent.includes('Yes') ? '✓' : '',
                    rt: cells[10].textContent.includes('Yes') ? '✓' : '',
                    status: cells[11].textContent.trim()
                });
            });
            
            const printWindow = window.open('', '_blank');
            let tableRows = '';
            items.forEach(item => {
                tableRows += `
                    <tr>
                        <td>${item.slNo}</td>
                        <td>${item.partNo}</td>
                        <td>${item.showroomReq}</td>
                        <td>${item.unit}</td>
                        <td>${item.allocatableQty}</td>
                        <td>${item.actualQty}</td>
                        <td>${item.st}</td>
                        <td>${item.rt}</td>
                        <td>${item.status}</td>
                    </tr>
                `;
            });
            
            printWindow.document.write(`
                <html>
                <head>
                    <title>Material Transfer Request - Group</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
                        .info { margin-bottom: 20px; }
                        .info-table { width: 100%; margin-bottom: 20px; }
                        .info-table td { padding: 5px; }
                        .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        .items-table th, .items-table td { border: 1px solid #333; padding: 8px; text-align: left; font-size: 12px; }
                        .items-table th { background-color: #f5f5f5; font-weight: bold; }
                        .footer { margin-top: 40px; text-align: right; font-size: 12px; color: #666; }
                        @media print { body { margin: 0; } }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Material Transfer Request</h1>
                        <h3>{{ ucwords(str_replace('-', ' ', $route)) }} Transfer</h3>
                    </div>
                    <div class="info">
                        <table class="info-table">
                            <tr>
                                <td><strong>Reference No:</strong></td>
                                <td>${items[0].refNo}</td>
                                <td><strong>Date:</strong></td>
                                <td>${items[0].date}</td>
                            </tr>
                            <tr>
                                <td><strong>Company:</strong></td>
                                <td colspan="3">${items[0].company}</td>
                            </tr>
                        </table>
                    </div>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Part No.</th>
                                <th>Req. Qty</th>
                                <th>Unit</th>
                                <th>Alloc. Qty</th>
                                <th>Actual Qty</th>
                                <th>ST</th>
                                <th>RT</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tableRows}
                        </tbody>
                    </table>
                    <div class="footer">
                        <p>Total Items: ${items.length}</p>
                        <p>Generated on: ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}</p>
                        <p>Generated by: {{ auth()->user()->name }}</p>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        function editRow(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const cells = row.querySelectorAll('td[data-field]');
            const userRole = '{{ auth()->user()->role }}';
            
            cells.forEach(cell => {
                const field = cell.getAttribute('data-field');
                const value = cell.textContent.trim();
                
                // ST and RT are always read-only (controlled by buttons)
                if (field === 'st' || field === 'rt') {
                    cell.classList.add('bg-gray-100');
                    return;
                }
                
                // For store users, only allow editing actual_qty_received
                if (userRole === 'store' && field !== 'actual_qty_received') {
                    cell.classList.add('bg-gray-100');
                    return;
                }
                
                if (field === 'unit') {
                    cell.innerHTML = `<select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Nos" ${value === 'Nos' ? 'selected' : ''}>Nos</option>
                        <option value="Pcs" ${value === 'Pcs' ? 'selected' : ''}>Pcs</option>
                        <option value="Kg" ${value === 'Kg' ? 'selected' : ''}>Kg</option>
                        <option value="Ltr" ${value === 'Ltr' ? 'selected' : ''}>Ltr</option>
                    </select>`;
                } else if (field === 'showroom_requirement' || field === 'allocatable_qty' || field === 'actual_qty_received') {
                    const val = value === '-' ? '' : value.replace(/,/g, '');
                    cell.innerHTML = `<input type="number" step="0.01" value="${val}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">`;
                } else if (field === 'transfer_date') {
                    const val = value === '-' ? '' : value;
                    cell.innerHTML = `<input type="date" value="${val}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">`;
                } else {
                    const val = value === '-' ? '' : value;
                    cell.innerHTML = `<input type="text" value="${val}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">`;
                }
            });
            
            row.querySelector('.edit-btn').style.display = 'none';
            row.querySelector('.save-btn').style.display = 'inline-flex';
            row.querySelector('.cancel-btn').style.display = 'inline-flex';
        }

        function saveRow(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const formData = new FormData();
            const userRole = '{{ auth()->user()->role }}';
            
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');
            
            row.querySelectorAll('td[data-field]').forEach(cell => {
                const field = cell.getAttribute('data-field');
                let value;
                
                if (field === 'st' || field === 'rt') {
                    const checkbox = cell.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        value = checkbox.checked ? '1' : '0';
                        formData.append(field, value);
                    }
                } else {
                    const input = cell.querySelector('input, select');
                    if (input) {
                        formData.append(field, input.value);
                    }
                }
            });
            
            fetch(`{{ url('/') }}/update/${id}`, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Error updating record');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating record');
            });
        }

        function cancelEdit(id) {
            location.reload();
        }

        function printMemo(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const cells = row.querySelectorAll('td');
            
            const data = {
                refNo: cells[0].textContent.trim(),
                slNo: cells[1].textContent.trim(),
                date: cells[2].textContent.trim(),
                company: cells[3].textContent.trim(),
                partNo: cells[4].textContent.trim(),
                showroomReq: cells[5].textContent.trim(),
                unit: cells[6].textContent.trim(),
                allocatableQty: cells[7].textContent.trim(),
                actualQty: cells[8].textContent.trim(),
                st: cells[9].textContent.includes('Yes') ? '✓' : '',
                rt: cells[10].textContent.includes('Yes') ? '✓' : '',
                status: cells[11].textContent.trim()
            };
            
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Material Transfer Memo</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
                        .memo-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        .memo-table th, .memo-table td { border: 1px solid #333; padding: 12px; text-align: left; }
                        .memo-table th { background-color: #f5f5f5; font-weight: bold; }
                        .footer { margin-top: 40px; text-align: right; font-size: 12px; color: #666; }
                        @media print { body { margin: 0; } }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Material Transfer Request Memo</h1>
                        <h3>{{ ucwords(str_replace('-', ' ', $route)) }} Transfer</h3>
                    </div>
                    <table class="memo-table">
                        <tr><th>Reference No.</th><td>${data.refNo}</td></tr>
                        <tr><th>Serial No.</th><td>${data.slNo}</td></tr>
                        <tr><th>Date</th><td>${data.date}</td></tr>
                        <tr><th>Company</th><td>${data.company}</td></tr>
                        <tr><th>Part No.</th><td>${data.partNo}</td></tr>
                        <tr><th>Showroom Requirement</th><td>${data.showroomReq}</td></tr>
                        <tr><th>Unit</th><td>${data.unit}</td></tr>
                        <tr><th>Allocatable Qty</th><td>${data.allocatableQty}</td></tr>
                        <tr><th>Actual Qty Received</th><td>${data.actualQty}</td></tr>
                        <tr><th>ST</th><td>${data.st}</td></tr>
                        <tr><th>RT</th><td>${data.rt}</td></tr>
                        <tr><th>Status</th><td>${data.status}</td></tr>
                    </table>
                    <div class="footer">
                        <p>Generated on: ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}</p>
                        <p>Generated by: {{ auth()->user()->name }}</p>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>
