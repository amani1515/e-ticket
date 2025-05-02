@extends('mahberat.layout.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}</h1>

<div class="ml-64 p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold">Total Buses</h2>
            <p class="text-2xl">--</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold">Total Drivers</h2>
            <p class="text-2xl">--</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold">Buses In Today</h2>
            <p class="text-2xl">--</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold">Buses Out Today</h2>
            <p class="text-2xl">--</p>
        </div>
    </div>
</div>
@endsection
