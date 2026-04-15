<?php

namespace App\Http\Controllers;

use App\Models\Khutbah;
use App\Models\MarriageBooking;
use App\Models\FuneralBooking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        // Get statistics
        $khutbahsCount = Khutbah::count();
        $activeVideos = Khutbah::where('is_active', true)->count();
        
        // Get booking counts
        $marriageBookings = MarriageBooking::count();
        $funeralBookings = FuneralBooking::count();
        
        return view('admin-panel.home', compact(
            'khutbahsCount',
            'activeVideos',
            'marriageBookings',
            'funeralBookings'
        ));
    }

    public function pages()    { return view('admin-panel.pages'); }
    public function duas()     { return view('admin-panel.duas'); }
    public function settings() { return view('admin-panel.settings'); }
    public function payments() { return view('admin-panel.payments'); }
    public function contacts() { return view('admin-panel.contacts'); }
}