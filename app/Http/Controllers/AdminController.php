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

        // ==========================================
        // Period-based statistics with comparisons
        // ==========================================
        
        // Daily statistics (today vs yesterday)
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $yesterdayStart = now()->subDay()->startOfDay();
        $yesterdayEnd = now()->subDay()->endOfDay();
        
        $todayDonations = Donation::whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('status', 'completed')
            ->get();
        $yesterdayDonations = Donation::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
            ->where('status', 'completed')
            ->get();
        
        $todayAmount = $todayDonations->sum('amount');
        $todayCount = $todayDonations->count();
        $yesterdayAmount = $yesterdayDonations->sum('amount');
        $yesterdayCount = $yesterdayDonations->count();
        
        $dailyAmountChange = $yesterdayAmount > 0 ? (($todayAmount - $yesterdayAmount) / $yesterdayAmount * 100) : ($todayAmount > 0 ? 100 : 0);
        $dailyCountChange = $yesterdayCount > 0 ? (($todayCount - $yesterdayCount) / $yesterdayCount * 100) : ($todayCount > 0 ? 100 : 0);

        // Weekly statistics (this week vs last week)
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();
        
        $thisWeekDonations = Donation::whereBetween('created_at', [$weekStart, $weekEnd])
            ->where('status', 'completed')
            ->get();
        $lastWeekDonations = Donation::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
            ->where('status', 'completed')
            ->get();
        
        $thisWeekAmount = $thisWeekDonations->sum('amount');
        $thisWeekCount = $thisWeekDonations->count();
        $lastWeekAmount = $lastWeekDonations->sum('amount');
        $lastWeekCount = $lastWeekDonations->count();
        
        $weeklyAmountChange = $lastWeekAmount > 0 ? (($thisWeekAmount - $lastWeekAmount) / $lastWeekAmount * 100) : ($thisWeekAmount > 0 ? 100 : 0);
        $weeklyCountChange = $lastWeekCount > 0 ? (($thisWeekCount - $lastWeekCount) / $lastWeekCount * 100) : ($thisWeekCount > 0 ? 100 : 0);

        // Monthly statistics (this month vs last month)
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();
        
        $thisMonthDonations = Donation::whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('status', 'completed')
            ->get();
        $lastMonthDonations = Donation::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->where('status', 'completed')
            ->get();
        
        $thisMonthAmount = $thisMonthDonations->sum('amount');
        $thisMonthCount = $thisMonthDonations->count();
        $lastMonthAmount = $lastMonthDonations->sum('amount');
        $lastMonthCount = $lastMonthDonations->count();
        
        $monthlyAmountChange = $lastMonthAmount > 0 ? (($thisMonthAmount - $lastMonthAmount) / $lastMonthAmount * 100) : ($thisMonthAmount > 0 ? 100 : 0);
        $monthlyCountChange = $lastMonthCount > 0 ? (($thisMonthCount - $lastMonthCount) / $lastMonthCount * 100) : ($thisMonthCount > 0 ? 100 : 0);

        // Yearly statistics (this year vs last year)
        $yearStart = now()->startOfYear();
        $yearEnd = now()->endOfYear();
        $lastYearStart = now()->subYear()->startOfYear();
        $lastYearEnd = now()->subYear()->endOfYear();
        
        $thisYearDonations = Donation::whereBetween('created_at', [$yearStart, $yearEnd])
            ->where('status', 'completed')
            ->get();
        $lastYearDonations = Donation::whereBetween('created_at', [$lastYearStart, $lastYearEnd])
            ->where('status', 'completed')
            ->get();
        
        $thisYearAmount = $thisYearDonations->sum('amount');
        $thisYearCount = $thisYearDonations->count();
        $lastYearAmount = $lastYearDonations->sum('amount');
        $lastYearCount = $lastYearDonations->count();
        
        $yearlyAmountChange = $lastYearAmount > 0 ? (($thisYearAmount - $lastYearAmount) / $lastYearAmount * 100) : ($thisYearAmount > 0 ? 100 : 0);
        $yearlyCountChange = $lastYearCount > 0 ? (($thisYearCount - $lastYearCount) / $lastYearCount * 100) : ($thisYearCount > 0 ? 100 : 0);

        // Daily trend data (last 30 days)
        $dailyTrendData = [];
        for ($i = 29; $i >= 0; $i--) {
            $dayStart = now()->subDays($i)->startOfDay();
            $dayEnd = now()->subDays($i)->endOfDay();
            
            $dayDonations = Donation::whereBetween('created_at', [$dayStart, $dayEnd])
                ->where('status', 'completed')
                ->get();
            
            $dailyTrendData[] = [
                'date' => $dayStart->format('M d'),
                'amount' => $dayDonations->sum('amount'),
                'count' => $dayDonations->count()
            ];
        }

        // Weekly trend data (last 12 weeks)
        $weeklyTrendData = [];
        for ($i = 11; $i >= 0; $i--) {
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekEnd = now()->subWeeks($i)->endOfWeek();
            
            $weekDonations = Donation::whereBetween('created_at', [$weekStart, $weekEnd])
                ->where('status', 'completed')
                ->get();
            
            $weeklyTrendData[] = [
                'week' => 'Week ' . $weekStart->weekOfYear . ' ' . $weekStart->format('M'),
                'amount' => $weekDonations->sum('amount'),
                'count' => $weekDonations->count()
            ];
        }

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
            'endDate',
            // Daily stats
            'todayAmount',
            'todayCount',
            'yesterdayAmount',
            'yesterdayCount',
            'dailyAmountChange',
            'dailyCountChange',
            // Weekly stats
            'thisWeekAmount',
            'thisWeekCount',
            'lastWeekAmount',
            'lastWeekCount',
            'weeklyAmountChange',
            'weeklyCountChange',
            // Monthly stats
            'thisMonthAmount',
            'thisMonthCount',
            'lastMonthAmount',
            'lastMonthCount',
            'monthlyAmountChange',
            'monthlyCountChange',
            // Yearly stats
            'thisYearAmount',
            'thisYearCount',
            'lastYearAmount',
            'lastYearCount',
            'yearlyAmountChange',
            'yearlyCountChange',
            // Trend data
            'dailyTrendData',
            'weeklyTrendData'
        ));
    }
}
