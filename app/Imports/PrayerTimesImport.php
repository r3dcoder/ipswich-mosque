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
            'fajr_begins' =>  $this->formatTimeValue($row[2]),
            'fajr_jamaat' =>  $this->formatTimeValue($row[3]),
            'sunrise'     =>  $this->formatTimeValue($row[4]),
            'zuhr_begins' =>  $this->formatTimeValue($row[5]),
            'zuhr_jamaat' =>  $this->formatTimeValue($row[6]),
            'asr_begins'  =>  $this->formatTimeValue($row[7]),
            'asr_jamaat'  =>  $this->formatTimeValue($row[8]),
            'maghrib_begins' =>  $this->formatTimeValue($row[9]),
            'maghrib_jamaat' =>  $this->formatTimeValue($row[10]),
            'isha_begins'    =>  $this->formatTimeValue($row[11]),
            'isha_jamaat'    =>  $this->formatTimeValue($row[12]),
            'hijri_date'     => $row[13],
            'hijri_month'    => $row[14],
            'month'          => $this->month, // add month here
        ]);
    }

  /**
     * Format imported time value to float with 2 decimals
     */
    private function formatTimeValue($value): string
    {
        return  number_format((float)$value, 2, '.', '');
    }    
    
}
