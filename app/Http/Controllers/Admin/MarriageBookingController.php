<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarriageBooking;
use App\Mail\MarriageBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MarriageBookingController extends Controller
{
    /**
     * Display a listing of the marriage bookings.
     */
    public function index(Request $request)
    {
        $query = MarriageBooking::orderByDesc('id');

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
            'total' => MarriageBooking::count(),
            'pending' => MarriageBooking::pending()->count(),
            'confirmed' => MarriageBooking::confirmed()->count(),
            'unread' => MarriageBooking::unread()->count(),
        ];

        return view('admin.marriage-bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Display the specified marriage booking.
     */
    public function show(MarriageBooking $marriageBooking)
    {
        // Mark as read if not already
        if (!$marriageBooking->read) {
            $marriageBooking->markAsRead();
        }

        return view('admin.marriage-bookings.show', compact('marriageBooking'));
    }

    /**
     * Update the specified marriage booking.
     */
    public function update(Request $request, MarriageBooking $marriageBooking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'admin_notes' => 'nullable|string',
        ]);

        $marriageBooking->update($validated);

        return back()->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified marriage booking.
     */
    public function destroy(MarriageBooking $marriageBooking)
    {
        $marriageBooking->delete();

        return redirect()->route('admin.marriage-bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    /**
     * Mark booking as read.
     */
    public function markAsRead(MarriageBooking $marriageBooking)
    {
        $marriageBooking->markAsRead();

        return back()->with('success', 'Booking marked as read.');
    }

    /**
     * Get unread count for header badge.
     */
    public function getUnreadCount()
    {
        $count = MarriageBooking::unread()->count();
        return response()->json(['count' => $count]);
    }
}