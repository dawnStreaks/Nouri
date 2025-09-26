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
</head>
<body class="bg-gray-100 p-6">
    <div class="w-4/5 mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">{{ ucwords(str_replace('-', ' ', $route)) }} Transfer Records</h1>
            <div class="flex gap-2">
                <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}</span>
                <a href="{{ route('material-transfer.create', $route) }}" class="bg-green-500 text-white px-4 py-2 rounded">Add New</a>
                <a href="{{ route('material-transfer.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Routes</a>
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

            
            <div class="overflow-x-auto">
                <table id="transferTable" class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ref No.</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">SL. No.</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Part No.</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Showroom Req.</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Allocatable Qty</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actual Qty</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">ST</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">RT</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Approved By</th>
                            <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                        <tr>
                            <th class="px-6 py-2">
                                <input type="text" placeholder="Filter..." class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="0">
                            </th>
                            <th class="px-6 py-2">
                                <input type="text" placeholder="Filter..." class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="1">
                            </th>
                            <th class="px-6 py-2">
                                <input type="date" class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="2">
                            </th>
                            <th class="px-6 py-2">
                                <input type="text" placeholder="Filter..." class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="3">
                            </th>
                            <th class="px-6 py-2">
                                <input type="text" placeholder="Filter..." class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="4">
                            </th>
                            <th class="px-6 py-2">
                                <input type="text" placeholder="Filter..." class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="5">
                            </th>
                            <th class="px-6 py-2">
                                <select class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="6">
                                    <option value="">All</option>
                                    <option value="Nos">Nos</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Kg">Kg</option>
                                    <option value="Ltr">Ltr</option>
                                </select>
                            </th>
                            <th class="px-6 py-2">
                                <input type="text" placeholder="Filter..." class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="7">
                            </th>
                            <th class="px-6 py-2">
                                <input type="text" placeholder="Filter..." class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="8">
                            </th>
                            <th class="px-6 py-2">
                                <select class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="9">
                                    <option value="">All</option>
                                    <option value="✓">Yes</option>
                                    <option value="✗">No</option>
                                </select>
                            </th>
                            <th class="px-6 py-2">
                                <select class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="10">
                                    <option value="">All</option>
                                    <option value="✓">Yes</option>
                                    <option value="✗">No</option>
                                </select>
                            </th>
                            <th class="px-6 py-2">
                                <select class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="11">
                                    <option value="">All</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                </select>
                            </th>
                            <th class="px-6 py-2">
                                <input type="text" placeholder="Filter..." class="w-full border rounded px-2 py-1 text-xs filter-input" data-column="12">
                            </th>
                            <th class="px-6 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($requests as $request)
                            <tr data-id="{{ $request->id }}">
                                <td class="px-6 py-4 text-sm" data-field="ref_no">{{ $request->ref_no ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $request->sl_no }}</td>
                                <td class="px-6 py-4 text-sm" data-field="transfer_date">{{ $request->transfer_date ? (is_string($request->transfer_date) ? $request->transfer_date : $request->transfer_date->format('Y-m-d')) : '-' }}</td>
                                <td class="px-6 py-4 text-sm" data-field="company_name">{{ $request->company_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm" data-field="part_no">{{ $request->part_no }}</td>
                                <td class="px-6 py-4 text-sm" data-field="showroom_requirement">{{ $request->showroom_requirement }}</td>
                                <td class="px-6 py-4 text-sm" data-field="unit">{{ $request->unit }}</td>
                                <td class="px-6 py-4 text-sm" data-field="allocatable_qty">{{ $request->allocatable_qty }}</td>
                                <td class="px-6 py-4 text-sm" data-field="actual_qty_received">{{ $request->actual_qty_received }}</td>
                                <td class="px-6 py-4 text-sm" data-field="st">{{ $request->st ? '✓' : '✗' }}</td>
                                <td class="px-6 py-4 text-sm" data-field="rt">{{ $request->rt ? '✓' : '✗' }}</td>
                                <td class="px-6 py-4">
                                    @if($request->is_approved)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Approved</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $request->approved_by ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-1 flex-wrap">
                                        <button onclick="editRow({{ $request->id }})" class="bg-blue-500 text-white px-2 py-1 rounded text-xs edit-btn">Edit</button>
                                        <button onclick="saveRow({{ $request->id }})" class="bg-green-500 text-white px-2 py-1 rounded text-xs save-btn" style="display:none">Save</button>
                                        <button onclick="cancelEdit({{ $request->id }})" class="bg-gray-500 text-white px-2 py-1 rounded text-xs cancel-btn" style="display:none">Cancel</button>
                                        <button onclick="printMemo({{ $request->id }})" class="bg-purple-500 text-white px-2 py-1 rounded text-xs">Print</button>
                                        @if(!$request->is_approved)
                                            <form method="POST" action="{{ route('material-transfer.approve', $request->id) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="approved_by" value="{{ auth()->user()->name }}">
                                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs">Approve</button>
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

    <script>
        $(document).ready(function() {
            var table = $('#transferTable').DataTable({
                pageLength: 25,
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [13] }
                ]
            });

            $('.filter-input').on('keyup change', function() {
                var column = $(this).data('column');
                var value = this.value;
                
                if (column === 6 || column === 9 || column === 10 || column === 11) {
                    // Exact match for dropdowns
                    table.column(column).search(value ? '^' + value + '$' : '', true, false).draw();
                } else {
                    // Partial match for text inputs
                    table.column(column).search(value).draw();
                }
            });
        });

        function editRow(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const cells = row.querySelectorAll('td[data-field]');
            
            cells.forEach(cell => {
                const field = cell.getAttribute('data-field');
                const value = cell.textContent.trim();
                
                if (field === 'unit') {
                    cell.innerHTML = `<select class="w-full border rounded px-3 py-2 text-sm">
                        <option value="Nos" ${value === 'Nos' ? 'selected' : ''}>Nos</option>
                        <option value="Pcs" ${value === 'Pcs' ? 'selected' : ''}>Pcs</option>
                        <option value="Kg" ${value === 'Kg' ? 'selected' : ''}>Kg</option>
                        <option value="Ltr" ${value === 'Ltr' ? 'selected' : ''}>Ltr</option>
                    </select>`;
                } else if (field === 'st' || field === 'rt') {
                    const checked = value === '✓' ? 'checked' : '';
                    cell.innerHTML = `<input type="checkbox" ${checked} class="rounded">`;
                } else if (field === 'showroom_requirement' || field === 'allocatable_qty' || field === 'actual_qty_received') {
                    const val = value === '-' ? '' : value;
                    cell.innerHTML = `<input type="number" step="0.01" value="${val}" class="w-full border rounded px-3 py-2 text-sm">`;
                } else if (field === 'transfer_date') {
                    const val = value === '-' ? '' : value;
                    cell.innerHTML = `<input type="date" value="${val}" class="w-full border rounded px-3 py-2 text-sm">`;
                } else {
                    const val = value === '-' ? '' : value;
                    cell.innerHTML = `<input type="text" value="${val}" class="w-full border rounded px-3 py-2 text-sm">`;
                }
            });
            
            row.querySelector('.edit-btn').style.display = 'none';
            row.querySelector('.save-btn').style.display = 'inline-block';
            row.querySelector('.cancel-btn').style.display = 'inline-block';
        }

        function saveRow(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const formData = new FormData();
            
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');
            
            row.querySelectorAll('td[data-field]').forEach(cell => {
                const field = cell.getAttribute('data-field');
                let value;
                
                if (field === 'st' || field === 'rt') {
                    value = cell.querySelector('input[type="checkbox"]').checked ? '1' : '0';
                } else {
                    const input = cell.querySelector('input, select');
                    value = input ? input.value : '';
                }
                
                formData.append(field, value);
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
                status: cells[11].textContent.trim(),
                approvedBy: cells[12].textContent.trim()
            };
            
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Material Transfer Memo</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; margin-bottom: 30px; }
                        .memo-table { width: 100%; border-collapse: collapse; }
                        .memo-table th, .memo-table td { border: 1px solid #000; padding: 8px; text-align: left; }
                        .memo-table th { background-color: #f0f0f0; }
                        @media print { body { margin: 0; } }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h2>Material Transfer Request Memo</h2>
                        <p>{{ ucwords(str_replace('-', ' ', $route)) }} Transfer</p>
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
                        <tr><th>Approved By</th><td>${data.approvedBy}</td></tr>
                    </table>
                    <div style="margin-top: 30px; text-align: right;">
                        <p>Generated on: ${new Date().toLocaleDateString()}</p>
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