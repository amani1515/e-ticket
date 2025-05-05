@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="//unpkg.com/alpinejs" defer></script>

<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        @include('ticketer.layout.ticketerSidebar')

        <div class="flex-1 flex flex-col overflow-auto">
            @include('ticketer.layout.ticketerHeader')

            <main class="p-6 bg-white min-h-screen ml-64">
                @yield('content')
            </main>
        </div>
    </div>
</body>
