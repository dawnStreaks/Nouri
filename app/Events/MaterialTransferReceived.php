<?php

namespace App\Events;

use App\Models\MaterialTransferRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MaterialTransferReceived
{
    use Dispatchable, SerializesModels;

    public function __construct(public MaterialTransferRequest $transfer) {}
}
