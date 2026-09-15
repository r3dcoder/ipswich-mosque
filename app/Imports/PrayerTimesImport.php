<?php

namespace App\Imports;

use App\Models\PrayerTime;
use Maatwebsite\Excel\Concerns\ToModel;

class PrayerTimesImport implements ToModel
{
    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }

    public function model(array $row)
    {
        // Skip header rows or empty rows
        if (!isset($row[0]) || !is_numeric($row[0])) {
            return null;
        }

        if (!isset($row[1])) {
            return null;
        }

        $data = [
            'day'            => $row[1] ?? null,
            'fajr_begins'    => isset($row[2]) ? $this->formatTimeValue($row[2]) : null,
            'fajr_jamaat'    => isset($row[3]) ? $this->formatTimeValue($row[3]) : null,
            'sunrise'        => isset($row[4]) ? $this->formatTimeValue($row[4]) : null,
            'zuhr_begins'    => isset($row[5]) ? $this->formatTimeValue($row[5]) : null,
            'zuhr_jamaat'    => isset($row[6]) ? $this->formatTimeValue($row[6]) : null,
            'asr_begins'     => isset($row[7]) ? $this->formatTimeValue($row[7]) : null,
            'asr_jamaat'     => isset($row[8]) ? $this->formatTimeValue($row[8]) : null,
            'maghrib_begins' => isset($row[9]) ? $this->formatTimeValue($row[9]) : null,
            'maghrib_jamaat' => isset($row[10]) ? $this->formatTimeValue($row[10]) : null,
            'isha_begins'    => isset($row[11]) ? $this->formatTimeValue($row[11]) : null,
            'isha_jamaat'    => isset($row[12]) ? $this->formatTimeValue($row[12]) : null,
            'hijri_date'     => $row[13] ?? null,
            'hijri_month'    => $row[14] ?? null,
            'hijri_year'     => isset($row[15]) ? $this->extractHijriYear($row[15]) : null,
        ];

        // Use updateOrCreate: if (month, date) already exists, update it; otherwise create
        // This prevents duplicate (month, date) rows
        return PrayerTime::updateOrCreate(
            [
                'month' => $this->month,
                'date'  => (int) $row[0],
            ],
            $data
        );
    }

    private function formatTimeValue($value): string
    {
        return number_format((float) $value, 2, '.', '');
    }

    private function extractHijriYear($value): ?int
    {
        if (empty($value)) {
            return null;
        }

        if (preg_match('/(\d+)/', (string) $value, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }
}
