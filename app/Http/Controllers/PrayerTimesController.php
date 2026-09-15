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
        $months = $months->sortBy(function ($month) use ($monthOrder) {
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

        // A Gregorian month almost always spans two Hijri months.
        // Collect unique Hijri months/years in chronological order for the header.
        [$hijriMonthsLabel, $hijriYearsLabel] = $this->buildHijriHeaderLabels($prayerTimes);

        return view('prayer-times', compact(
            'months',
            'prayerTimes',
            'selectedMonth',
            'selectedMonthFull',
            'today',
            'currentMonth',
            'currentMonthFull',
            'highlightToday',
            'hijriMonthsLabel',
            'hijriYearsLabel'
        ));
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

    /**
     * Build display labels for Hijri month(s) and year(s) covered by the given days.
     * Example: "RABI AL-AWWAL / RABI AL-AKHIR" and "1448".
     */
    private function buildHijriHeaderLabels($prayerTimes): array
    {
        $months = [];
        $years = [];

        foreach ($prayerTimes as $row) {
            $month = $this->normalizeHijriMonth($row->hijri_month ?? null);
            if ($month !== null && !in_array($month, $months, true)) {
                $months[] = $month;
            }

            $year = $row->hijri_year ?? null;
            if ($year !== null && $year !== '' && !in_array((string) $year, $years, true)) {
                $years[] = (string) $year;
            }
        }

        $monthsLabel = count($months) ? implode(' / ', $months) : '';
        $yearsLabel = count($years) ? implode(' / ', $years) : '';

        return [$monthsLabel, $yearsLabel];
    }

    /**
     * Normalize Hijri month names so spacing/case duplicates collapse.
     */
    private function normalizeHijriMonth(?string $month): ?string
    {
        if ($month === null) {
            return null;
        }

        $month = trim(preg_replace('/\s+/', ' ', $month) ?? '');

        if ($month === '') {
            return null;
        }

        return mb_strtoupper($month);
    }
}
