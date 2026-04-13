<?php

namespace App\Http\Controllers;

use App\Models\MarriageBooking;
use App\Mail\MarriageBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MarriageBookingController extends Controller
{
    /**
     * Display the marriage services page.
     */
    public function show()
    {
        return view('services.marriage');
    }

    /**
     * Store a new marriage booking request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'proposed_date' => ['nullable', 'string', 'max:100'],
            'proposed_time' => ['nullable', 'string', 'max:50'],
            'expected_guests' => ['nullable', 'integer', 'min:1'],
            'service_type' => ['required', 'in:nikah,reception,both'],
            'message' => ['nullable', 'string'],
        ]);

        $booking = MarriageBooking::create($validated);

        // Send email notification to admin
        try {
            Mail::to(config('mail.from.address', 'admin@ipswichmosque.org'))
                ->send(new MarriageBookingNotification($booking));
        } catch (\Exception $e) {
            // Log the error but don't fail the request
            \Log::error('Failed to send marriage booking notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Your booking request has been submitted successfully. We will contact you soon to confirm availability.');
    }
}