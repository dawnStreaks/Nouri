@extends('layouts.admin')

@section('title', 'Create Transfer')
@section('page-title', 'Create New Transfer')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('material-transfer.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Transfer Route</label>
                <select name="transfer_route" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">Select Route</option>
                    <option value="store-to-showroom">Store to Showroom</option>
                    <option value="showroom-to-store">Showroom to Store</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                <input type="text" name="company_name" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SL No</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Part No</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Showroom Req</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Allocatable Qty</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr>
                        <td class="px-4 py-2"><input type="number" name="items[0][sl_no]" value="1" class="w-full border rounded px-2 py-1" required></td>
                        <td class="px-4 py-2"><input type="text" name="items[0][part_no]" class="w-full border rounded px-2 py-1" required></td>
                        <td class="px-4 py-2"><input type="number" step="0.01" name="items[0][showroom_requirement]" class="w-full border rounded px-2 py-1" required></td>
                        <td class="px-4 py-2">
                            <select name="items[0][unit]" class="w-full border rounded px-2 py-1" required>
                                <option value="Nos">Nos</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Kg">Kg</option>
                                <option value="Ltr">Ltr</option>
                            </select>
                        </td>
                        <td class="px-4 py-2"><input type="number" step="0.01" name="items[0][allocatable_qty]" class="w-full border rounded px-2 py-1" required></td>
                        <td class="px-4 py-2"><button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Remove</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex gap-4">
            <button type="button" onclick="addRow()" class="bg-blue-500 text-white px-4 py-2 rounded">Add Row</button>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create Transfer</button>
        </div>
    </form>
</div>

<script>
let rowIndex = 1;

function addRow() {
    const tbody = document.getElementById('tableBody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="px-4 py-2"><input type="number" name="items[${rowIndex}][sl_no]" value="${rowIndex + 1}" class="w-full border rounded px-2 py-1" required></td>
        <td class="px-4 py-2"><input type="text" name="items[${rowIndex}][part_no]" class="w-full border rounded px-2 py-1" required></td>
        <td class="px-4 py-2"><input type="number" step="0.01" name="items[${rowIndex}][showroom_requirement]" class="w-full border rounded px-2 py-1" required></td>
        <td class="px-4 py-2">
            <select name="items[${rowIndex}][unit]" class="w-full border rounded px-2 py-1" required>
                <option value="Nos">Nos</option>
                <option value="Pcs">Pcs</option>
                <option value="Kg">Kg</option>
                <option value="Ltr">Ltr</option>
            </select>
        </td>
        <td class="px-4 py-2"><input type="number" step="0.01" name="items[${rowIndex}][allocatable_qty]" class="w-full border rounded px-2 py-1" required></td>
        <td class="px-4 py-2"><button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Remove</button></td>
    `;
    tbody.appendChild(newRow);
    rowIndex++;
}

function removeRow(button) {
    const tbody = document.getElementById('tableBody');
    if (tbody.children.length > 1) {
        button.closest('tr').remove();
    }
}
</script>
@endsection