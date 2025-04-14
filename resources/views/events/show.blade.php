@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Event Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $event->isUpcoming() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $event->isUpcoming() ? 'Upcoming' : 'Past' }}
                        </span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <a href="{{ route('events.index', ['category' => $event->category->id]) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $event->category->name }}
                        </a>
                    </div>
                </div>

                <!-- Event Image -->
                <div class="mb-8">
                    @if($event->image)
                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-96 object-cover rounded-lg">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                            <span class="text-gray-500">No Image Available</span>
                        </div>
                    @endif
                </div>

                <!-- Event Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="md:col-span-2">
                        <div class="prose max-w-none">
                            <h2 class="text-2xl font-bold mb-4">About This Event</h2>
                            {{ $event->description }}
                        </div>

                        @if($event->requirements)
                            <div class="mt-8">
                                <h3 class="text-xl font-bold mb-4">Requirements</h3>
                                <div class="prose max-w-none">
                                    {{ $event->requirements }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="md:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-6 sticky top-6">
                            <!-- Price -->
                            <div class="mb-6">
                                <span class="text-3xl font-bold text-gray-900">${{ number_format($event->price, 2) }}</span>
                                <span class="text-gray-500">per person</span>
                            </div>

                            <!-- Date & Time -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 mb-2">Date & Time</h4>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <div>Starts: {{ $event->start_date->format('M d, Y h:i A') }}</div>
                                        <div>Ends: {{ $event->end_date->format('M d, Y h:i A') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 mb-2">Location</h4>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            </div>

                            <!-- Capacity -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 mb-2">Availability</h4>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $event->available_slots }} spots left
                                </div>
                            </div>

                            <!-- Book Now Button -->
                            @if($event->isUpcoming() && $event->available_slots > 0)
                                <form action="{{ route('bookings.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Book Now
                                    </button>
                                </form>
                            @elseif(!$event->isUpcoming())
                                <button disabled class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-md font-semibold cursor-not-allowed">
                                    Event Ended
                                </button>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-md font-semibold cursor-not-allowed">
                                    Sold Out
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
