<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'E-Ticket') }} - Ticketer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="lg:flex lg:w-72">
            @include('ticketer.layout.ticketerSidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-auto lg:ml-0">
            <!-- Header -->
            @include('ticketer.layout.ticketerHeader')
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
