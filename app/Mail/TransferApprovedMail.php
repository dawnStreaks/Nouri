<?php

namespace App\Mail;

use App\Models\MaterialTransferRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransferApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transfer;

    public function __construct(MaterialTransferRequest $transfer)
    {
        $this->transfer = $transfer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Material Transfer Request Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transfer-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
