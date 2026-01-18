<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Transfer Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate {
            margin: 1rem 0;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }
    </style>
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-list text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Total Records</p>
                            <p class="text-xl font-semibold">{{ $requests->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Approved</p>
                            <p class="text-xl font-semibold">{{ $requests->where('is_approved', true)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-xl font-semibold">{{ $requests->where('is_approved', false)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <i class="fas fa-boxes text-purple-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Total Qty</p>
                            <p class="text-xl font-semibold">{{ number_format($requests->sum('allocatable_qty'), 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Transfer Records</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table id="transferTable" class="w-full divide-y divide-gray-200">
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
                            @foreach($requests as $request)
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
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @endif
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
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#transferTable').DataTable({
                pageLength: 25,
                order: [[2, 'desc'], [1, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [12] }
                ],
                dom: 'Bfrtip',
                responsive: true,
                language: {
                    search: "Search records:",
                    lengthMenu: "Show _MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        });

        function editRow(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const cells = row.querySelectorAll('td[data-field]');
            const userRole = '{{ auth()->user()->role }}';
            
            cells.forEach(cell => {
                const field = cell.getAttribute('data-field');
                const value = cell.textContent.trim();
                
                // For store users, only allow editing actual_qty_received
                if (userRole === 'store' && field !== 'actual_qty_received') {
                    return; // Skip editing this field
                }
                
                if (field === 'unit') {
                    cell.innerHTML = `<select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Nos" ${value === 'Nos' ? 'selected' : ''}>Nos</option>
                        <option value="Pcs" ${value === 'Pcs' ? 'selected' : ''}>Pcs</option>
                        <option value="Kg" ${value === 'Kg' ? 'selected' : ''}>Kg</option>
                        <option value="Ltr" ${value === 'Ltr' ? 'selected' : ''}>Ltr</option>
                    </select>`;
                } else if (field === 'st' || field === 'rt') {
                    const checked = value.includes('Yes') ? 'checked' : '';
                    cell.innerHTML = `<input type="checkbox" ${checked} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">`;
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
            
            fetch(`/update/${id}`, {
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
                st: cells[9].textContent.trim(),
                rt: cells[10].textContent.trim(),
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