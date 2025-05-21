@extends('balehabt.layout.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Main Content -->
    <div class="flex-1 p-8">
        <!-- Dashboard Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">👋 Welcome to Balehabt Dashboard</h2>
            <p class="text-gray-600 mt-2 text-lg">Quick access to manage tickets, users, reports, and settings.</p>
        </div>

        <!-- Dashboard Options -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card -->
            @php
                $cards = [
                    ['title' => 'Manage Tickets', 'desc' => 'View and manage the tickets in your system.', 'url' => '#'],
                    ['title' => 'Ticket Reports', 'desc' => 'Generate and view reports for all tickets.', 'url' => '#'],
                    ['title' => 'Cash Reports', 'desc' => 'Generate cash reports for ticket collections.', 'url' => '#'],
                    ['title' => 'User Management', 'desc' => 'Manage system users and assign roles.', 'url' => '#'],
                    ['title' => 'Settings', 'desc' => 'Adjust system settings as needed.', 'url' => '#'],
                ];
            @endphp

            @foreach($cards as $card)
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h3 class="text-xl font-semibold text-gray-800">{{ $card['title'] }}</h3>
                <p class="text-gray-600 mt-2">{{ $card['desc'] }}</p>
                <a href="{{ $card['url'] }}"
                   class="mt-4 inline-block text-yellow-600 font-medium hover:underline hover:text-yellow-700 transition">
                   Go to {{ $card['title'] }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
