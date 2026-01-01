<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerTime;
use Illuminate\Http\Request;

class PrayerTimeController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month'); // e.g. APRIL
        $q     = $request->query('q');     // search day/date

        $prayers = PrayerTime::query()
            ->when($month, fn($query) => $query->where('month', $month))
            ->when($q, function ($query) use ($q) {
                $query->where('day', 'like', "%{$q}%")
                      ->orWhere('date', 'like', "%{$q}%")
                      ->orWhere('hijri_month', 'like', "%{$q}%");
            })
            ->orderByRaw("FIELD(month,'JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER')")
            ->orderBy('date')
            ->paginate(31)
            ->withQueryString();

        $months = PrayerTime::query()
            ->select('month')
            ->whereNotNull('month')
            ->distinct()
            ->orderByRaw("FIELD(month,'JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER')")
            ->pluck('month');

        return view('admin.prayer_times.index', compact('prayers', 'months', 'month', 'q'));
    }

    public function create()
    {
        return view('admin.prayer_times.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        PrayerTime::create($data);

        return redirect()->route('admin.prayer-times.index')->with('success', 'Prayer time added.');
    }

    public function edit(PrayerTime $prayer_time)
    {
        return view('admin.prayer_times.edit', ['prayer' => $prayer_time]);
    }

    public function update(Request $request, PrayerTime $prayer_time)
    {
        $data = $this->validated($request);
        $prayer_time->update($data);

        return redirect()->route('admin.prayer-times.index')->with('success', 'Prayer time updated.');
    }

    public function destroy(PrayerTime $prayer_time)
    {
        $prayer_time->delete();
        return redirect()->route('admin.prayer-times.index')->with('success', 'Prayer time deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'date' => ['required','integer','min:1','max:31'],
            'month' => ['nullable','string','max:255'],
            'day' => ['required','string','max:255'],

            'fajr_begins' => ['nullable','string','max:255'],
            'fajr_jamaat' => ['nullable','string','max:255'],
            'sunrise' => ['nullable','string','max:255'],

            'zuhr_begins' => ['nullable','string','max:255'],
            'zuhr_jamaat' => ['nullable','string','max:255'],

            'asr_begins' => ['nullable','string','max:255'],
            'asr_jamaat' => ['nullable','string','max:255'],

            'maghrib_begins' => ['nullable','string','max:255'],
            'maghrib_jamaat' => ['nullable','string','max:255'],

            'isha_begins' => ['nullable','string','max:255'],
            'isha_jamaat' => ['nullable','string','max:255'],

            'hijri_date' => ['nullable','integer','min:1','max:30'],
            'hijri_month' => ['nullable','string','max:255'],
            'hijri_year' => ['nullable','integer','min:1400','max:1700'],
        ]);
    }
}
