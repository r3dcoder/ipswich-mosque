<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PrayerTimesImport;
use App\Models\PrayerTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PrayerTimeController extends Controller
{
    /**
     * Show the import form for uploading Excel files
     */
    public function import()
    {
        return view('admin.prayer_times.import');
    }

    /**
     * Process the uploaded Excel files
     */
    public function importStore(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:xlsx,xls,csv',
        ]);

        // Check if exactly 12 files are uploaded
        if (count($request->file('files')) !== 12) {
            return back()->withErrors(['files' => 'Please upload exactly 12 Excel files, one for each month.']);
        }

        // Month mapping - must match the original /import route file naming (Jan, Feb, Mar, etc.)
        $monthMapping = [
            'jan' => 'Jan',
            'feb' => 'Feb',
            'mar' => 'Mar',
            'apr' => 'Apr',
            'may' => 'May',
            'jun' => 'Jun',
            'jul' => 'Jul',
            'aug' => 'Aug',
            'sep' => 'Sep',
            'oct' => 'Oct',
            'nov' => 'Nov',
            'dec' => 'Dec',
        ];

        $importedMonths = [];
        $errors = [];

        // Delete existing prayer times before import
        PrayerTime::truncate();

        foreach ($request->file('files') as $file) {
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileNameLower = strtolower($fileName);

            // Find matching month
            $month = null;
            foreach ($monthMapping as $key => $monthName) {
                if (str_contains($fileNameLower, $key)) {
                    $month = $monthName;
                    break;
                }
            }

            if (!$month) {
                $errors[] = "Cannot determine month from filename: {$file->getClientOriginalName()}. Please use month names like 'Jan', 'Feb', 'Mar', etc.";
                continue;
            }

            if (in_array($month, $importedMonths)) {
                $errors[] = "Duplicate month detected: {$month}. Each file should represent a different month.";
                continue;
            }

            try {
                Excel::import(new PrayerTimesImport($month), $file);
                $importedMonths[] = $month;
            } catch (\Exception $e) {
                $errors[] = "Error importing {$file->getClientOriginalName()}: " . $e->getMessage();
            }
        }

        if (!empty($errors)) {
            return back()->withErrors(['files' => implode(' | ', $errors)]);
        }

        return redirect()->route('admin.prayer-times.index')
            ->with('success', 'Successfully imported prayer times for: ' . implode(', ', $importedMonths));
    }

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
