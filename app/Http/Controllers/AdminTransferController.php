<?php

namespace App\Http\Controllers;

use App\Models\MaterialTransferRequest;
use App\Events\MaterialTransferRequested;
use App\Events\MaterialTransferCompleted;
use Illuminate\Http\Request;

class AdminTransferController extends Controller
{
    public function request(Request $request, $id)
    {
        $transfer = MaterialTransferRequest::findOrFail($id);
        
        if ($transfer->transitionTo('requested', auth()->id(), 'Transfer requested by admin')) {
            event(new MaterialTransferRequested($transfer));
            return back()->with('success', 'Transfer request sent successfully!');
        }
        
        return back()->withErrors(['error' => 'Cannot request this transfer at current status.']);
    }

    public function finish(Request $request, $id)
    {
        $transfer = MaterialTransferRequest::findOrFail($id);
        
        if ($transfer->transitionTo('completed', auth()->id(), 'Transfer completed by admin')) {
            event(new MaterialTransferCompleted($transfer));
            return back()->with('success', 'Transfer completed successfully!');
        }
        
        return back()->withErrors(['error' => 'Cannot complete this transfer at current status.']);
    }
}