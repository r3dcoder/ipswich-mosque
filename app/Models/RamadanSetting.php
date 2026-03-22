<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RamadanSetting extends Model
{
    protected $fillable = [
        'year', 'start_date', 'title', 'hero_message', 'timetable_image', 'countdown_target'
    ];

    public function dailyTimes()
    {
        return $this->hasMany(RamadanDailyTime::class, 'ramadan_year_id');
    }

    public function events()
    {
        return $this->hasMany(RamadanEvent::class, 'ramadan_year_id');
    }
}