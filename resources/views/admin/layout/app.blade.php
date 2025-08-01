<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gradient-to-br from-amber-50 to-yellow-100 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layout.adminSidebar')

        <div class="flex-1 flex flex-col overflow-auto">
            @include('admin.layout.adminHeader')

            <main class="flex-1 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
