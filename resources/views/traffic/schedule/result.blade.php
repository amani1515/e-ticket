{{-- resources/views/traffic/schedule/result.blade.php --}}

@extends('traffic.layout.app')

@section('content')
<div class="max-w-xl mx-auto mt-12 p-8 bg-white shadow-lg rounded-2xl">
    <h2 class="text-3xl font-extrabold text-blue-700 mb-6 text-center tracking-wide">Schedule Details</h2>

    <div class="divide-y divide-gray-200">
        <div class="flex justify-between py-4">
            <span class="font-semibold text-gray-600">Schedule UID:</span>
            <span class="text-gray-900">{{ $schedule->schedule_uid }}</span>
            <span class="text-gray-900 font-bold px-3 py-1 rounded-full 
                @if($schedule->status === 'departed') bg-green-100 text-green-700 
                @elseif($schedule->status === 'Pending') bg-yellow-100 text-yellow-700 
                @elseif($schedule->status === 'Cancelled') bg-red-100 text-red-700 
                @else bg-gray-200 text-gray-700 @endif
                animate-bounce
                text-2xl
                md:text-4xl
                py-3 px-6
            ">
                {{ ucfirst($schedule->status) }}
            </span>
        </div>
        <div class="flex justify-between py-4">
            <span class="font-semibold text-gray-600">Date:</span>
            <span class="text-gray-900">{{ $schedule->date ?? ($schedule->scheduled_at ?? '-') }}</span>
        </div>
        <div class="flex justify-between py-4">
            <span class="font-semibold text-gray-600">Departure:</span>
            <span class="text-gray-900">
                {{ $schedule->departure ?? ($schedule->destination->start_from ?? '-') }}
            </span>
        </div>
        <div class="py-4">
            <span class="font-semibold text-gray-600 block mb-1">Destination Details:</span>
            @if(isset($schedule->destination) && is_object($schedule->destination))
                <div class="ml-4 space-y-1 text-gray-800">
                    <div><span class="font-semibold">Name:</span> {{ $schedule->destination->destination_name }}</div>
                    <div><span class="font-semibold">From:</span> {{ $schedule->destination->start_from }}</div>
                    <div><span class="font-semibold">Tariff:</span> {{ $schedule->destination->tariff }}</div>
                    <div><span class="font-semibold">Tax:</span> {{ $schedule->destination->tax }}</div>
                    <div><span class="font-semibold">Service Fee:</span> {{ $schedule->destination->service_fee }}</div>
                </div>
            @else
                <span class="text-gray-400">No destination info</span>
            @endif
        </div>

        <div class="py-4">
            <span class="font-semibold text-gray-600 block mb-1">Bus Information:</span>
            @if(isset($schedule->bus) && is_object($schedule->bus))
                <div class="ml-4 space-y-1 text-gray-800">
                    <div><span class="font-semibold">Targa:</span> {{ $schedule->bus->targa }}</div>
                    <div><span class="font-semibold">Driver Name:</span> {{ $schedule->bus->driver_name }}</div>
                    <div><span class="font-semibold">Driver Phone:</span> {{ $schedule->bus->driver_phone }}</div>
                    <div><span class="font-semibold">Redat Name:</span> {{ $schedule->bus->redat_name }}</div>
                    <div><span class="font-semibold">Level:</span> {{ $schedule->bus->level }}</div>
                    <div><span class="font-semibold">Total Seats:</span> {{ $schedule->bus->total_seats }}</div>
                    <div><span class="font-semibold">Model Year:</span> {{ $schedule->bus->model_year }}</div>
                    <div><span class="font-semibold">Model:</span> {{ $schedule->bus->model }}</div>
                    <div><span class="font-semibold">Bolo ID:</span> {{ $schedule->bus->bolo_id }}</div>
                    <div><span class="font-semibold">Motor Number:</span> {{ $schedule->bus->motor_number }}</div>
                    <div><span class="font-semibold">Color:</span> {{ $schedule->bus->color }}</div>
                  
                  
                </div>
            @else
                <span class="text-gray-400">No bus info</span>
            @endif
        </div>
    </div>
</div>
@endsection
