<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Material Transfer Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Edit Transfer Item</h1>
            <a href="{{ route('material-transfer.show', $request->transfer_route) }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Records</a>
        </div>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('material-transfer.update', $request->id) }}">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">S.No.</label>
                        <input type="text" value="{{ $request->sl_no }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reference No.</label>
                        <input type="text" name="ref_no" value="{{ $request->ref_no }}" class="w-full border rounded px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Part No. *</label>
                        <input type="text" name="part_no" value="{{ $request->part_no }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Showroom Requirement *</label>
                        <input type="number" step="0.01" name="showroom_requirement" value="{{ $request->showroom_requirement }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                        <select name="unit" class="w-full border rounded px-3 py-2" required>
                            <option value="Nos" {{ $request->unit == 'Nos' ? 'selected' : '' }}>Nos</option>
                            <option value="Pcs" {{ $request->unit == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="Kg" {{ $request->unit == 'Kg' ? 'selected' : '' }}>Kg</option>
                            <option value="Ltr" {{ $request->unit == 'Ltr' ? 'selected' : '' }}>Ltr</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Allocatable Qty *</label>
                        <input type="number" step="0.01" name="allocatable_qty" value="{{ $request->allocatable_qty }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Actual Qty Received</label>
                        <input type="number" step="0.01" name="actual_qty_received" value="{{ $request->actual_qty_received }}" class="w-full border rounded px-3 py-2">
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="st" value="1" {{ $request->st ? 'checked' : '' }} class="rounded mr-2">
                            ST
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="rt" value="1" {{ $request->rt ? 'checked' : '' }} class="rounded mr-2">
                            RT
                        </label>
                    </div>
                </div>
                
                <div class="mt-6 flex gap-4">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">Update Item</button>
                    <a href="{{ route('material-transfer.show', $request->transfer_route) }}" class="bg-gray-500 text-white px-6 py-2 rounded">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>