@extends('ticketer.layout.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <div class="flex-1 p-8">
        <!-- Dashboard Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-white">🎟️ Welcome to Ticketer Dashboard</h2>
            <p class="text-gray-900 mt-2 text-lg">Create, view, and scan tickets easily.</p>
        </div>

        <!-- Ticket Options Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Reusable Cards -->
            @php
                $cards = [
                    [
                        'title' => 'Create Ticket',
                        'desc' => 'Click here to create a new ticket.',
                        'url' => route('ticketer.tickets.create'),
                        'btn' => 'Create Now'
                    ],
                    [
                        'title' => 'Ticket Report',
                        'desc' => 'View all your ticket reports here.',
                        'url' => route('ticketer.tickets.report'),
                        'btn' => 'View Reports'
                    ],
                    [
                        'title' => 'Scan Ticket',
                        'desc' => 'Scan a ticket to verify its status.',
                        'url' => route('ticketer.tickets.scan'),
                        'btn' => 'Scan Ticket'
                    ],
                    [
                        'title' => 'Cash Report',
                        'desc' => 'See all reports according to cash collected on tickets.',
                        'url' => route('ticketer.cash-report.index'),
                        'btn' => 'Make Report'
                    ],
                ];
            @endphp

            @foreach($cards as $card)
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h3 class="text-xl font-semibold text-gray-800">{{ $card['title'] }}</h3>
                <p class="text-gray-600 mt-2">{{ $card['desc'] }}</p>
                <a href="{{ $card['url'] }}"
                   class="mt-4 inline-block text-yellow-600 font-medium hover:underline hover:text-yellow-700 transition">
                   {{ $card['btn'] }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
