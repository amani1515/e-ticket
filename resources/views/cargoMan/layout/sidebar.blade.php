{{-- filepath: resources/views/cargoMan/layout/sidebar.blade.php --}}
<aside class="w-64 bg-blue-800 text-white min-h-screen p-6">
    <nav class="space-y-4">
        <a href="{{ route('cargoMan.home') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Dashboard</a>
        <a href="{{ route('cargoMan.cargo.create') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Measure Cargo</a>
        <a href="{{ route('cargoMan.cargo.index') }}" class="block py-2 px-4 rounded hover:bg-blue-700">All Cargos</a>
        {{-- Add more links as needed --}}
    </nav>
</aside>