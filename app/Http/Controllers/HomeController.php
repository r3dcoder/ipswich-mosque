<?php

namespace App\Http\Controllers;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Gregorian date
        $todayGregorian = Carbon::now()->format('jS F Y'); // 13th August 2025

        // Hijri raw (Arabic month)
        $hijriDay   = Hijri::Date('j');   // 19
        $hijriMonth = Hijri::Date('F');   // Safar (but in Arabic if package set that way)
        $hijriYear  = Hijri::Date('Y');   // 1447

        // Map Arabic → English transliteration
        $months = [
            'محرم' => 'Muharram',
            'صفر' => 'Safar',
            'ربيع الأول' => 'Rabi Al-Awwal',
            'ربيع الآخر' => 'Rabi Al-Thani',
            'جمادى الأولى' => 'Jumada Al-Awwal',
            'جمادى الآخرة' => 'Jumada Al-Thani',
            'رجب' => 'Rajab',
            'شعبان' => 'Sha’ban',
            'رمضان' => 'Ramadan',
            'شوال' => 'Shawwal',
            'ذو القعدة' => 'Dhul Qa’dah',
            'ذو الحجة' => 'Dhul Hijjah',
        ];

        // Convert month to English if it exists in map
        $hijriMonthEnglish = $months[$hijriMonth] ?? $hijriMonth;

        $todayHijri = $hijriDay . ' ' . $hijriMonthEnglish . ' ' . $hijriYear;

        $events = Event::where('is_active', true)
            ->where('starts_at', '>=', now()->subDay())
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('welcome', compact('todayGregorian', 'todayHijri', 'events'));
    }
}
