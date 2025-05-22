<!-- filepath: resources/views/hisabShum/layouts/header.blade.php -->
<header class="bg-blue-800 text-white p-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Hisab Shum</h1>
    <div>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                Logout
            </button>
        </form>
    </div>
</header>