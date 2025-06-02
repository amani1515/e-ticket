@extends('ticketer.layout.app')

@section('content')
<div class="flex min-h-screen">
   

    <!-- Main Content -->
    <div class="flex-1 bg-gray-100 p-6">
        <h1 class="text-2xl font-semibold mb-4">Create Ticket</h1>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form action="{{ route('ticketer.tickets.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="passenger_name" class="block">Passenger Full Name</label>
                <input type="text" name="passenger_name" id="passenger_name" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="age_status" class="block">Age Status</label>
                <select name="age_status" id="age_status" class="w-full p-2 border rounded" required>
                    <option value="adult">ወጣት</option>
                    <option value="baby">ህጻን </option>
                    <option value="middle_aged">ጎልማሳ</option>
                    <option value="senior">ሽማግሌ </option>

                </select>
            </div>

            <div class="mb-4">
                <label for="gender" class="block">Gender</label>
                <select name="gender" id="gender" class="w-full p-2 border rounded" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="destination_id" class="block">Destination</label>
                <select name="destination_id" id="destination_id" class="w-full p-2 border rounded" required>
    @foreach (auth()->user()->destinations as $destination)
        <option value="{{ $destination->id }}">{{ $destination->destination_name }}</option>
    @endforeach
</select>
            </div>

            <div class="mb-4">
                <label for="bus_id" class="block">Bus ID / Targa No</label>
<input type="text" name="bus_id" id="bus_id" class="w-full p-2 border rounded" required readonly>            </div>

            <div class="mb-4">
                <label for="departure_datetime" class="block">Departure Date and Time</label>
                <input 
                    type="datetime-local" 
                    name="departure_datetime" 
                    id="departure_datetime" 
                    class="w-full p-2 border rounded" 
                    value="{{ now()->format('Y-m-d\TH:i') }}" 
                    required
                >
            </div>
<div class="mb-4">
    <label for="cargo_uid" class="block">Scan/Enter Cargo Ticket (optional)</label>
    <input type="text" id="cargo_uid" class="w-full p-2 border rounded" placeholder="Scan or enter cargo ticket barcode">
    <input type="hidden" name="cargo_id" id="cargo_id">
    <div id="cargo-info" class="text-sm text-green-700 mt-2"></div>
</div>
            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Create Ticket</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function fetchFirstQueuedBus(destinationId) {
        if (!destinationId) {
            document.getElementById('bus_id').value = '';
            return;
        }
        fetch('/ticketer/first-queued-bus/' + destinationId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('bus_id').value = data.bus_id || '';
            });
    }

    const destinationSelect = document.getElementById('destination_id');
    destinationSelect.addEventListener('change', function() {
        fetchFirstQueuedBus(this.value);
    });

    // Fetch on page load for the default selected destination
    fetchFirstQueuedBus(destinationSelect.value);
});


document.getElementById('cargo_uid').addEventListener('change', function() {
    const uid = this.value.trim();
    const infoDiv = document.getElementById('cargo-info');
    const cargoIdInput = document.getElementById('cargo_id');
    if (!uid) {
        infoDiv.textContent = '';
        cargoIdInput.value = '';
        return;
    }
    fetch('/ticketer/cargo-info/' + uid)
        .then(response => response.json())
        .then(data => {
            if (data && data.id) {
                infoDiv.textContent = `Cargo found: ${data.cargo_uid}, Weight: ${data.weight} kg`;
                cargoIdInput.value = data.id;
            } else {
                infoDiv.textContent = 'Cargo not found!';
                cargoIdInput.value = '';
            }
        });
});
</script>
@endsection
