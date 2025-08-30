<?php

namespace App\Imports;

use App\Models\PrayerTime;
use Maatwebsite\Excel\Concerns\ToModel;

class PrayerTimesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    // ✅ This must be inside the class
    protected $month;

    public function __construct($month)
    {
        $this->month = $month; // store month, e.g. "April"
    }

    public function model(array $row)
    {
        
        
        // Skip header rows
        if (!is_numeric($row[0])) {
            return null;
        }

        return new PrayerTime([
            'date'    => $row[0],  // e.g. 1
            'day'     => $row[1],  // e.g. TUE
            'fajr_begins' => $row[2],
            'fajr_jamaat' => $row[3],
            'sunrise'     => $row[4],
            'zuhr_begins' => $row[5],
            'zuhr_jamaat' => $row[6],
            'asr_begins'  => $row[7],
            'asr_jamaat'  => $row[8],
            'maghrib_begins' => $row[9],
            'maghrib_jamaat' => $row[10],
            'isha_begins'    => $row[11],
            'isha_jamaat'    => $row[12],
            'hijri_date'     => $row[13],
            'hijri_month'    => $row[14],
            'month'          => $this->month, // add month here
        ]);
    }
}
