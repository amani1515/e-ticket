@extends('admin.layout.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}</h2>
    <p>This is the admin dashboard.</p>
@endsection
