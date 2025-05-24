{{-- filepath: resources/views/cargoMan/layout/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cargo Management')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        @include('cargoMan.layout.sidebar')

        <div class="flex-1 flex flex-col overflow-auto">
            @include('cargoMan.layout.header')

            <main class="p-6 bg-gray-50 min-h-screen">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>