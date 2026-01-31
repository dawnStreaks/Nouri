<?php

namespace App\Mail;

use App\Models\MaterialTransferRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransferStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transfer;
    public $statusChange;

    public function __construct(MaterialTransferRequest $transfer, $statusChange)
    {
        $this->transfer = $transfer;
        $this->statusChange = $statusChange;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Material Transfer Status: ' . $this->statusChange,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transfer-status-changed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
