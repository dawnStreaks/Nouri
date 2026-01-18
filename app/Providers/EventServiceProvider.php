<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\MaterialTransferRequested;
use App\Events\MaterialTransferCollected;
use App\Events\MaterialTransferCompleted;
use App\Listeners\SendTransferNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MaterialTransferRequested::class => [
            SendTransferNotification::class,
        ],
        MaterialTransferCollected::class => [
            SendTransferNotification::class,
        ],
        MaterialTransferCompleted::class => [
            SendTransferNotification::class,
        ],
    ];

    public function boot()
    {
        //
    }
}