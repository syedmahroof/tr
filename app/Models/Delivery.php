<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'delivery_id',
        'from_whom',
        'for_whom',
        'company',
        'package_details',
        'status',
        'arrived_at',
        'received_at',
        'collected_at',
        'notes',
    ];

    protected $casts = [
        'arrived_at' => 'datetime',
        'received_at' => 'datetime',
        'collected_at' => 'datetime',
    ];
}
