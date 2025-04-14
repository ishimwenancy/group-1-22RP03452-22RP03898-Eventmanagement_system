<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->bookings()->with(['event' => function($query) {
            $query->withCount('bookings');
        }]);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $event = Event::findOrFail($request->event_id);

        // Check if event can be booked
        if (!$event->canBook()) {
            return back()->with('error', 'This event cannot be booked at this time.');
        }

        // Check if user already has a pending or confirmed booking for this event
        $existingBooking = auth()->user()->bookings()
            ->where('event_id', $event->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return back()->with('error', 'You already have a booking for this event.');
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'status' => 'pending',
            'total_amount' => $event->price
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Event booked successfully. Waiting for confirmation.');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status === 'confirmed') {
            return back()->with('error', 'Cannot cancel a confirmed booking.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}
