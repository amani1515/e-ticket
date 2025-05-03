@extends('ticketer.layout.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Daily Cash Report</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <p class="text-gray-700 text-lg">Total Amount Collected Today: 
            <span class="font-semibold text-blue-600">{{ number_format($totalAmount, 2) }} Birr</span>
        </p>
    </div>

    @if(!$alreadySubmitted)
        <form method="POST" action="{{ route('ticketer.cash-report.submit') }}">
            @csrf
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Submit Report
            </button>
        </form>
    @else
        <p class="text-green-600 font-semibold">You have already submitted today’s report.</p>
    @endif
</div>
@endsection
