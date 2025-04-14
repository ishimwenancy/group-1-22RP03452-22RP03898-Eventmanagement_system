@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Categories Card -->
                    <div class="bg-blue-100 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">Categories</h3>
                        <p class="text-3xl font-bold">{{ $stats['categories'] }}</p>
                    </div>

                    <!-- Events Card -->
                    <div class="bg-green-100 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">Events</h3>
                        <p class="text-3xl font-bold">{{ $stats['events'] }}</p>
                    </div>

                    <!-- Users Card -->
                    <div class="bg-yellow-100 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">Registered Users</h3>
                        <p class="text-3xl font-bold">{{ $stats['users'] }}</p>
                    </div>

                    <!-- Total Bookings Card -->
                    <div class="bg-purple-100 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">Total Bookings</h3>
                        <p class="text-3xl font-bold">{{ $stats['total_bookings'] }}</p>
                    </div>

                    <!-- New Bookings Card -->
                    <div class="bg-orange-100 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">New Bookings</h3>
                        <p class="text-3xl font-bold">{{ $stats['new_bookings'] }}</p>
                    </div>

                    <!-- Confirmed Bookings Card -->
                    <div class="bg-teal-100 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">Confirmed Bookings</h3>
                        <p class="text-3xl font-bold">{{ $stats['confirmed_bookings'] }}</p>
                    </div>

                    <!-- Cancelled Bookings Card -->
                    <div class="bg-red-100 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold">Cancelled Bookings</h3>
                        <p class="text-3xl font-bold">{{ $stats['cancelled_bookings'] }}</p>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.categories.index') }}" class="bg-blue-500 text-white p-4 rounded-lg text-center hover:bg-blue-600">
                        Manage Categories
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="bg-green-500 text-white p-4 rounded-lg text-center hover:bg-green-600">
                        Manage Events
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="bg-yellow-500 text-white p-4 rounded-lg text-center hover:bg-yellow-600">
                        Manage Users
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="bg-purple-500 text-white p-4 rounded-lg text-center hover:bg-purple-600">
                        Manage Bookings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
