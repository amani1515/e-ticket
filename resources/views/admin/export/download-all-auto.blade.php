@extends('admin.layout.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg p-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Downloading All CSV Files...</h1>
        <p class="text-gray-600 mb-4">Your downloads will start automatically.</p>
        <a href="{{ route('admin.export.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Export</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const downloads = [
        '{{ route("admin.export.destinations.csv") }}',
        '{{ route("admin.export.buses.csv") }}',
        '{{ route("admin.export.schedules.csv") }}',
        '{{ route("admin.export.tickets.csv") }}'
    ];
    
    downloads.forEach((url, index) => {
        setTimeout(() => {
            const link = document.createElement('a');
            link.href = url;
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }, index * 1000);
    });
});
</script>
@endsection