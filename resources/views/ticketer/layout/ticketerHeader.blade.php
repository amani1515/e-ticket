<!-- resources/views/ticketer/layout/ticketerHeader.blade.php -->
<header class="bg-gray-800 text-white p-4 flex justify-between items-center">
    <div class="text-xl font-semibold">Ticketer Dashboard</div>
    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
        </form>
        </div>
</header>
