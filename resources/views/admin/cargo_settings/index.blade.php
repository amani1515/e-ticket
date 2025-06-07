@extends('admin.layout.app')
@section('content')
@if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-400">
        {{ session('success') }}
    </div>
@endif
<form method="GET" action="{{ route('admin.backup') }}">
    @csrf
    <button
        type="submit"
        onclick="return confirm('Are you sure you want to download a full backup?')"
        class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700"
    >
        Backup
    </button>
</form>


<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Cargo Settings</h2>
    <form method="POST" action="{{ route('admin.cargo-settings.update', $setting->id) }}">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm">Fee per KM</label>
            <input type="number" step="0.01" name="fee_per_km" value="{{ $setting->fee_per_km }}" class="border rounded px-2 py-1 w-full">
        </div>
        <div>
            <label class="block text-sm">Tax Percent</label>
            <input type="number" step="0.01" name="tax_percent" value="{{ $setting->tax_percent }}" class="border rounded px-2 py-1 w-full">
        </div>
        <div>
            <label class="block text-sm">Service Fee</label>
            <input type="number" step="0.01" name="service_fee" value="{{ $setting->service_fee }}" class="border rounded px-2 py-1 w-full">
        </div>
        <button type="submit" class="mt-4 bg-yellow-500 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>

<div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10">
    <h2 class="text-xl font-bold mb-4">Departure Fee Settings</h2>
    <form method="POST" action="{{ route('admin.cargo-settings.departure-fee') }}">
        @csrf
        <div>
            <label class="block text-sm">Level 1 Fee</label>
            <input type="number" step="0.01" name="level1" value="{{ $departureFees['level1'] ?? '' }}" class="border rounded px-2 py-1 w-full">
        </div>
        <div>
            <label class="block text-sm">Level 2 Fee</label>
            <input type="number" step="0.01" name="level2" value="{{ $departureFees['level2'] ?? '' }}" class="border rounded px-2 py-1 w-full">
        </div>
        <div>
            <label class="block text-sm">Level 3 Fee</label>
            <input type="number" step="0.01" name="level3" value="{{ $departureFees['level3'] ?? '' }}" class="border rounded px-2 py-1 w-full">
        </div>
        <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Save Departure Fees</button>
    </form>
</div>
<div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10">
    <h2 class="text-xl font-bold mb-4">Driver SMS Template</h2>
    <div>
        <label class="block text-sm">Message to Driver</label>
        <textarea readonly class="border rounded px-2 py-1 w-full bg-gray-100 text-gray-800" rows="4">
ሰላም [Driver Name], የርስዎ መርሀግብር ከ [Departure] ወደ  [Destination] መጫን ስለጀመረ እባክዎ አስፈላጊዉን ዝግጅት ያድርጉ። 
Sevastopol technologies plc.
        </textarea>
        <p class="text-sm text-gray-500 mt-2">This is a sample SMS that would be sent to the driver when bus status is on loadin.</p>
    </div>
            <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Save </button>

</div>


@endsection
