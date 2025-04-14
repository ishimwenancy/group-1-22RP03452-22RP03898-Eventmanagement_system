<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                        <!-- My Bookings Card -->
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold">My Bookings</h3>
                            <p class="text-3xl font-bold">{{ $stats['total_bookings'] ?? 0 }}</p>
                        </div>

                        <!-- Upcoming Events Card -->
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold">Upcoming Events</h3>
                            <p class="text-3xl font-bold">{{ $stats['upcoming_events'] ?? 0 }}</p>
                        </div>

                        <!-- Latest News Card -->
                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold">Latest News</h3>
                            <p class="text-3xl font-bold">{{ $stats['latest_news'] ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Quick Actions -->
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('events.index') }}" class="block w-full text-center bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                                    Browse Events
                                </a>
                                <a href="{{ route('bookings.index') }}" class="block w-full text-center bg-green-500 text-white p-2 rounded hover:bg-green-600">
                                    View My Bookings
                                </a>
                            </div>
                        </div>

                        <!-- Latest News -->
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Latest News</h3>
                            @if(isset($latest_news) && count($latest_news) > 0)
                                <div class="space-y-2">
                                    @foreach($latest_news as $news)
                                        <div class="p-2 hover:bg-gray-50 rounded">
                                            <h4 class="font-medium">{{ $news->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ Str::limit($news->content, 100) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No news available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
