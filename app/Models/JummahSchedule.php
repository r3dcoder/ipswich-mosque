<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JummahSchedule extends Model
{
    protected $fillable = [
        'effective_from',
        'effective_till',
        'khutbah_time',
        'salah_time',
        'note',
        'is_active',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_till' => 'date',
        'is_active' => 'boolean',
    ];
}

