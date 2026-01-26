<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransferRequestedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $items;
    public $submittedBy;

    public function __construct($items, $submittedBy)
    {
        $this->items = $items;
        $this->submittedBy = $submittedBy;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Material Transfer Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transfer-requested',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
