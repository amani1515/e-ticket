<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- adjust based on setup -->
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        @include('ticketer.layout.ticketerSidebar')

        <div class="flex-1 flex flex-col">
            @include('ticketer.layout.ticketerHeader')

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
