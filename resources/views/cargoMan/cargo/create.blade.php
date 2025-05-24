{{-- filepath: resources/views/cargoMan/cargo/create.blade.php --}}
@extends('cargoMan.layout.app')

@section('title', 'Measure Cargo')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Measure Cargo</h1>

    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('cargoMan.cargo.store') }}" class="space-y-5 max-w-lg">
        @csrf

        <!-- Destination -->
        <div>
            <label class="block text-sm font-medium mb-1">Destination</label>
            <select name="destination_id" id="destination_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Select Destination</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}">{{ $destination->destination_name }}</option>
                @endforeach
            </select>
            @error('destination_id') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <!-- Schedule (auto-filled, hidden) -->
        <input type="hidden" name="schedule_id" id="schedule_id">
        <div>
            <label class="block text-sm font-medium mb-1">Schedule</label>
            <input type="text" id="schedule_info" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
        </div>

        <!-- Bus (auto-filled, hidden) -->
        <input type="hidden" name="bus_id" id="bus_id">
        <div>
            <label class="block text-sm font-medium mb-1">Bus</label>
            <input type="text" id="bus_targa" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
        </div>

        <!-- Distance (auto-filled) -->
        <div>
            <label class="block text-sm font-medium mb-1">Distance (km)</label>
            <input type="number" step="0.01" name="distance" id="distance" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
        </div>

        <!-- Weight -->
        <div>
            <label class="block text-sm font-medium mb-1">Cargo Weight (kg)</label>
            <input type="number" step="0.01" name="weight" id="weight" class="w-full border rounded px-3 py-2" required>
            @error('weight') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <!-- Service Fee, Tax, Fee per KM (auto-filled, readonly) -->
        <div class="grid grid-cols-3 gap-2">
            <div>
                <label class="block text-xs mb-1">Fee per KM</label>
                <input type="number" step="0.01" name="fee_per_km" id="fee_per_km" class="w-full border rounded px-2 py-1 bg-gray-100" readonly value="{{ $cargoSettings->fee_per_km }}">
            </div>
            <div>
                <label class="block text-xs mb-1">Tax (%)</label>
                <input type="number" step="0.01" name="tax_percent" id="tax_percent" class="w-full border rounded px-2 py-1 bg-gray-100" readonly value="{{ $cargoSettings->tax_percent }}">
            </div>
            <div>
                <label class="block text-xs mb-1">Service Fee</label>
                <input type="number" step="0.01" name="service_fee" id="service_fee" class="w-full border rounded px-2 py-1 bg-gray-100" readonly value="{{ $cargoSettings->service_fee }}">
            </div>
        </div>

        <!-- Total Amount (auto-calculated) -->
        <div>
            <label class="block text-sm font-medium mb-1">Total Amount</label>
            <input type="number" step="0.01" name="total_amount" id="total_amount" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
        </div>

<button type="submit"
    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow transition duration-150 ease-in-out">
    Save & Print Receipt
</button>    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const destinationSelect = document.getElementById('destination_id');
        const scheduleIdInput = document.getElementById('schedule_id');
        const scheduleInfoInput = document.getElementById('schedule_info');
        const busIdInput = document.getElementById('bus_id');
        const busTargaInput = document.getElementById('bus_targa');
        const distanceInput = document.getElementById('distance');
        const weightInput = document.getElementById('weight');
        const feePerKm = parseFloat(document.getElementById('fee_per_km').value) || 0;
        const taxPercent = parseFloat(document.getElementById('tax_percent').value) || 0;
        const serviceFee = parseFloat(document.getElementById('service_fee').value) || 0;
        const totalAmountInput = document.getElementById('total_amount');

        function fetchFirstQueuedSchedule(destinationId) {
            if (!destinationId) {
                scheduleIdInput.value = '';
                scheduleInfoInput.value = '';
                busIdInput.value = '';
                busTargaInput.value = '';
                distanceInput.value = '';
                return;
            }
            fetch('/cargoman/first-queued-schedule/' + destinationId)
                .then(response => response.json())
                .then(data => {
                    scheduleIdInput.value = data.schedule_id || '';
                    scheduleInfoInput.value = data.schedule_uid ? (data.schedule_uid + ' (' + (data.bus_targa || '') + ', ' + (data.destination_name || '') + ')') : '';
                    busIdInput.value = data.bus_id || '';
                    busTargaInput.value = data.bus_targa || '';
                    distanceInput.value = data.distance || '';
                    updateTotal();
                });
        }

     function updateTotal() {
    const weight = parseFloat(weightInput.value) || 0;
    const feePerKg = feePerKm; // feePerKm is actually fee per kg
    const tax = taxPercent;    // tax is a fixed amount, not a percent
    const service = serviceFee; // service fee is a fixed amount

    let subtotal = (weight * feePerKg) + tax + service;
    totalAmountInput.value = subtotal.toFixed(2);
}
        destinationSelect.addEventListener('change', function() {
            fetchFirstQueuedSchedule(this.value);
        });
        weightInput.addEventListener('input', updateTotal);

        // Fetch on page load for the default selected destination
        fetchFirstQueuedSchedule(destinationSelect.value);
    });
    </script>
@endsection