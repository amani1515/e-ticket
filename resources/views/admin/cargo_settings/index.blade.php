@extends('admin.layout.app')
@section('content')
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
@endsection