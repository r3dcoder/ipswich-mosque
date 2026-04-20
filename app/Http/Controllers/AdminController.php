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
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
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
        $giftAidTotal = Donation::where('gift_aid', true)->completed()->sum('amount');
        
        return view('admin-panel.donations', compact(
            'donations',
            'totalAmount',
            'oneOffCount',
            'regularCount',
            'activeSubscriptions',
            'giftAidTotal'
        ));
    }

    public function donationStatistics(Request $request)
    {
        // Date range filter
        $startDate = $request->input('start_date', now()->subYear()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Get donations in date range
        $donations = Donation::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();

        // Calculate statistics
        $totalAmount = $donations->sum('amount');
        $totalDonations = $donations->count();
        $averageDonation = $totalDonations > 0 ? $totalAmount / $totalDonations : 0;

        // Category breakdown
        $categoryData = $donations->groupBy('category')->map(function($group) {
            return [
                'label' => Donation::CATEGORIES[$group->first()->category] ?? ucfirst($group->first()->category),
                'amount' => $group->sum('amount'),
                'count' => $group->count()
            ];
        });

        // Type breakdown
        $typeData = $donations->groupBy('type')->map(function($group) {
            return [
                'label' => ucfirst($group->first()->type),
                'amount' => $group->sum('amount'),
                'count' => $group->count()
            ];
        });

        // Monthly trend data
        $monthlyData = [];
        $currentDate = now()->subMonths(11);
        for ($i = 0; $i < 12; $i++) {
            $monthStart = $currentDate->copy()->startOfMonth();
            $monthEnd = $currentDate->copy()->endOfMonth();
            
            $monthDonations = $donations->whereBetween('created_at', [$monthStart, $monthEnd]);
            $monthlyData[] = [
                'month' => $monthStart->format('M Y'),
                'amount' => $monthDonations->sum('amount'),
                'count' => $monthDonations->count()
            ];
            
            $currentDate->addMonth();
        }

        // Gift Aid statistics
        $giftAidDonations = $donations->where('gift_aid', true);
        $giftAidAmount = $giftAidDonations->sum('amount');
        $giftAidPotential = $giftAidAmount * 0.25;

        // Status breakdown - use a simpler approach to avoid GROUP BY issues
        $allDonations = Donation::whereBetween('created_at', [$startDate, $endDate])->get();
        $statusData = $allDonations->groupBy('status')->map->count();

        return view('admin-panel.donation-statistics', compact(
            'totalAmount',
            'totalDonations',
            'averageDonation',
            'categoryData',
            'typeData',
            'monthlyData',
            'giftAidAmount',
            'giftAidPotential',
            'statusData',
            'startDate',
            'endDate'
        ));
    }
}
