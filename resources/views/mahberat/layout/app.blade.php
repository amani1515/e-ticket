<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mahberat Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 min-h-screen bg-gray-800 text-white flex flex-col p-4 fixed z-30 inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out md:relative md:inset-auto md:transform-none">
            @include('mahberat.layout.sidebar')
        </div>

        <!-- Hamburger Button (mobile only) -->
        <button id="sidebar-toggle" class="md:hidden fixed top-4 left-4 z-40 bg-gray-800 text-white p-2 rounded focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-auto">
            @include('mahberat.layout.header')

            <main class="p-6 bg-gray-50 min-h-screen pt-24">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            if (!sidebar.classList.contains('-translate-x-full')) {
                toggleBtn.style.display = 'none';
            }
        });

        document.addEventListener('click', function(e) {
            if (
                window.innerWidth < 768 &&
                !sidebar.contains(e.target) &&
                !toggleBtn.contains(e.target) &&
                !sidebar.classList.contains('-translate-x-full')
            ) {
                sidebar.classList.add('-translate-x-full');
                toggleBtn.style.display = '';
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                toggleBtn.style.display = '';
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
