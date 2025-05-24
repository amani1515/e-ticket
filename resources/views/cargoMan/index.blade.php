{{-- filepath: resources/views/cargoMan/index.blade.php --}}
@extends('cargoMan.layout.app')

@section('title', 'Cargo Man Home')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Cargo Man Dashboard</h1>
    {{-- Add dashboard content here --}}

    <form method="POST" action="{{ route('logout') }}" class="mt-6">
        @csrf
        <button class="text-red-700 hover:underline font-semibold">Logout</button>
    </form>
@endsection