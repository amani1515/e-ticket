<div x-data="{ openSidebar: false }" class="relative md:static h-screen">

    <!-- Hamburger Button -->
    <button @click="openSidebar = true" x-show="!openSidebar"
        class="fixed top-4 left-4 z-50 md:hidden p-2 text-yellow-400 bg-black border border-yellow-400 rounded shadow-lg transition duration-300 hover:bg-yellow-400 hover:text-black"
        x-cloak>
        <!-- Hamburger Icon -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Sidebar -->
    <div :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
        class="fixed z-40 inset-y-0 left-0 w-64 bg-black text-yellow-300 transform transition-transform duration-300 md:translate-x-0 md:relative md:flex md:flex-col p-6 space-y-6 shadow-lg h-screen">
        <!-- Close Button -->
        <button @click="openSidebar = false"
            class="md:hidden text-yellow-300 hover:text-red-400 bg-transparent border border-yellow-300 rounded p-2 self-end">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Sidebar Title -->
        <div class="text-2xl font-extrabold tracking-wide text-yellow-400">
            <a href="/home">{{ Auth::user()->usertype ?? 'User' }} Panel</a>
        </div>

        <!-- Menu Items -->
        <div x-data="{ openUser: false, openDestination: false, openReports: false }" class="space-y-4">
            <!-- User -->
            <div>
                <button @click="openUser = !openUser"
                    class="flex justify-between items-center w-full font-semibold hover:text-yellow-500">
                    User
                    <svg :class="{ 'rotate-180': openUser }" class="w-4 h-4 transform transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" stroke="currentColor"
                            fill="none" stroke-width="2" />
                    </svg>
                </button>
                <div x-show="openUser" x-cloak class="ml-4 mt-2 space-y-1 text-sm">
                    <a href="{{ route('admin.users.index') }}" class="block hover:text-yellow-500">All Users</a>
                    @if (Auth::user()->usertype !== 'headoffice')
                        <a href="{{ route('admin.users.create') }}" class="block hover:text-yellow-500">Add New User</a>
                    @endif
                    <a href="#" class="block hover:text-yellow-500">Passengers</a>
                </div>
            </div>

            <!-- Destination -->
            <div>
                <button @click="openDestination = !openDestination"
                    class="flex justify-between items-center w-full font-semibold hover:text-yellow-500">
                    Destination
                    <svg :class="{ 'rotate-180': openDestination }" class="w-4 h-4 transform transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" stroke="currentColor"
                            fill="none" stroke-width="2" />
                    </svg>
                </button>
                <div x-show="openDestination" x-cloak class="ml-4 mt-2 space-y-1 text-sm">
                    <a href="{{ route('admin.destinations.index') }}"
                        class="block hover:text-yellow-500">Destinations</a>
                    @if (Auth::user()->usertype !== 'headoffice')
                        <a href="{{ route('admin.destinations.create') }}" class="block hover:text-yellow-500">Add New
                            Destination</a>
                    @endif
                </div>
            </div>
            <!-- Destination -->
            <div>
                <button @click="openDestination = !openDestination"
                    class="flex justify-between items-center w-full font-semibold hover:text-yellow-500">
                    Mahberat
                    <svg :class="{ 'rotate-180': openDestination }" class="w-4 h-4 transform transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" stroke="currentColor"
                            fill="none" stroke-width="2" />
                    </svg>
                </button>
                <div x-show="openDestination" x-cloak class="ml-4 mt-2 space-y-1 text-sm">
                    <a href="{{ route('admin.mahberats.index') }}" class="block hover:text-yellow-500">Mahberats</a>
                    @if (Auth::user()->usertype !== 'headoffice')
                        <a href="{{ route('admin.mahberats.create') }}" class="block hover:text-yellow-500">Add New
                            Mahber</a>
                    @endif
                </div>
            </div>

            <!-- Reports -->
            <div>
                <button @click="openReports = !openReports"
                    class="flex justify-between items-center w-full font-semibold hover:text-yellow-500">
                    Reports
                    <svg :class="{ 'rotate-180': openReports }" class="w-4 h-4 transform transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" stroke="currentColor"
                            fill="none" stroke-width="2" />
                    </svg>
                </button>
                <div x-show="openReports" x-cloak class="ml-4 mt-2 space-y-1 text-sm">
                    <a href="{{ route('admin.passenger-report') }}" class="block hover:text-yellow-500">Passenger
                        Report</a>
                    <a href="{{ route('admin.buses.index') }}" class="block hover:text-yellow-500">All Buses</a>
                    <a href="{{ route('admin.bus.reports') }}" class="block hover:text-yellow-500">Bus Report</a>
                    <a href="{{ route('admin.cash.reports') }}" class="block hover:text-yellow-500">Cash Report</a>
                    <a href="{{ route('admin.total.reports') }}" class="block hover:text-yellow-500">Total Report</a>
                    <a href="{{ route('admin.schedule.reports') }}" class="block hover:text-yellow-500">Schedule
                        Reports</a>
                        
                   <a href="{{ route('admin.reports.transactions') }}" class="block hover:text-yellow-500">Transaction</a>

                </div>
            </div>
            <!-- sidebar manue for sms templates  -->
{{-- <div>
    @if (Auth::user()->usertype !== 'headoffice')
        <a href="{{ route('admin.sms-template.index') }}"
            class="block hover:text-yellow-500 font-semibold">Sms templates</a>
    @endif
</div> --}}

            <div>
                @if (Auth::user()->usertype !== 'headoffice')
                    <a href="{{ route('admin.cargo-settings.index') }}"
                        class="block hover:text-yellow-500 font-semibold">System Settings</a>
                @endif
            </div>

        </div>
    </div>
</div>
