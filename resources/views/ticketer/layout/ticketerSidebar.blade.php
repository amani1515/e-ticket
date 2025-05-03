<aside class="w-64 bg-gray-800 text-white h-screen fixed top-0 left-0">
    <div class="p-4 text-lg font-bold border-b border-gray-700">
Ticketer dashboard    </div>
    <nav class="p-4">
        <ul>
            <li class="mb-2">
                <a href="#" class="hover:bg-gray-700 block px-3 py-2 rounded">Dashboard</a>
            </li>
            <li class="mb-2">
                <button onclick="toggleMenu('ticket-submenu')" class="w-full text-left px-3 py-2 hover:bg-gray-700 rounded focus:outline-none">
                    Tickets
                </button>
                <ul id="ticket-submenu" class="ml-4 hidden">
                    <li>
                        <a href="{{ route('mahberat.bus.index') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">create ticket</a>
                    </li>
                    <li>
                        <a href="{{ route('mahberat.bus.create') }}" class="hover:bg-gray-700 block px-3 py-2 rounded"> Scan ticket</a>
                    </li>
                </ul>
            </li>
            <li class="mb-2">
                <button onclick="toggleMenu('report-submenu')" class="w-full text-left px-3 py-2 hover:bg-gray-700 rounded focus:outline-none">
                    Reports
                </button>
                <ul id="report-submenu" class="ml-4 hidden">
                    <li>
                        <a href="{{ route('mahberat.schedule.index') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">Ticket report</a>
                    </li>
                    <li>
                        <a href="{{ route('mahberat.schedule.create') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">Cash report</a>
                    </li>
                    <li>
                        <a href="{{ route('schedules.card-view') }}" class="hover:bg-gray-700 block px-3 py-2 rounded">cars report view</a>
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
