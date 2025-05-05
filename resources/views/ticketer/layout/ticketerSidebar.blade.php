<div class="w-64 min-h-screen bg-gray-800 text-white flex flex-col p-4">
    <div class="text-2xl font-bold mb-6">
        <a href="/home">Ticketer Dashboard</a>
    </div>

    <div x-data="{ openTickets: false, openReports: false }" class="space-y-2">
        <!-- Tickets Menu -->
        <div>
            <button @click="openTickets = !openTickets" class="w-full text-left font-semibold flex justify-between items-center">
                Tickets
                <svg :class="{'rotate-180': openTickets}" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openTickets" x-cloak class="ml-4 mt-2 space-y-1">
                <a href="{{ route('ticketer.tickets.create') }}" class="block hover:text-gray-300">Create Ticket</a>
                <a href="{{ route('ticketer.tickets.scan') }}" class="block hover:text-gray-300">Scan Ticket</a>
            </div>
        </div>

        <!-- Reports Menu -->
        <div>
            <button @click="openReports = !openReports" class="w-full text-left font-semibold flex justify-between items-center">
                Reports
                <svg :class="{'rotate-180': openReports}" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openReports" x-cloak class="ml-4 mt-2 space-y-1">
                <a href="{{ route('ticketer.tickets.report') }}" class="block hover:text-gray-300">Ticket Report</a>
                <a href="{{ route('ticketer.cash-report.index') }}" class="block hover:text-gray-300">Cash Report</a>
            </div>
        </div>
    </div>
</div>
