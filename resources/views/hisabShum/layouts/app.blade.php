<!-- filepath: resources/views/hisabShum/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Hisab Shum')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100">
    @include('hisabShum.layouts.header')
    <div class="flex">
        @include('hisabShum.layouts.sidebar')
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>