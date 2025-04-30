
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="//unpkg.com/alpinejs" defer></script>

@vite(['resources/css/app.css'])

<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layout.adminSidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-auto">
            @include('admin.layout.adminHeader')

            <main class="p-6 bg-white min-h-screen">
                @yield('content')
            </main>
        </div>
    </div>
    @vite(['resources/js/app.js'])
</body>