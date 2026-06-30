<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'vehicle_id',
        'owner_name',
        'owner_type',
        'license_plate',
        'make',
        'model',
        'color',
        'status',
        'notes',
    ];
}
