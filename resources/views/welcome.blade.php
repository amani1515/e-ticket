<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ኢ-ትኬት - የህዝብ ማመላለሻ አውቶብስ መቆጣጠሪያ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') {{-- Tailwind with Vite --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 text-gray-800">

    {{-- Navbar --}}
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-3xl font-extrabold text-yellow-600 tracking-tight">ኢ-ትኬት</h1>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="#home" class="hover:text-yellow-500 transition">ዋና ገጽ</a>
                <a href="#features" class="hover:text-yellow-500 transition">ልዩ ልዩ</a>
                <a href="#contact" class="hover:text-yellow-500 transition">ግንኙነት</a>
                <a href="{{ route('login') }}"
                    class="bg-gradient-to-r from-yellow-600 to-yellow-500 text-white px-5 py-2 rounded-full shadow hover:scale-105 transition transform duration-300">ግባ</a>
            </nav>
        </div>
    </header>

    {{-- Hero Section --}}
    <section id="home" class="bg-gradient-to-r from-yellow-700 via-yellow-600 to-yellow-500 text-white py-24">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-5xl font-extrabold mb-4 leading-tight drop-shadow-md">ዘመናዊ የህዝብ አውቶብስ ትኬት አስተዳደር</h2>
            <p class="text-xl mb
