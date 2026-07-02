<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'photo',
    ];

    /**
     * Interact with the vehicle's license plate.
     */
    protected function licensePlate(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }
}
