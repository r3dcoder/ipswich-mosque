<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RamadanDailyTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'ramadan_year_id',
        'day',
        'date',
        'hijri_date',
        'sehr_end',
        'fajr',
        'sunrise',
        'dhuhr',
        'asr',
        'maghrib',   // Iftar time
        'isha',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'date'      => 'date',
        'sehr_end'  => 'datetime:H:i',
        'fajr'      => 'datetime:H:i',
        'sunrise'   => 'datetime:H:i',
        'dhuhr'     => 'datetime:H:i',
        'asr'       => 'datetime:H:i',
        'maghrib'   => 'datetime:H:i',
        'isha'      => 'datetime:H:i',
    ];

    /**
     * Relationship with RamadanSetting
     */
    public function ramadanSetting()
    {
        return $this->belongsTo(RamadanSetting::class, 'ramadan_year_id');
    }

    /**
     * Optional: Accessor for formatted Iftar time (most commonly used)
     */
    public function getIftarAttribute()
    {
        return $this->maghrib?->format('H:i');
    }

    /**
     * Optional: Accessor for formatted Sehr time
     */
    public function getSehrAttribute()
    {
        return $this->sehr_end?->format('H:i');
    }
}