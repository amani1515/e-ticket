@extends('ticketer.layout.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Main Content -->
    <div class="flex-1 bg-gray-100 p-6">
        <!-- Dashboard Content -->
        <div class="mt-6">
            <h2 class="text-2xl font-semibold text-gray-700">Welcome to the Ticketer Dashboard</h2>
            <p class="text-gray-600 mt-2">Here you can create tickets, view reports, and scan tickets.</p>

            <!-- Ticket Options -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">Create Ticket</h3>
                    <p class="text-gray-600 mt-2">Click here to create a new ticket.</p>
                    <a href="{{ route('ticketer.tickets.create') }}" class="text-yellow-500 hover:underline mt-4 block">Create Now</a>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">Ticket Report</h3>
                    <p class="text-gray-600 mt-2">View all your ticket reports here.</p>
                    <a href="{{ route('ticketer.tickets.report') }}" class="text-yellow-500 hover:underline mt-4 block">View Reports</a>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">Scan Ticket</h3>
                    <p class="text-gray-600 mt-2">Scan a ticket to verify its status.</p>
                    <a href="{{ route('ticketer.tickets.scan') }}" class="text-yellow-500 hover:underline mt-4 block">Scan Ticket</a>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">Cash report</h3>
                    <p class="text-gray-600 mt-2">See all reports according to cash that colected on tickets </p>
                    <a href="{{ route('ticketer.cash-report.index') }}" class="text-yellow-500 hover:underline mt-4 block">Make Report</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
