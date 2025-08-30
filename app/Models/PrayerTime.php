<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'day',
        'fajr_begins', 'fajr_jamaat', 'sunrise',
        'zuhr_begins', 'zuhr_jamaat',
        'asr_begins', 'asr_jamaat',
        'maghrib_begins', 'maghrib_jamaat',
        'isha_begins', 'isha_jamaat',
        'hijri_date', 'hijri_month', 'hijri_year', 'month'
    ];
}
