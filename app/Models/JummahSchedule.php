<?php

namespace App\Models;

use Carbon\Carbon;
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
        'khutbah_time' => 'datetime:H:i:s',
        'salah_time'   => 'datetime:H:i:s',
    ];

    public function getKhutbahFormattedAttribute()
    {
        return $this->khutbah_time
            ? Carbon::parse($this->khutbah_time)->format('h:i A')
            : null;
    }

    public function getSalahFormattedAttribute()
    {
        return $this->salah_time
            ? Carbon::parse($this->salah_time)->format('h:i A')
            : null;
    }
}

