<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['category', 'bookings'])
            ->where('is_active', true);

        // Category filter
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->has('status')) {
            if ($request->status === 'upcoming') {
                $query->where('start_date', '>', now());
            } elseif ($request->status === 'past') {
                $query->where('end_date', '<', now());
            }
        }

        // Get categories with event count
        $categories = EventCategory::withCount('events')
            ->whereHas('events', function ($query) {
                $query->where('is_active', true);
            })
            ->get();

        $events = $query->orderBy('start_date')
            ->paginate(9)
            ->withQueryString();

        return view('events.index', compact('events', 'categories'));
    }

    public function show(Event $event)
    {
        $event->load(['category', 'bookings']);
        return view('events.show', compact('event'));
    }
}
