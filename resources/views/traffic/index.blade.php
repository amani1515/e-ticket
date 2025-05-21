@extends('traffic.layout.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Main Content -->
    <div class="flex-1 bg-gray-100 p-6">
        <!-- Balehabt Dashboard Content -->
        <div class="mt-6">
            <h2 class="text-2xl font-semibold text-gray-700">Welcome to the Balehabt Dashboard</h2>
            {{-- <p class="text-gray-600 mt-2">Here you can manage tickets, view reports, and manage cash flows.</p> --}}

            <!-- Balehabt Dashboard Options -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Ticket Management Card -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">Manage Tickets</h3>
                    <p class="text-gray-600 mt-2">View and manage the tickets in your system.</p>
                    <a href="{#}" class="text-yellow-500 hover:underline mt-4 block">Manage Tickets</a>
                </div>

                <!-- Ticket Report Card -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">Ticket Reports</h3>
                    <p class="text-gray-600 mt-2">Generate and view reports for all tickets.</p>
                    <a href="{#}" class="text-yellow-500 hover:underline mt-4 block">View Reports</a>
                </div>

                <!-- Cash Report Card -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">Cash Reports</h3>
                    <p class="text-gray-600 mt-2">Generate cash reports for ticket collections.</p>
                    <a href="{#}" class="text-yellow-500 hover:underline mt-4 block">View Cash Report</a>
                </div>

                <!-- User Management Card -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">User Management</h3>
                    <p class="text-gray-600 mt-2">Manage system users and assign roles.</p>
                    <a href="{#}" class="text-yellow-500 hover:underline mt-4 block">Manage Users</a>
                </div>

                <!-- Settings Card -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-700">Settings</h3>
                    <p class="text-gray-600 mt-2">Adjust system settings as needed.</p>
                    <a href="{#}" class="text-yellow-500 hover:underline mt-4 block">Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
