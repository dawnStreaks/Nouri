<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialTransferRequest extends Model
{
    protected $fillable = [
        'transfer_route',
        'ref_no',
        'transfer_date',
        'company_name',
        'transfer_voucher_number',
        'sl_no',
        'part_no',
        'showroom_requirement',
        'unit',
        'allocatable_qty',
        'actual_qty_received',
        'st',
        'rt',
        'is_approved',
        'approved_by',
        'approved_at',
        'collection_status',
        'collected_at',
        'collected_by'
    ];

    protected $casts = [
        'st' => 'boolean',
        'rt' => 'boolean',
        'is_approved' => 'boolean',
        'transfer_date' => 'date',
        'approved_at' => 'datetime',
        'collected_at' => 'datetime',
        'showroom_requirement' => 'decimal:2',
        'allocatable_qty' => 'decimal:2',
        'actual_qty_received' => 'decimal:2'
    ];

    // State Machine Methods
    public function canTransitionTo($status): bool
    {
        $transitions = [
            'pending' => ['requested'],
            'requested' => ['collected'],
            'collected' => ['completed']
        ];
        return in_array($status, $transitions[$this->collection_status] ?? []);
    }

    public function transitionTo($status, $userId, $notes = null): bool
    {
        if (!$this->canTransitionTo($status)) {
            return false;
        }

        $this->update(['collection_status' => $status]);
        $this->statusLogs()->create([
            'status' => $status,
            'user_id' => $userId,
            'notes' => $notes
        ]);

        return true;
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(TransferStatusLog::class, 'transfer_id');
    }
}