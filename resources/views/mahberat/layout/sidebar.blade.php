<aside class="w-64 bg-gray-800 text-white h-screen fixed top-0 left-0">
    <div class="p-4 text-lg font-bold border-b border-gray-700">
        Mahberat Menu
    </div>
    <nav class="p-4">
        <ul>
            <li class="mb-2">
                <a href="#" class="hover:bg-gray-700 block px-3 py-2 rounded">Dashboard</a>
            </li>
            <li class="mb-2">
                <button onclick="toggleMenu('bus-submenu')" class="w-full text-left px-3 py-2 hover:bg-gray-700 rounded focus:outline-none">
                    Bus
                </button>
                <ul id="bus-submenu" class="ml-4 hidden">
                    <li>
                        <a href="{{ route('mahberat.bus.index') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">All Buses</a>
                    </li>
                    <li>
                        <a href="{{ route('mahberat.bus.create') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">Add Bus</a>
                    </li>
                </ul>
            </li>
            <li class="mb-2">
                <button onclick="toggleMenu('report-submenu')" class="w-full text-left px-3 py-2 hover:bg-gray-700 rounded focus:outline-none">
                    Schedules
                </button>
                <ul id="report-submenu" class="ml-4 hidden">
                    <li>
                        <a href="{{ route('mahberat.schedule.index') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">View schedule</a>
                    </li>
                    <li>
                        <a href="{{ route('mahberat.schedule.create') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">Add schedule</a>
                    </li>
                    <li>
                        <a href="{{ route('schedules.card-view') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">Card view</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>

<!-- JS to toggle submenu -->
<script>
    function toggleMenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle('hidden');
    }
</script>
