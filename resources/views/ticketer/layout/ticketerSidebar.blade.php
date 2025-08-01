<div class="w-72 min-h-screen bg-gradient-to-b from-blue-900 via-blue-800 to-indigo-900 text-blue-100 flex flex-col shadow-2xl lg:relative lg:translate-x-0 fixed inset-y-0 left-0 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out" id="sidebar">
    
    <!-- Logo & Title Section -->
    <div class="p-6 border-b border-blue-700">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-yellow-300">E-Ticket</h1>
                <p class="text-sm text-blue-300">Ticketer Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 px-4 py-6 overflow-y-auto">
        <nav x-data="{ openTickets: false, openReports: false }" class="space-y-2">
            
            <!-- Tickets Management -->
            <div class="group">
                <button @click="openTickets = !openTickets"
                    class="flex items-center justify-between w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-blue-700 hover:text-yellow-300 group-hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        <span class="font-medium">Ticket Management</span>
                    </div>
                    <svg :class="{ 'rotate-180': openTickets }" class="w-4 h-4 transform transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" stroke="currentColor" fill="none" />
                    </svg>
                </button>
                <div x-show="openTickets" x-collapse class="ml-8 mt-2 space-y-1">
                    <a href="{{ route('ticketer.tickets.create') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 hover:text-yellow-300 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Ticket
                    </a>
                    <a href="{{ route('ticketer.tickets.scan') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 hover:text-yellow-300 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Scan Ticket
                    </a>
                </div>
            </div>

            <!-- Reports -->
            <div class="group">
                <button @click="openReports = !openReports"
                    class="flex items-center justify-between w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-blue-700 hover:text-yellow-300 group-hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="font-medium">Reports</span>
                    </div>
                    <svg :class="{ 'rotate-180': openReports }" class="w-4 h-4 transform transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" stroke="currentColor" fill="none" />
                    </svg>
                </button>
                <div x-show="openReports" x-collapse class="ml-8 mt-2 space-y-1">
                    <a href="{{ route('ticketer.tickets.report') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 hover:text-yellow-300 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Ticket Report
                    </a>
                    <a href="{{ route('ticketer.cash-report.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 hover:text-yellow-300 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cash Report
                    </a>
                    <a href="{{ route('ticketer.schedule.report') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 hover:text-yellow-300 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                        </svg>
                        Schedule Report
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- User Profile Section -->
    <div class="p-4 border-t border-blue-700">
        <div class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-blue-800">
            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center">
                <span class="text-blue-900 font-bold text-sm">{{ substr(Auth::user()->name, 0, 2) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-yellow-300 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-blue-300">Ticketer</p>
            </div>
        </div>
    </div>
</div>
