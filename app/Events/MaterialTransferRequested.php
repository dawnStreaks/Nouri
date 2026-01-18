<?php

namespace App\Events;

use App\Models\MaterialTransferRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MaterialTransferRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transfer;

    public function __construct(MaterialTransferRequest $transfer)
    {
        $this->transfer = $transfer;
    }
}