<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Transfer Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">{{ ucwords(str_replace('-', ' ', $route)) }} Transfer</h1>
            <a href="{{ route('material-transfer.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Routes</a>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form id="materialForm" method="POST" action="{{ route('material-transfer.store') }}">
            @csrf
            <input type="hidden" name="transfer_route" value="{{ $route }}">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">SL. No.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Part No.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Showroom Req.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Allocatable Qty</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actual Qty Received</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ST</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">RT</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
                            @forelse($requests as $index => $request)
                                <tr>
                                    <td class="px-4 py-3"><input type="number" name="items[{{ $index }}][sl_no]" value="{{ $request->sl_no }}" class="w-full border rounded px-2 py-1" required></td>
                                    <td class="px-4 py-3"><input type="text" name="items[{{ $index }}][part_no]" value="{{ $request->part_no }}" class="w-full border rounded px-2 py-1" required></td>
                                    <td class="px-4 py-3"><input type="number" step="0.01" name="items[{{ $index }}][showroom_requirement]" value="{{ $request->showroom_requirement }}" class="w-full border rounded px-2 py-1" required></td>
                                    <td class="px-4 py-3">
                                        <select name="items[{{ $index }}][unit]" class="w-full border rounded px-2 py-1" required>
                                            <option value="Nos" {{ $request->unit == 'Nos' ? 'selected' : '' }}>Nos</option>
                                            <option value="Pcs" {{ $request->unit == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                            <option value="Kg" {{ $request->unit == 'Kg' ? 'selected' : '' }}>Kg</option>
                                            <option value="Ltr" {{ $request->unit == 'Ltr' ? 'selected' : '' }}>Ltr</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3"><input type="number" step="0.01" name="items[{{ $index }}][allocatable_qty]" value="{{ $request->allocatable_qty }}" class="w-full border rounded px-2 py-1" required></td>
                                    <td class="px-4 py-3"><input type="number" step="0.01" name="items[{{ $index }}][actual_qty_received]" value="{{ $request->actual_qty_received }}" class="w-full border rounded px-2 py-1"></td>
                                    <td class="px-4 py-3"><input type="checkbox" name="items[{{ $index }}][st]" value="1" {{ $request->st ? 'checked' : '' }} class="rounded"></td>
                                    <td class="px-4 py-3"><input type="checkbox" name="items[{{ $index }}][rt]" value="1" {{ $request->rt ? 'checked' : '' }} class="rounded"></td>
                                    <td class="px-4 py-3"><button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Delete</button></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-3"><input type="number" name="items[0][sl_no]" value="1" class="w-full border rounded px-2 py-1" required></td>
                                    <td class="px-4 py-3"><input type="text" name="items[0][part_no]" class="w-full border rounded px-2 py-1" required></td>
                                    <td class="px-4 py-3"><input type="number" step="0.01" name="items[0][showroom_requirement]" class="w-full border rounded px-2 py-1" required></td>
                                    <td class="px-4 py-3">
                                        <select name="items[0][unit]" class="w-full border rounded px-2 py-1" required>
                                            <option value="Nos">Nos</option>
                                            <option value="Pcs">Pcs</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Ltr">Ltr</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3"><input type="number" step="0.01" name="items[0][allocatable_qty]" class="w-full border rounded px-2 py-1" required></td>
                                    <td class="px-4 py-3"><input type="number" step="0.01" name="items[0][actual_qty_received]" class="w-full border rounded px-2 py-1"></td>
                                    <td class="px-4 py-3"><input type="checkbox" name="items[0][st]" value="1" class="rounded"></td>
                                    <td class="px-4 py-3"><input type="checkbox" name="items[0][rt]" value="1" class="rounded"></td>
                                    <td class="px-4 py-3"><button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Delete</button></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4 flex gap-4">
                <button type="button" onclick="addRow()" class="bg-blue-500 text-white px-4 py-2 rounded">Add Row</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Request</button>
            </div>
        </form>
    </div>

    <script>
        let rowIndex = {{ count($requests) > 0 ? count($requests) : 1 }};
        
        // Auto-increment SL No for new rows
        function getNextSlNo() {
            const slInputs = document.querySelectorAll('input[name*="[sl_no]"]');
            let maxSl = 0;
            slInputs.forEach(input => {
                const val = parseInt(input.value) || 0;
                if (val > maxSl) maxSl = val;
            });
            return maxSl + 1;
        }

        function addRow() {
            const tbody = document.getElementById('tableBody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="px-4 py-3"><input type="number" name="items[${rowIndex}][sl_no]" value="${getNextSlNo()}" class="w-full border rounded px-2 py-1" required></td>
                <td class="px-4 py-3"><input type="text" name="items[${rowIndex}][part_no]" class="w-full border rounded px-2 py-1" required></td>
                <td class="px-4 py-3"><input type="number" step="0.01" name="items[${rowIndex}][showroom_requirement]" class="w-full border rounded px-2 py-1" required></td>
                <td class="px-4 py-3">
                    <select name="items[${rowIndex}][unit]" class="w-full border rounded px-2 py-1" required>
                        <option value="Nos">Nos</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Kg">Kg</option>
                        <option value="Ltr">Ltr</option>
                    </select>
                </td>
                <td class="px-4 py-3"><input type="number" step="0.01" name="items[${rowIndex}][allocatable_qty]" class="w-full border rounded px-2 py-1" required></td>
                <td class="px-4 py-3"><input type="number" step="0.01" name="items[${rowIndex}][actual_qty_received]" class="w-full border rounded px-2 py-1"></td>
                <td class="px-4 py-3"><input type="checkbox" name="items[${rowIndex}][st]" value="1" class="rounded"></td>
                <td class="px-4 py-3"><input type="checkbox" name="items[${rowIndex}][rt]" value="1" class="rounded"></td>
                <td class="px-4 py-3"><button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Delete</button></td>
            `;
            tbody.appendChild(newRow);
            rowIndex++;
        }

        function removeRow(button) {
            const tbody = document.getElementById('tableBody');
            if (tbody.children.length > 1) {
                button.closest('tr').remove();
                updateRowIndices();
            }
        }

        function updateRowIndices() {
            const rows = document.querySelectorAll('#tableBody tr');
            rows.forEach((row, index) => {
                const inputs = row.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                    }
                });
            });
            rowIndex = rows.length;
        }
    </script>
</body>
</html>