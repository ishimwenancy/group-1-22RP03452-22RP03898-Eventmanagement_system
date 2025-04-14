<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_bookings' => Booking::where('user_id', $user->id)->count(),
            'upcoming_events' => Event::where('start_date', '>', now())->count(),
            'latest_news' => News::count(),
        ];

        $latest_news = News::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'latest_news'));
    }
}
