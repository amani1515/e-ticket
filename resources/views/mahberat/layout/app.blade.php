<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mahberat Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- adjust based on setup -->
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        @include('mahberat.layout.sidebar')

        <div class="flex-1 flex flex-col">
            @include('mahberat.layout.header')

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
