<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FuneralBooking;
use App\Mail\FuneralBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FuneralBookingController extends Controller
{
    /**
     * Display a listing of the funeral bookings.
     */
    public function index(Request $request)
    {
        $query = FuneralBooking::orderByDesc('id');

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by read/unread
        if ($request->filled('read')) {
            $query->where('read', $request->read === 'true');
        }

        $bookings = $query->paginate(20);

        // Get counts for stats
        $stats = [
            'total' => FuneralBooking::count(),
            'pending' => FuneralBooking::pending()->count(),
            'confirmed' => FuneralBooking::confirmed()->count(),
            'unread' => FuneralBooking::unread()->count(),
        ];

        return view('admin.funeral-bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Display the specified funeral booking.
     */
    public function show(FuneralBooking $funeralBooking)
    {
        // Mark as read if not already
        if (!$funeralBooking->read) {
            $funeralBooking->markAsRead();
        }

        return view('admin.funeral-bookings.show', compact('funeralBooking'));
    }

    /**
     * Update the specified funeral booking.
     */
    public function update(Request $request, FuneralBooking $funeralBooking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'admin_notes' => 'nullable|string',
        ]);

        $funeralBooking->update($validated);

        return back()->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified funeral booking.
     */
    public function destroy(FuneralBooking $funeralBooking)
    {
        $funeralBooking->delete();

        return redirect()->route('admin.funeral-bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    /**
     * Mark booking as read.
     */
    public function markAsRead(FuneralBooking $funeralBooking)
    {
        $funeralBooking->markAsRead();

        return back()->with('success', 'Booking marked as read.');
    }

    /**
     * Get unread count for header badge.
     */
    public function getUnreadCount()
    {
        $count = FuneralBooking::unread()->count();
        return response()->json(['count' => $count]);
    }
}