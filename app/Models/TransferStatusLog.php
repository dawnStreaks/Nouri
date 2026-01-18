<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferStatusLog extends Model
{
    protected $fillable = ['transfer_id', 'status', 'user_id', 'notes'];

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(MaterialTransferRequest::class, 'transfer_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}