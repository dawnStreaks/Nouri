<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendTransferNotification
{
    public function handle($event)
    {
        $transfer = $event->transfer;
        $eventType = class_basename($event);
        
        // Determine which roles should receive the email
        $targetRoles = match($eventType) {
            'MaterialTransferRequested' => ['admin'], // Admin request button -> only other admins
            'MaterialTransferApproved' => ['admin', 'store'], // Approve button -> admin and store
            'MaterialTransferCollected' => ['admin', 'delivery'], // Ready for collection -> admin and delivery
            'MaterialTransferReceived' => ['admin'], // Received button -> only admin
            'MaterialTransferCompleted' => ['admin'],
            default => ['admin']
        };
        
        $users = User::whereIn('role', $targetRoles)->get();
        
        $subject = match($eventType) {
            'MaterialTransferRequested' => 'Material Transfer Request Created',
            'MaterialTransferApproved' => 'Material Transfer Request Approved',
            'MaterialTransferCollected' => 'Material Transfer Ready for Collection',
            'MaterialTransferReceived' => 'Material Transfer Received',
            'MaterialTransferCompleted' => 'Material Transfer Completed',
            default => 'Material Transfer Update'
        };

        $message = $this->buildMessage($transfer, $eventType);

        foreach ($users as $user) {
            Mail::raw($message, function ($mail) use ($user, $subject) {
                $mail->to($user->email)
                     ->subject($subject);
            });
        }
    }

    private function buildMessage($transfer, $eventType)
    {
        $status = match($eventType) {
            'MaterialTransferRequested' => 'REQUESTED',
            'MaterialTransferApproved' => 'APPROVED',
            'MaterialTransferCollected' => 'READY FOR COLLECTION',
            'MaterialTransferReceived' => 'RECEIVED',
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