<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'visitor_id',
        'name',
        'phone',
        'email',
        'company',
        'category',
        'host_employee',
        'purpose',
        'id_proof_type',
        'id_proof_number',
        'photo',
        'vehicle_number',
        'status'
    ];
}