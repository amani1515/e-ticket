@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="//unpkg.com/alpinejs" defer></script>

<body class="bg-gray-100 text-gray-900">
    <div x-data="{ open: false }" class="flex h-screen">

        <!-- Backdrop (mobile only) -->
        <div x-show="open" @click="open = false" x-transition
             class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="{ '-translate-x-full': !open, 'translate-x-0': open }"
               class="fixed z-40 inset-y-0 left-0 w-64 transform bg-gray-800 text-white transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            @include('balehabt.layout.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header (mobile only) -->
            <header class="flex items-center justify-between px-4 py-3 bg-white border-b lg:hidden">
                <button @click="open = !open" class="text-gray-700 focus:outline-none">
                    <!-- Hamburger icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                @include('balehabt.layout.header')
            </header>

            <!-- Desktop Header -->
            <div class="hidden lg:block p-4 bg-white shadow">
                @include('balehabt.layout.header')
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-4 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
