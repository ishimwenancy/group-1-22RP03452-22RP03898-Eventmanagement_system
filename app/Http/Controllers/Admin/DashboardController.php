<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\News;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'categories' => EventCategory::count(),
            'events' => Event::count(),
            'users' => User::where('role', '!=', 'admin')->count(),
            'total_bookings' => Booking::count(),
            'new_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
