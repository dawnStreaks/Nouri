<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTransferRequest extends Model
{
    protected $fillable = [
        'transfer_route',
        'ref_no',
        'transfer_date',
        'company_name',
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
        'approved_at'
    ];

    protected $casts = [
        'st' => 'boolean',
        'rt' => 'boolean',
        'is_approved' => 'boolean',
        'transfer_date' => 'date',
        'approved_at' => 'datetime',
        'showroom_requirement' => 'decimal:2',
        'allocatable_qty' => 'decimal:2',
        'actual_qty_received' => 'decimal:2'
    ];
}