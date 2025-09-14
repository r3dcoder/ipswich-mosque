<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Alkoumi\LaravelHijriDate\Hijri;

use App\Models\PrayerTime;
use Carbon\Carbon;
use URL;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

        if ($this->app->environment('local')) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        }
        
        // View::composer('*', function ($view) {
        //     $today = Carbon::now()->format('Y-m-d');
        //     $currentPrayer = PrayerTime::whereDate('date', $today)->first();

        //     $prayers = [
        //         'Fajr' => ['Begins' => '-', 'Jamaat' => '-'],
        //         'Zuhr' => ['Begins' => '-', 'Jamaat' => '-'],
        //         'Asr' => ['Begins' => '-', 'Jamaat' => '-'],
        //         'Maghrib' => ['Begins' => '-', 'Jamaat' => '-'],
        //         'Isha' => ['Begins' => '-', 'Jamaat' => '-'],
        //     ];

        //     $gregorianDate = Carbon::now()->format('jS M Y');
        //     $hijriDate = $currentPrayer->hijri_date ?? '-';
        //     $jumah = ['13:15', '14:15'];

        //     if ($currentPrayer) {
        //         $prayers = [
        //             'Fajr' => ['Begins' => $currentPrayer->fajr_begins, 'Jamaat' => $currentPrayer->fajr_jamaat],
        //             'Zuhr' => ['Begins' => $currentPrayer->zuhr_begins, 'Jamaat' => $currentPrayer->zuhr_jamaat],
        //             'Asr' => ['Begins' => $currentPrayer->asr_begins, 'Jamaat' => $currentPrayer->asr_jamaat],
        //             'Maghrib' => ['Begins' => $currentPrayer->maghrib_begins, 'Jamaat' => $currentPrayer->maghrib_jamaat],
        //             'Isha' => ['Begins' => $currentPrayer->isha_begins, 'Jamaat' => $currentPrayer->isha_jamaat],
        //         ];
        //     }

        //     // Share with all views
        //     $view->with('dailyPrayerHeader', compact('gregorianDate', 'hijriDate', 'jumah', 'prayers'));
        // });
    }
}
