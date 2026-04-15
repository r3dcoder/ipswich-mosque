<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuneralBooking; // Import the Model you just created

class FuneralController extends Controller
{
    /**
     * Display the Janazah/Funeral service page.
     */
    public function show()
    {
        return view('services.janazah');
        // return view('services.marriage');
    }

    /**
     * Handle the form submission and save to database.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'deceased_name' => 'nullable|string|max:255',
            'message'       => 'nullable|string|max:1000',
        ]);

        // 2. Save to database using the Model
        FuneralBooking::create($validated);

        // 3. Redirect back with a success message
        return back()->with('success', 'Your inquiry has been received. Our team will contact you shortly. Inna Lillahi wa inna ilayhi raji\'un.');
    }
}