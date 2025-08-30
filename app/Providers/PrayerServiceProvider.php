<?php

namespace App\Providers;

use App\Models\PrayerTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class PrayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        // Share daily prayer header data with all views
        View::composer('*', function ($view) {
            $today = Carbon::now()->format('Y-m-d'); // or use day number if your table is 1,2,3
            $todayDay = Carbon::now()->day;

            // Fetch today's prayer times
            $prayers = PrayerTime::where('date', $todayDay) // use day number
                                 ->where('month', Carbon::now()->format('M')) // e.g., "Aug"
                                 ->first();

            $dailyPrayerHeader = $prayers ? [
                'gregorianDate' => Carbon::now()->format('jS F Y'), // 13th August 2025
                'hijriDate'     => $prayers->hijri_date . ' ' . $prayers->hijri_month . ' ' . $prayers->hijri_year,
                'jumah'         => ['13:15', '14:15'], // example fixed, can fetch dynamically
                'prayers'       => [
                    'Fajr'    => ['Begins' => $prayers->fajr_begins, 'Jamaat' => $prayers->fajr_jamaat],
                    'Zuhr'    => ['Begins' => $prayers->zuhr_begins, 'Jamaat' => $prayers->zuhr_jamaat],
                    'Asr'     => ['Begins' => $prayers->asr_begins, 'Jamaat' => $prayers->asr_jamaat],
                    'Maghrib' => ['Begins' => $prayers->maghrib_begins, 'Jamaat' => $prayers->maghrib_jamaat],
                    'Isha'    => ['Begins' => $prayers->isha_begins, 'Jamaat' => $prayers->isha_jamaat],
                ],
            ] : [];

            // Share with all views
            $view->with('dailyPrayerHeader', $dailyPrayerHeader);
        });
    }
}
