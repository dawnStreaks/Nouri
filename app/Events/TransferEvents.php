<?php

namespace App\Events;

use App\Models\MaterialTransferRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MaterialTransferRequested
{
    use Dispatchable, SerializesModels;

    public function __construct(public MaterialTransferRequest $transfer) {}
}

class MaterialTransferApproved
{
    use Dispatchable, SerializesModels;

    public function __construct(public MaterialTransferRequest $transfer) {}
}

class MaterialTransferReadyForCollection
{
    use Dispatchable, SerializesModels;

    public function __construct(public MaterialTransferRequest $transfer) {}
}

class MaterialTransferCollected
{
    use Dispatchable, SerializesModels;

    public function __construct(public MaterialTransferRequest $transfer) {}
}

class MaterialTransferReceived
{
    use Dispatchable, SerializesModels;

    public function __construct(public MaterialTransferRequest $transfer) {}
}

class MaterialTransferCompleted
{
    use Dispatchable, SerializesModels;

    public function __construct(public MaterialTransferRequest $transfer) {}
}