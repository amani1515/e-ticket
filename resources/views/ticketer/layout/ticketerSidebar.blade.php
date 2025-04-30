<!-- resources/views/ticketer/layout/ticketerSidebar.blade.php -->
<div class="bg-gray-800 text-white w-64 h-screen p-4">
    <div class="space-y-6">
        <div class="text-2xl font-bold text-yellow-300">Ticketer Dashboard</div>
        <ul class="space-y-4">
            <!-- Ticket Menu -->
            <li>
                <button @click="openTickets = !openTickets" class="w-full text-left font-semibold flex justify-between items-center">
                    Ticket
                    <svg :class="{'rotate-180': openTickets}" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openTickets" x-cloak class="ml-4 mt-2 space-y-1">
                    <a href="{{ route('ticketer.tickets.create') }}" class="block hover:text-yellow-300">Create Ticket</a>
                    <a href="{{ route('ticketer.tickets.report') }}" class="block hover:text-yellow-300">Ticket Report</a>
                    <a href="{{ route('ticketer.tickets.scan') }}" class="block hover:text-yellow-300">Scan Ticket</a>
                </div>
            </li>
        </ul>
    </div>
</div>
