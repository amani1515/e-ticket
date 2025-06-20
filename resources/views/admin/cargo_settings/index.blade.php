@extends('admin.layout.app')
@section('content')
@if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-400">
        {{ session('success') }}
    </div>
@endif

 <a href="{{ route('admin.backup') }}"
   onclick="return confirm('Are you sure you want to download the full database backup?')"
   class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    <i class="fas fa-download mr-1"></i> Backup Database
</a>


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
<!-- filepath: d:\My comany\e-ticket\resources\views\admin\cargo_settings\index.blade.php -->
<!-- filepath: d:\My comany\e-ticket\resources\views\admin\cargo_settings\create-sms-template.blade.php -->
<div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10">
    <h2 class="text-xl font-bold mb-4">Create New SMS Template</h2>
    <form method="POST" action="{{ route('admin.sms-template.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm mb-1">Template Name</label>
            <input type="text" name="name" class="border rounded px-2 py-1 w-full text-gray-800" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm mb-1">Type</label>
            <input type="text" name="type" class="border rounded px-2 py-1 w-full text-gray-800" required placeholder="e.g. driver, user, mahberat">
        </div>
        <div class="mb-4">
            <label class="block text-sm mb-1">Message Content</label>
            <textarea name="content" class="border rounded px-2 py-1 w-full text-gray-800" rows="4" required></textarea>
        </div>
        <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>


@endsection
