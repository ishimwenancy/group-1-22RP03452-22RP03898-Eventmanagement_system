@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Event Categories -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold">Event Categories</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('events.index', ['category' => $category->id]) }}" 
                        class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow {{ request('category') == $category->id ? 'ring-2 ring-blue-500' : '' }}">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $category->description }}</p>
                        <p class="mt-2 text-sm text-blue-600">{{ $category->events_count }} {{ Str::plural('event', $category->events_count) }}</p>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Events List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">{{ request('category') ? $categories->find(request('category'))->name . ' Events' : 'All Events' }}</h2>
                    <div class="flex items-center space-x-4">
                        <select id="status" name="status" onchange="window.location.href=this.value"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="{{ route('events.index', array_merge(request()->except('status'), ['category' => request('category')])) }}"
                                {{ !request('status') ? 'selected' : '' }}>All Events</option>
                            <option value="{{ route('events.index', array_merge(request()->except('status'), ['status' => 'upcoming', 'category' => request('category')])) }}"
                                {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming Events</option>
                            <option value="{{ route('events.index', array_merge(request()->except('status'), ['status' => 'past', 'category' => request('category')])) }}"
                                {{ request('status') === 'past' ? 'selected' : '' }}>Past Events</option>
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

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($events as $event)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            @if($event->image)
                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($event->description, 100) }}</p>
                                
                                <div class="mb-4">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $event->start_date->format('M d, Y h:i A') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $event->location }}
                                    </div>
                                    <div class="flex items-center text-sm mb-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $event->isUpcoming() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $event->isUpcoming() ? 'Upcoming' : 'Past' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">${{ number_format($event->price, 2) }}</span>
                                    <a href="{{ route('events.show', $event) }}" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No events found</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ request('category') ? 'Try selecting a different category or' : 'Please' }} check back later.</p>
                        </div>
                    @endforelse
                </div>

                @if($events->hasPages())
                    <div class="mt-6">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
