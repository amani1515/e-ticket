{{-- filepath: resources/views/cargoMan/layout/header.blade.php --}}
<header class="bg-blue-900 text-white p-4 flex justify-between items-center shadow">
    <div class="text-lg font-bold">Cargo Management</div>
    <div>
        {{-- You can add user info or logout here --}}
        <span>{{ Auth::user()->name ?? 'Cargo Man' }}</span>
    </div>
</header>