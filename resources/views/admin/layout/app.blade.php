<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

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
</body>
