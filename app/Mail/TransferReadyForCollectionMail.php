<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransferReadyForCollectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $items;
    public $preparedBy;

    public function __construct($items, $preparedBy)
    {
        $this->items = is_array($items) ? $items : [$items];
        $this->preparedBy = $preparedBy;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Material Transfer Ready for Collection',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transfer-ready-for-collection',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
