<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuneralBooking;
use App\Models\JanazahContent;
use App\Models\EmergencyContact;
use App\Mail\FuneralBookingNotification;
use Illuminate\Support\Facades\Mail;

class FuneralController extends Controller
{
    /**
     * Display the Janazah/Funeral service page.
     */
    public function show()
    {
        $hero = JanazahContent::visibleOrdered()->section('hero')->first();
        $ritesHeading = JanazahContent::visibleOrdered()->section('rite_heading')->first();
        $rites = JanazahContent::visibleOrdered()->section('rite')->get();
        $prayersHeading = JanazahContent::visibleOrdered()->section('prayer_heading')->first();
        $prayers = JanazahContent::visibleOrdered()->section('prayer')->get();
        $terms = JanazahContent::visibleOrdered()->section('terms')->first();
        $termsPoints = JanazahContent::visibleOrdered()->section('terms_point')->get();
        $emergencyContacts = EmergencyContact::visibleOrdered()->get();

        return view('services.janazah', compact(
            'hero',
            'ritesHeading',
            'rites',
            'prayersHeading',
            'prayers',
            'terms',
            'termsPoints',
            'emergencyContacts'
        ));
    }

    /**
     * Handle the form submission and save to database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'deceased_name' => 'nullable|string|max:255',
            'message'       => 'nullable|string|max:1000',
        ]);

        $booking = FuneralBooking::create($validated);

        try {
            $adminEmail = config('mail.from.address', 'admin@ipswichmosque.com');
            Mail::to($adminEmail)->send(new FuneralBookingNotification($booking));
        } catch (\Exception $e) {
            \Log::error('Failed to send funeral booking notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Your inquiry has been received. Our team will contact you shortly. Inna Lillahi wa inna ilayhi raji\'un.');
    }
}
