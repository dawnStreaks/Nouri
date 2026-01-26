<?php

namespace App\Http\Controllers;

use App\Models\MaterialTransferRequest;
use Illuminate\Http\Request;

class DeliveryTransferController extends Controller
{
    public function receive(Request $request, $id)
    {
        $transfer = MaterialTransferRequest::findOrFail($id);
        
        $transfer->update([
            'rt' => true,
            'collection_status' => 'completed'
        ]);
        
        event(new \App\Events\MaterialTransferReceived($transfer));
        return back()->with('success', 'Items received successfully!');
    }
}