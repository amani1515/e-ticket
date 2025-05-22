@extends('mahberat.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 via-white to-gray-100 p-6">
    <!-- Welcome Header -->
    <h1 class="text-3xl font-extrabold text-gray-800 drop-shadow mb-8">
        👋 Welcome, <span class="text-blue-700">{{ Auth::user()->name }}</span>
    </h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Buses -->
        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
            <h2 class="text-lg font-semibold text-gray-600 flex items-center gap-2">
                <span class="text-blue-600">🚌</span>
                <span>Total Buses</span>
            </h2>
            <p class="text-3xl font-bold text-blue-700 mt-2">--</p>
        </div>

        <!-- Total Drivers -->
        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
            <h2 class="text-lg font-semibold text-gray-600 flex items-center gap-2">
                <span class="text-purple-600">🧑‍✈️</span>
                <span>Total Drivers</span>
            </h2>
            <p class="text-3xl font-bold text-purple-700 mt-2">--</p>
        </div>

        <!-- Buses In Today -->
        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
            <h2 class="text-lg font-semibold text-gray-600 flex items-center gap-2">
                <span class="text-green-500">🟢</span>
                <span>Buses In Today</span>
            </h2>
            <p class="text-3xl font-bold text-green-600 mt-2">--</p>
        </div>

        <!-- Buses Out Today -->
        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
            <h2 class="text-lg font-semibold text-gray-600 flex items-center gap-2">
                <span class="text-red-500">🔴</span>
                <span>Buses Out Today</span>
            </h2>
            <p class="text-3xl font-bold text-red-600 mt-2">--</p>
        </div>
    </div>
</div>
@endsection
