<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendTransferNotification
{
    public function handle($event)
    {
        $transfer = $event->transfer;
        $users = User::all();
        
        $subject = match(class_basename($event)) {
            'MaterialTransferRequested' => 'Material Transfer Request Created',
            'MaterialTransferCollected' => 'Material Transfer Items Collected',
            'MaterialTransferCompleted' => 'Material Transfer Completed',
            default => 'Material Transfer Update'
        };

        $message = $this->buildMessage($transfer, $event);

        foreach ($users as $user) {
            Mail::raw($message, function ($mail) use ($user, $subject) {
                $mail->to($user->email)
                     ->subject($subject);
            });
        }
    }

    private function buildMessage($transfer, $event)
    {
        $status = match(class_basename($event)) {
            'MaterialTransferRequested' => 'REQUESTED',
            'MaterialTransferCollected' => 'COLLECTED', 
            'MaterialTransferCompleted' => 'COMPLETED',
            default => 'UPDATED'
        };

        return "Material Transfer Update\n\n" .
               "Transfer Route: " . ucwords(str_replace('-', ' ', $transfer->transfer_route)) . "\n" .
               "Part No: {$transfer->part_no}\n" .
               "SL No: {$transfer->sl_no}\n" .
               "Status: {$status}\n" .
               "Date: " . now()->format('Y-m-d H:i:s') . "\n\n" .
               "Please check the system for more details.";
    }
}