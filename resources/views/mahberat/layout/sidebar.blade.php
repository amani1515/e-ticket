
    <!-- Logo / Title -->
    <div class="text-2xl font-bold text-white mb-8">
        <a href="/home" class="hover:text-yellow-400 transition">🚌 Mahberat Menu</a>
    </div>

    <!-- Navigation -->
    <nav class="space-y-2">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="/home" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    <span>🏠</span> <span>Dashboard</span>
                </a>
            </li>

            <!-- Bus Menu -->
            <li>
                <button onclick="toggleMenu('bus-submenu')" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-gray-800 transition focus:outline-none">
                    <span class="flex gap-2 items-center">
                        🚌 <span>Bus</span>
                    </span>
                    <svg class="w-4 h-4 transform transition-transform duration-200" id="icon-bus-submenu" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="bus-submenu" class="ml-6 mt-2 space-y-1 hidden">
                    <li><a href="{{ route('mahberat.bus.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">All Buses</a></li>
                    <li><a href="{{ route('mahberat.bus.create') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Add Bus</a></li>
                </ul>
            </li>

            <!-- Schedule Menu -->
            <li>
                <button onclick="toggleMenu('schedule-submenu')" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-gray-800 transition focus:outline-none">
                    <span class="flex gap-2 items-center">
                        📅 <span>Schedules</span>
                    </span>
                    <svg class="w-4 h-4 transform transition-transform duration-200" id="icon-schedule-submenu" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="schedule-submenu" class="ml-6 mt-2 space-y-1 hidden">
                    <li><a href="{{ route('mahberat.schedule.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">View Schedule</a></li>
                    <li><a href="{{ route('mahberat.schedule.create') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Add Schedule</a></li>
                    <li><a href="{{ route('schedules.card-view') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Card View</a></li>
                </ul>
            </li>

            <!-- Future Nav Example -->
            <li>
                <button onclick="toggleMenu('users-submenu')" class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-gray-800 transition focus:outline-none">
                    <span class="flex gap-2 items-center">
                        👤 <span>Users</span>
                    </span>
                    <svg class="w-4 h-4 transform transition-transform duration-200" id="icon-users-submenu" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="users-submenu" class="ml-6 mt-2 space-y-1 hidden">
                    <li><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">All Users</a></li>
                    <li><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Add User</a></li>
                </ul>
            </li>
        </ul>
    </nav>


<!-- JS for toggle -->
<script>
    function toggleMenu(id) {
        const submenu = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        submenu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
</script>
