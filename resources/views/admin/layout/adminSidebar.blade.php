<div x-data="{ openSidebar: false }" class="relative md:static h-screen">

    <!-- Hamburger Button -->
    <button @click="openSidebar = true" x-show="!openSidebar"
        class="fixed top-4 left-4 z-50 md:hidden p-3 text-white bg-gradient-to-r from-amber-500 to-yellow-500 rounded-xl shadow-lg transition duration-300 hover:from-amber-600 hover:to-yellow-600 transform hover:scale-105"
        x-cloak>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Sidebar -->
    <div :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
        class="fixed z-40 inset-y-0 left-0 w-72 bg-gradient-to-b from-amber-900 via-amber-800 to-yellow-900 text-amber-100 transform transition-transform duration-300 md:translate-x-0 md:relative md:flex md:flex-col shadow-2xl h-screen">
        
        <!-- Close Button -->
        <button @click="openSidebar = false"
            class="md:hidden absolute top-4 right-4 text-amber-200 hover:text-white bg-amber-700 hover:bg-amber-600 rounded-lg p-2 transition duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Logo & Title Section -->
        <div class="p-6 border-b border-amber-700">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-yellow-300">E-Ticket</h1>
                    <p class="text-sm text-amber-300 capitalize">{{ Auth::user()->usertype ?? 'User' }} Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 px-4 py-6 overflow-y-auto">
            <nav class="space-y-2">
                @if (Auth::user()->usertype === 'headoffice')
                    <!-- HeadOffice Menu Items -->
                    <a href="{{ route('admin.passenger-report') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium">Passenger Report</span>
                    </a>
                    
                    <a href="{{ route('admin.buses.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                        </svg>
                        <span class="font-medium">All Buses</span>
                    </a>
                    
                    <a href="{{ route('admin.bus.reports') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="font-medium">Bus Report</span>
                    </a>
                    
                    <a href="{{ route('admin.total.reports') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Total Report</span>
                    </a>
                    
                    <a href="{{ route('admin.schedule.reports') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                        </svg>
                        <span class="font-medium">Schedule Reports</span>
                    </a>
                    
                    <a href="{{ route('admin.reports.transactions') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                        <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <span class="font-medium">Transactions</span>
                    </a>
                @else
                    <!-- Admin Menu Items -->
                    <div x-data="{ openUser: false, openDestination: false, openMahberat: false, openReports: false }">
                        <!-- User Management -->
                        <div class="group">
                            <button @click="openUser = !openUser"
                                class="flex items-center justify-between w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <span class="font-medium">User Management</span>
                                </div>
                                <svg :class="{ 'rotate-180': openUser }" class="w-4 h-4 transform transition-transform duration-200">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" stroke="currentColor" fill="none" />
                                </svg>
                            </button>
                            <div x-show="openUser" x-collapse class="ml-8 mt-2 space-y-1">
                                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    All Users
                                </a>
                                <a href="{{ route('admin.users.create') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add New User
                                </a>
                            </div>
                        </div>

                        <!-- Destinations -->
                        <div class="group">
                            <button @click="openDestination = !openDestination"
                                class="flex items-center justify-between w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">Destinations</span>
                                </div>
                                <svg :class="{ 'rotate-180': openDestination }" class="w-4 h-4 transform transition-transform duration-200">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" stroke="currentColor" fill="none" />
                                </svg>
                            </button>
                            <div x-show="openDestination" x-collapse class="ml-8 mt-2 space-y-1">
                                <a href="{{ route('admin.destinations.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    All Destinations
                                </a>
                                <a href="{{ route('admin.destinations.create') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Destination
                                </a>
                            </div>
                        </div>

                        <!-- Mahberats -->
                        <div class="group">
                            <button @click="openMahberat = !openMahberat"
                                class="flex items-center justify-between w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="font-medium">Mahberats</span>
                                </div>
                                <svg :class="{ 'rotate-180': openMahberat }" class="w-4 h-4 transform transition-transform duration-200">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" stroke="currentColor" fill="none" />
                                </svg>
                            </button>
                            <div x-show="openMahberat" x-collapse class="ml-8 mt-2 space-y-1">
                                <a href="{{ route('admin.mahberats.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    All Mahberats
                                </a>
                                <a href="{{ route('admin.mahberats.create') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Mahberat
                                </a>
                            </div>
                        </div>

                        <!-- Reports -->
                        <div class="group">
                            <button @click="openReports = !openReports"
                                class="flex items-center justify-between w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span class="font-medium">Reports</span>
                                </div>
                                <svg :class="{ 'rotate-180': openReports }" class="w-4 h-4 transform transition-transform duration-200">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" stroke="currentColor" fill="none" />
                                </svg>
                            </button>
                            <div x-show="openReports" x-collapse class="ml-8 mt-2 space-y-1">
                                <a href="{{ route('admin.passenger-report') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Passenger Report
                                </a>
                                <a href="{{ route('admin.buses.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                    </svg>
                                    All Buses
                                </a>
                                <a href="{{ route('admin.bus.reports') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Bus Report
                                </a>
                                <a href="{{ route('admin.cash.reports') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Cash Report
                                </a>
                                <a href="{{ route('admin.total.reports') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Total Report
                                </a>
                                <a href="{{ route('admin.schedule.reports') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                                    </svg>
                                    Schedule Reports
                                </a>
                                <a href="{{ route('admin.reports.transactions') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    Transactions
                                </a>
                                <a href="{{ route('admin.tickets.scan') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-amber-700 hover:text-yellow-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                    Scan Ticket
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Sync Management -->
                @if (Auth::user()->usertype !== 'headoffice')
                    <div class="group">
                        <a href="{{ route('admin.sync.index') }}"
                            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                            <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span class="font-medium">Data Sync</span>
                        </a>
                    </div>
                @endif

                <!-- System Settings -->
                @if (Auth::user()->usertype !== 'headoffice')
                    <div class="group">
                        <a href="{{ route('admin.cargo-settings.index') }}"
                            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                            <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">System Settings</span>
                        </a>
                    </div>
                @endif

                <!-- Export -->
                @if (Auth::user()->usertype !== 'headoffice')
                    <div class="group">
                        <a href="{{ route('admin.export.index') }}"
                            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-amber-700 hover:text-yellow-300 group-hover:shadow-lg">
                            <svg class="w-5 h-5 mr-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-medium">Export</span>
                        </a>
                    </div>
                @endif
            </nav>
        </div>

        <!-- User Profile Section -->
        <div class="p-4 border-t border-amber-700">
            <div class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-amber-800">
                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center">
                    <span class="text-amber-900 font-bold text-sm">{{ substr(Auth::user()->name, 0, 2) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-yellow-300 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-amber-300 capitalize">{{ Auth::user()->usertype }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
