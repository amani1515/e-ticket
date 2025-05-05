@extends('ticketer.layout.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white shadow p-6 rounded">
    <h2 class="text-lg font-bold mb-4">Scan Ticket</h2>

    @if(session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="text-red-600">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('ticketer.tickets.processScan') }}">
        @csrf
        <label class="block mb-2">Scan or Enter Ticket Code:</label>
        <input type="text" name="ticket_code" class="w-full border px-3 py-2 mb-4" placeholder="SE202504291234" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirm Ticket</button>
    </form>

    
</div>
@endsection
@section('scripts')
<script>
    const input = document.querySelector('input[name="ticket_code"]');
    input.focus();

    input.addEventListener('input', function () {
        if (this.value.length >= 14) { // Adjust length if needed
            this.form.submit();
        }
    });
</script>
@endsection
