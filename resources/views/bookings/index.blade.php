@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">My Bookings</h2>
                    <div>
                        <select id="status-filter" onchange="window.location.href=this.value" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="{{ route('bookings.index') }}" {{ !request('status') ? 'selected' : '' }}>All Bookings</option>
                            <option value="{{ route('bookings.index', ['status' => 'pending']) }}" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="{{ route('bookings.index', ['status' => 'confirmed']) }}" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="{{ route('bookings.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($booking->event->image)
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($booking->event->image) }}" alt="">
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('events.show', $booking->event) }}" class="hover:text-blue-600">
                                                        {{ $booking->event->title }}
                                                    </a>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $booking->event->location }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->event->start_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->event->start_date->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($booking->event->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($booking->isPending())
                                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    Cancel
                                                </button>
                                            </form>
                                        @elseif($booking->isConfirmed())
                                            <span class="text-green-600">Confirmed</span>
                                        @else
                                            <span class="text-red-600">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No bookings found.
                                        <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 ml-1">Browse Events</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($bookings->hasPages())
                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
