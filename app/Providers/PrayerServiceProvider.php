<?php

namespace App\Providers;

use App\Models\JummahSchedule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\PrayerTime;

class PrayerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $today = Carbon::now()->day;
            $month = Carbon::now()->format('M'); // e.g. Aug, Sep...

            $prayer = PrayerTime::where('date', $today)
                ->where('month', $month)
                ->first();

            $dailyPrayerHeader = null;

            if ($prayer) {
                $prayers = [
                    'Sunrise' => ['Begins' => $prayer->sunrise,        'Jamaat' => null],
                    'Fajr'    => ['Begins' => $prayer->fajr_begins,    'Jamaat' => $prayer->fajr_jamaat],
                    'Zuhr'    => ['Begins' => $prayer->zuhr_begins,    'Jamaat' => $prayer->zuhr_jamaat],
                    'Asr'     => ['Begins' => $prayer->asr_begins,     'Jamaat' => $prayer->asr_jamaat],
                    'Maghrib' => ['Begins' => $prayer->maghrib_begins, 'Jamaat' => $prayer->maghrib_jamaat],
                    'Isha'    => ['Begins' => $prayer->isha_begins,    'Jamaat' => $prayer->isha_jamaat],
                ];

                $now = Carbon::now();
                $highlightedPrayer = null;

                $names = array_keys($prayers);

                foreach ($names as $i => $name) {
                    $begin = str_replace('.', ':', $prayers[$name]['Begins']); // begin: "4:37"
                
                    if ($name === 'Fajr') {
                        $begin .= ' AM';
                    } elseif ($name === 'Zuhr' && (float) $begin < 12) {
                        $begin .= ' PM';
                    } else {
                        $begin .= ' PM';
                    }
                
                    // End time = next prayer's begin, or wrap back to Fajr
                    if (isset($names[$i + 1])) {
                        $end = str_replace('.', ':', $prayers[$names[$i + 1]]['Begins']);
                        $end .= ($names[$i + 1] === 'Fajr') ? ' AM' : ' PM';
                    } else {
                        $end = str_replace('.', ':', $prayers['Fajr']['Begins']) . ' AM';
                    }
                
                    try {
                        $beginTime = Carbon::createFromFormat('g:i A', $begin);
                        $endTime   = Carbon::createFromFormat('g:i A', $end);
                    } catch (\Exception $e) {
                        continue;
                    }
                
                    if ($endTime->lessThan($beginTime)) {
                        $endTime->addDay();
                    }
                    
                    
                    // 🌅 Special case: Fajr lasts only 3h
                    if ($name === 'Fajr') {
                        $endTime = (clone $beginTime)->addHours(3);
                    }
                
                    // 🔴 Special rule for Zuhr: 1h before 
                    if ($name === 'Zuhr') {
                        $beginTime->subHour();
                     }
                
                    // ✅ If it's Zuhr time, force highlight Zuhr
                    if ($name === 'Zuhr' && $now->between($beginTime, $endTime)) {
                        

                        $highlightedPrayer = $name;
                        break;
                    }
                
                    // ✅ Otherwise, normal logic
                    if ($now->between($beginTime, $endTime)) {
                        $highlightedPrayer = $name;
                        // dump('name '. $name);
                        // dump('beginTime '. $beginTime);
                        // dump('endTime '. $endTime);
                        break;
                    }
                }
                
                // Format Gregorian date: 4th September 2025
                $gregorianDate = $now->format('jS F Y');

                // Hijri date from DB
                $hijriDate = "{$prayer->hijri_date} {$prayer->hijri_month} {$prayer->hijri_year}";

                // Build display string
                $dateDisplay = $gregorianDate . " · " . $hijriDate;

                // Jumuah times - fetch from PrayerTime table
                // If today is Friday, show today's Zuhr Jama'at; otherwise show next Friday's
                $now = Carbon::now();
                $todayDayOfWeek = $now->dayOfWeek; // 0 = Sunday, 5 = Friday
                $todayDate = $now->day;
                $currentMonth = $now->format('M');
                
                $jummah = null;
                
                if ($todayDayOfWeek == 5) {
                    // Today is Friday - show today's Zuhr Jama'at
                    $jummah = PrayerTime::where('date', $todayDate)
                        ->where('month', $currentMonth)
                        ->first();
                } else {
                    // Find next Friday
                    $daysUntilFriday = (5 - $todayDayOfWeek + 7) % 7;
                    if ($daysUntilFriday == 0) $daysUntilFriday = 7; // If somehow not caught above
                    
                    $nextFriday = (clone $now)->addDays($daysUntilFriday);
                    $nextFridayDate = $nextFriday->day;
                    $nextFridayMonth = $nextFriday->format('M');
                    
                    $jummah = PrayerTime::where('date', $nextFridayDate)
                        ->where('month', $nextFridayMonth)
                        ->first();
                    
                    // If not found in next month, try current month (edge case for month end)
                    if (!$jummah && $nextFridayMonth !== $currentMonth) {
                        $jummah = PrayerTime::where('date', $nextFridayDate)
                            ->where('month', $currentMonth)
                            ->first();
                    }
                }

                $dailyPrayerHeader = [
                    'date'       => $gregorianDate,
                    'day'        => $prayer->day,
                    'hijri_date' => $hijriDate,
                    'hijri_month'=> $prayer->hijri_month,
                    'hijri_year' => $prayer->hijri_year ?? '',
                    'prayers'    => $prayers,
                    'highlighted'=> $highlightedPrayer,
                    'time'       => $now->format('H:i'),
                    'jummah' => $jummah
                ];
            }

            $view->with('dailyPrayerHeader', $dailyPrayerHeader);
        });
    }
}
