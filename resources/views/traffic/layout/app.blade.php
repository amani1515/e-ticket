<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Traffic Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gradient-to-br from-yellow-100 via-yellow-200 to-yellow-400 text-gray-900 min-h-screen">
    <div x-data="{ open: false }" class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <div class="lg:flex lg:w-64">
            <div :class="{ 'block': open, 'hidden': !open }"
                class="fixed inset-0 z-30 bg-black bg-opacity-50 transition-opacity lg:hidden" @click="open = false">
            </div>

            <div
                class="fixed z-40 inset-y-0 left-0 w-64 bg-gray-900 text-white shadow-lg transform transition-transform lg:static lg:inset-0 lg:translate-x-0"
                :class="{ '-translate-x-full': !open, 'translate-x-0': open }">
                @include('traffic.layout.sidebar')
            </div>
        </div>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col overflow-auto">
            {{-- Header with Hamburger for mobile --}}
            <div class="flex items-center justify-between p-4 bg-white shadow lg:hidden">
                <button @click="open = true" class="p-2 text-yellow-600 focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="text-lg font-bold text-yellow-700 drop-shadow">Traffic System</span>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-700 font-semibold">
                        {{ Auth::user()->name ?? 'Guest' }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            {{-- Header for large screens --}}
            <div class="hidden lg:block p-4 bg-white shadow">
                @include('traffic.layout.header')
            </div>

            <main class="p-2 sm:p-4 md:p-8 min-h-screen bg-gradient-to-br from-yellow-50 via-yellow-100 to-yellow-200 text-gray-900 rounded-t-3xl shadow-inner">
                <div class="max-w-4xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>
