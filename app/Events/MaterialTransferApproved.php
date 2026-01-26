<?php

namespace App\Events;

use App\Models\MaterialTransferRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MaterialTransferApproved
{
    use Dispatchable, SerializesModels;

    public function __construct(public MaterialTransferRequest $transfer) {}
}
