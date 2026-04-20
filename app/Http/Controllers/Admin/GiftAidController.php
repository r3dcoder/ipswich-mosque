<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftAidDeclaration;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GiftAidController extends Controller
{
    /**
     * Display a listing of Gift Aid declarations.
     */
    public function index(Request $request)
    {
        $query = GiftAidDeclaration::query();

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('donor_name', 'like', "%{$request->search}%")
                  ->orWhere('donor_email', 'like', "%{$request->search}%")
                  ->orWhere('donor_postcode', 'like', "%{$request->search}%");
            });
        }

        $declarations = $query->orderBy('declared_at', 'desc')->paginate(20);
        
        // Calculate summary statistics
        $stats = [
            'total_active' => GiftAidDeclaration::active()->count(),
            'total_cancelled' => GiftAidDeclaration::cancelled()->count(),
            'total_expired' => GiftAidDeclaration::expired()->count(),
            'total_donations' => Donation::where('gift_aid', true)->where('status', 'completed')->sum('amount'),
            'potential_gift_aid' => Donation::where('gift_aid', true)->where('status', 'completed')->sum('amount') * 0.25,
        ];

        return view('admin.gift-aid.index', compact('declarations', 'stats'));
    }

    /**
     * Show the form for creating a new Gift Aid declaration.
     */
    public function create()
    {
        return view('admin.gift-aid.create');
    }

    /**
     * Store a new Gift Aid declaration.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_address' => 'nullable|string|max:500',
            'donor_postcode' => 'nullable|string|max:20',
            'donor_phone' => 'nullable|string|max:20',
            'declaration_text' => 'required|string',
            'declared_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if donor already has an active declaration
        $existing = GiftAidDeclaration::active()
            ->where('donor_email', $request->donor_email)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'This donor already has an active Gift Aid declaration.')
                ->withInput();
        }

        $declaration = GiftAidDeclaration::create([
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_address' => $request->donor_address,
            'donor_postcode' => $request->donor_postcode,
            'donor_phone' => $request->donor_phone,
            'declaration_text' => $request->declaration_text,
            'declared_at' => $request->declared_at,
            'notes' => $request->notes,
        ]);

        // Update totals for this donor
        $declaration->updateTotals();

        return redirect()->route('admin.gift-aid.index')
            ->with('success', 'Gift Aid declaration created successfully!');
    }

    /**
     * Display the specified Gift Aid declaration.
     */
    public function show(GiftAidDeclaration $declaration)
    {
        $donations = Donation::where('donor_email', $declaration->donor_email)
            ->where('gift_aid', true)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.gift-aid.show', compact('declaration', 'donations'));
    }

    /**
     * Show the form for editing the specified Gift Aid declaration.
     */
    public function edit(GiftAidDeclaration $declaration)
    {
        return view('admin.gift-aid.edit', compact('declaration'));
    }

    /**
     * Update the specified Gift Aid declaration.
     */
    public function update(Request $request, GiftAidDeclaration $declaration)
    {
        $validator = Validator::make($request->all(), [
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_address' => 'nullable|string|max:500',
            'donor_postcode' => 'nullable|string|max:20',
            'donor_phone' => 'nullable|string|max:20',
            'declaration_text' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check for duplicate email (excluding current declaration)
        $existing = GiftAidDeclaration::active()
            ->where('donor_email', $request->donor_email)
            ->where('id', '!=', $declaration->id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Another active declaration already exists for this email address.')
                ->withInput();
        }

        $declaration->update([
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_address' => $request->donor_address,
            'donor_postcode' => $request->donor_postcode,
            'donor_phone' => $request->donor_phone,
            'declaration_text' => $request->declaration_text,
            'notes' => $request->notes,
        ]);

        // Update totals if email changed
        if ($declaration->isDirty('donor_email')) {
            $declaration->updateTotals();
        }

        return redirect()->route('admin.gift-aid.index')
            ->with('success', 'Gift Aid declaration updated successfully!');
    }

    /**
     * Cancel a Gift Aid declaration.
     */
    public function cancel(Request $request, GiftAidDeclaration $declaration)
    {
        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $declaration->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->route('admin.gift-aid.index')
            ->with('success', 'Gift Aid declaration cancelled successfully!');
    }

    /**
     * Generate Gift Aid report.
     */
    public function report(Request $request)
    {
        $startDate = $request->input('start_date', now()->subYear()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Get all active declarations
        $declarations = GiftAidDeclaration::active()->get();

        $reportData = [];
        $totalPotential = 0;
        $totalClaimed = 0;

        foreach ($declarations as $declaration) {
            $donations = Donation::where('donor_email', $declaration->donor_email)
                ->where('gift_aid', true)
                ->where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $donationTotal = $donations->sum('amount');
            $giftAidValue = $donationTotal * 0.25;

            if ($donationTotal > 0) {
                $reportData[] = [
                    'declaration' => $declaration,
                    'donations' => $donations,
                    'donation_total' => $donationTotal,
                    'gift_aid_value' => $giftAidValue,
                ];

                $totalPotential += $giftAidValue;
                $totalClaimed += $giftAidValue; // In this system, we assume all eligible donations are claimed
            }
        }

        return view('admin.gift-aid.report', compact('reportData', 'totalPotential', 'totalClaimed', 'startDate', 'endDate'));
    }

    /**
     * Export Gift Aid report to CSV.
     */
    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->subYear()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $declarations = GiftAidDeclaration::active()->get();

        $csv = "Donor Name,Donor Email,Declaration Date,Total Donations,Total Gift Aid,Status\n";
        $totalPotential = 0;
        $totalClaimed = 0;

        foreach ($declarations as $declaration) {
            $donations = Donation::where('donor_email', $declaration->donor_email)
                ->where('gift_aid', true)
                ->where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $donationTotal = $donations->sum('amount');
            $giftAidValue = $donationTotal * 0.25;

            if ($donationTotal > 0) {
                $csv .= "\"{$declaration->donor_name}\",\"{$declaration->donor_email}\",\"{$declaration->declared_at->format('Y-m-d')}\",\"£{$donationTotal}\",\"£{$giftAidValue}\",\"{$declaration->status}\"\n";
                $totalPotential += $giftAidValue;
                $totalClaimed += $giftAidValue;
            }
        }

        $csv .= "\nTotal Potential Gift Aid: £{$totalPotential}\n";
        $csv .= "Total Claimed Gift Aid: £{$totalClaimed}\n";

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="gift-aid-report-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}