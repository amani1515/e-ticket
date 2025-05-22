@extends('mahberat.layout.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-yellow-700 via-yellow-600 to-yellow-700 p-8">
        <!-- Welcome Header -->
        <h1 class="text-3xl font-extrabold text-yellow-100 drop-shadow mb-8">👋 Welcome, <span class="text-white">{{ Auth::user()->name }}</span></h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Buses -->
            <div class="bg-white/90 border border-yellow-300 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                <h2 class="text-lg font-semibold text-yellow-700 flex items-center gap-2">
                    <span class="text-yellow-500">🚌</span>
                    <span>Total Buses</span>
                </h2>
                <p class="text-3xl font-extrabold text-yellow-700 mt-2 drop-shadow">--</p>
            </div>

            <!-- Total Drivers -->
            <div class="bg-white/90 border border-yellow-300 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                <h2 class="text-lg font-semibold text-amber-700 flex items-center gap-2">
                    <span class="text-amber-500">🧑‍✈️</span>
                    <span>Total Drivers</span>
                </h2>
                <p class="text-3xl font-extrabold text-amber-700 mt-2 drop-shadow">--</p>
            </div>

            <!-- Buses In Today -->
            <div class="bg-white/90 border border-yellow-300 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                <h2 class="text-lg font-semibold text-green-700 flex items-center gap-2">
                    <span class="text-green-500">🟢</span>
                    <span>Buses In Today</span>
                </h2>
                <p class="text-3xl font-extrabold text-green-700 mt-2 drop-shadow">--</p>
            </div>

            <!-- Buses Out Today -->
            <div class="bg-white/90 border border-yellow-300 p-6 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                <h2 class="text-lg font-semibold text-rose-700 flex items-center gap-2">
                    <span class="text-rose-500">🔴</span>
                    <span>Buses Out Today</span>
                </h2>
                <p class="text-3xl font-extrabold text-rose-700 mt-2 drop-shadow">--</p>
            </div>
        </div>
    </div>
@endsection
