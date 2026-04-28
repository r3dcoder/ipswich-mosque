<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrayerTime;
use Carbon\Carbon;

class PrayerTimesController extends Controller
{
    public function index(Request $request)
    {
        // Get all distinct months from DB
        $months = PrayerTime::select('month')->distinct()->pluck('month');

        // Sort months in calendar order
        $monthOrder = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $months = $months->sortBy(function($month) use ($monthOrder) {
            return array_search($month, $monthOrder);
        })->values();

        // Default to current month if none selected
        $currentMonth = Carbon::now()->format('M'); // e.g., "Aug"
        $selectedMonth = $request->input('month', $currentMonth);

        // Get prayer times for the selected month
        $prayerTimes = PrayerTime::where('month', $selectedMonth)
                        ->orderBy('date')
                        ->get();

        $now = Carbon::now();
        $today = $now->day;
        // Only highlight today's date if the selected month matches the current month
        $highlightToday = $selectedMonth === $now->format('M');

        // Convert short month name to full name for display
        $monthMapping = [
            'Jan' => 'January',
            'Feb' => 'February',
            'Mar' => 'March',
            'Apr' => 'April',
            'May' => 'May',
            'Jun' => 'June',
            'Jul' => 'July',
            'Aug' => 'August',
            'Sep' => 'September',
            'Oct' => 'October',
            'Nov' => 'November',
            'Dec' => 'December',
        ];

        $selectedMonthFull = $monthMapping[$selectedMonth] ?? $selectedMonth;
        $currentMonthFull = $monthMapping[$currentMonth] ?? $currentMonth;

        return view('prayer-times', compact('months', 'prayerTimes', 'selectedMonth', 'selectedMonthFull', 'today', 'currentMonth', 'currentMonthFull', 'highlightToday'));
    }

    public function timingScreen()
    {
        // Get today's prayer times
        $today = Carbon::now()->day;
        $currentMonth = Carbon::now()->format('M');
        
        $prayerTimes = PrayerTime::where('month', $currentMonth)
                    ->where('date', $today)
                    ->first();

        return view('prayer-timing-screen', compact('prayerTimes'));
    }
}
