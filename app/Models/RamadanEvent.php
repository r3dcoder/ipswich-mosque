<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RamadanEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'ramadan_year_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
    ];

    /**
     * Relationship with RamadanSetting
     */
    public function ramadanSetting()
    {
        return $this->belongsTo(RamadanSetting::class, 'ramadan_year_id');
    }

    /**
     * Optional: Accessor for formatted full time (e.g. "20:00 - 22:30")
     */
    public function getTimeRangeAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
        }

        return $this->start_time?->format('H:i') ?? 'All Day';
    }
}