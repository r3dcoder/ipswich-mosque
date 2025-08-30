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

    // Default to current month if none selected
    $currentMonth = Carbon::now()->format('M'); // e.g., "Aug"
    $selectedMonth = $request->input('month', $currentMonth);

    // Get prayer times for the selected month
    $prayerTimes = PrayerTime::where('month', $selectedMonth)
                    ->orderBy('date')
                    ->get();

    $today = Carbon::now()->day;

    return view('prayer-times', compact('months', 'prayerTimes', 'selectedMonth', 'today', 'currentMonth'));
}
}
