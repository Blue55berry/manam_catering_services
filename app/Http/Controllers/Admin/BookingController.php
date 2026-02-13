<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['event', 'package'])->orderBy('created_at', 'desc')->get();
        $recentBookings = Booking::with('package')->orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin.bookings.index', compact('bookings', 'recentBookings'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        // Sync Quotation Status
        if ($booking->quotation) {
            $quotationStatus = 'draft';
            if ($request->status === 'confirmed') {
                $quotationStatus = 'accepted';
            } elseif ($request->status === 'cancelled') {
                $quotationStatus = 'rejected';
            }
            $booking->quotation->update(['status' => $quotationStatus]);
        }

        return redirect()->back()->with('success', 'Booking status updated!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully!');
    }
}
