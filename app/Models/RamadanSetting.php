<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RamadanSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'start_date',
        'title',
        'hero_message',
        'countdown_target',
        'timetable_image',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start_date'       => 'date',           // or 'datetime:Y-m-d'
        'countdown_target' => 'datetime',       // because it's datetime-local
        'year'             => 'integer',
    ];

    // Relationships
    public function dailyTimes()
    {
        return $this->hasMany(RamadanDailyTime::class, 'ramadan_year_id');
    }

    public function events()
    {
        return $this->hasMany(RamadanEvent::class, 'ramadan_year_id');
    }
}