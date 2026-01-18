<?php

namespace App\Http\Controllers;

use App\Models\MaterialTransferRequest;
use App\Events\MaterialTransferCollected;
use Illuminate\Http\Request;

class StoreTransferController extends Controller
{
    public function updateQuantity(Request $request, $id)
    {
        $transfer = MaterialTransferRequest::findOrFail($id);
        
        $validated = $request->validate([
            'actual_qty_received' => 'required|numeric|min:0'
        ]);

        $transfer->update($validated);
        
        return back()->with('success', 'Quantity updated successfully!');
    }

    public function collect(Request $request, $id)
    {
        $transfer = MaterialTransferRequest::findOrFail($id);
        
        $transfer->update([
            'st' => true,
            'collection_status' => 'collected',
            'collected_by' => auth()->user()->name,
            'collected_at' => now()
        ]);
        
        return back()->with('success', 'Items collected successfully!');
    }
}