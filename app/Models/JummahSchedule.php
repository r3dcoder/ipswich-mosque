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
        'khutbah_time' => 'datetime:H:i',
        'salah_time'   => 'datetime:H:i',
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

    /**
     * Get khutbah time in H:i format for form inputs
     */
    public function getKhutbahTimeForFormAttribute()
    {
        if (!$this->khutbah_time) {
            return null;
        }
        
        // If it's a Carbon instance, format it
        if ($this->khutbah_time instanceof Carbon) {
            return $this->khutbah_time->format('H:i');
        }
        
        // If it's a string, parse and format it
        try {
            return Carbon::parse($this->khutbah_time)->format('H:i');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get salah time in H:i format for form inputs
     */
    public function getSalahTimeForFormAttribute()
    {
        if (!$this->salah_time) {
            return null;
        }
        
        // If it's a Carbon instance, format it
        if ($this->salah_time instanceof Carbon) {
            return $this->salah_time->format('H:i');
        }
        
        // If it's a string, parse and format it
        try {
            return Carbon::parse($this->salah_time)->format('H:i');
        } catch (\Exception $e) {
            return null;
        }
    }
}

