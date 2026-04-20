<?php

namespace App\Http\Controllers;

use App\Models\Donation;
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
        
        // Get donation statistics
        $totalDonations = Donation::completed()->sum('amount');
        $oneOffDonations = Donation::oneOff()->completed()->sum('amount');
        $regularDonations = Donation::regular()->completed()->sum('amount');
        $donationsCount = Donation::completed()->count();
        
        return view('admin-panel.home', compact(
            'khutbahsCount',
            'activeVideos',
            'marriageBookings',
            'funeralBookings',
            'totalDonations',
            'oneOffDonations',
            'regularDonations',
            'donationsCount'
        ));
    }

    public function pages()    { return view('admin-panel.pages'); }
    public function duas()     { return view('admin-panel.duas'); }
    public function settings() { return view('admin-panel.settings'); }
    public function payments() { return view('admin-panel.payments'); }
    public function contacts() { return view('admin-panel.contacts'); }
    
    public function donations(Request $request)
    {
        $query = Donation::query();
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by frequency
        if ($request->filled('frequency')) {
            $query->where('frequency', $request->frequency);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('donor_email', 'like', "%{$search}%")
                  ->orWhere('stripe_customer_id', 'like', "%{$search}%")
                  ->orWhere('stripe_subscription_id', 'like', "%{$search}%");
            });
        }
        
        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $donations = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get summary statistics
        $totalAmount = Donation::completed()->sum('amount');
        $oneOffCount = Donation::oneOff()->count();
        $regularCount = Donation::regular()->count();
        $activeSubscriptions = Donation::regular()->completed()->count();
        
        return view('admin-panel.donations', compact(
            'donations',
            'totalAmount',
            'oneOffCount',
            'regularCount',
            'activeSubscriptions'
        ));
    }
}
