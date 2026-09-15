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
        'fitrana',
        'eid_jamat',
        'esha_and_taraweeh',
        'iftar_enabled',
        'iftar_title',
        'iftar_intro',
        'iftar_sponsor_text',
        'iftar_cost',
        'iftar_items',
        'iftar_contact',
    ];

    protected $casts = [
        'start_date'       => 'date',
        'countdown_target' => 'datetime',
        'year'             => 'integer',
        'iftar_enabled'    => 'boolean',
    ];

    public function dailyTimes()
    {
        return $this->hasMany(RamadanDailyTime::class, 'ramadan_year_id');
    }

    public function events()
    {
        return $this->hasMany(RamadanEvent::class, 'ramadan_year_id');
    }

    /**
     * Iftar contribution items as a clean list.
     */
    public function iftarItemsList(): array
    {
        if (!$this->iftar_items) {
            return [];
        }

        return collect(preg_split('/
||
|,/', $this->iftar_items))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->map(fn ($item) => ltrim($item, "•-	 "))
            ->filter()
            ->values()
            ->all();
    }
}
