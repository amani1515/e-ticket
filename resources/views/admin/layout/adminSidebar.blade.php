<div x-data="{ openSidebar: false }" class="relative">
    <!-- Hamburger Icon -->
    <button @click="openSidebar = !openSidebar" class="md:hidden p-2 text-white bg-yellow-900 rounded focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Sidebar -->
    <div :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 w-64 bg-yellow-900 text-white transform transition-transform duration-300 md:translate-x-0 md:relative md:flex md:flex-col p-4">
        <div class="text-2xl font-bold mb-6">
            <a href="{{ route('admin.index') }}">Admin Panel</a>
        </div>

        <div x-data="{ openUser: false, openReports: false }" class="space-y-2">
            <!-- User Menu -->
            <div>
                <button @click="openUser = !openUser"
                    class="w-full text-left font-semibold flex justify-between items-center">
                    User
                    <svg :class="{ 'rotate-180': openUser }" class="w-4 h-4 transform transition-transform" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openUser" x-cloak class="ml-4 mt-2 space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="block hover:text-yellow-300">All Users</a>
                    <a href="{{ route('admin.users.create') }}" class="block hover:text-yellow-300">Add New User</a>
                    <a href="#" class="block hover:text-yellow-300">Passengers</a>
                </div>
            </div>

            <!-- Destination Menu -->
            <div>
                <button @click="openReports = !openReports"
                    class="w-full text-left font-semibold flex justify-between items-center">
                    Destination
                    <svg :class="{ 'rotate-180': openReports }" class="w-4 h-4 transform transition-transform"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openReports" x-cloak class="ml-4 mt-2 space-y-1">
                    <a href="{{ route('admin.destinations.index') }}"
                        class="block hover:text-yellow-300">Destinations</a>
                    <a href="{{ route('admin.destinations.create') }}" class="block hover:text-yellow-300">Add new
                        destination</a>
                </div>
            </div>

            <!-- Reports Menu -->
            <div>
                <button @click="openReports = !openReports"
                    class="w-full text-left font-semibold flex justify-between items-center">
                    Reports
                    <svg :class="{ 'rotate-180': openReports }" class="w-4 h-4 transform transition-transform"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openReports" x-cloak class="ml-4 mt-2 space-y-1">
                    <a href="{{ route('admin.passenger-report') }}"
                        class="block px-4 py-2 hover:text-yellow-300">Passenger Report</a>
                    <a href="#" class="block hover:text-yellow-300">Bus Report</a>
                    <a href="{{ route('admin.cash.reports') }}" class="block hover:text-yellow-300">Cash Report</a>
                </div>
            </div>
        </div>
    </div>
</div>
