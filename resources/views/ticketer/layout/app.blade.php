@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="//unpkg.com/alpinejs" defer></script>

<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar (hidden on small screens, toggled via Alpine.js) --}}
        <div 
            x-data="{ open: false }" 
            class="lg:flex lg:w-64"
        >
            <div 
                :class="{ 'block': open, 'hidden': !open }" 
                class="fixed inset-0 z-30 bg-black bg-opacity-50 transition-opacity lg:hidden"
                @click="open = false"
            ></div>

            <div 
                class="fixed z-40 inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform lg:static lg:inset-0 lg:translate-x-0"
                :class="{ '-translate-x-full': !open, 'translate-x-0': open }"
            >
                @include('ticketer.layout.ticketerSidebar')
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-auto">
            @include('ticketer.layout.ticketerHeader')

            {{-- Toggle Sidebar Button (for mobile) --}}
            <div class="p-4 lg:hidden">
                <button @click="$root.querySelector('[x-data]').__x.$data.open = true" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Open Menu
                </button>
            </div>

            <main class="p-6 bg-white min-h-screen lg:ml-64">
                @yield('content')
            </main>
        </div>
    </div>
</body>
