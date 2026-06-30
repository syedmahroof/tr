<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'visitor_name',
        'visitor_email',
        'visitor_company',
        'host_id',
        'date_time',
        'purpose',
        'status',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }
}
