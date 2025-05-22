{{-- filepath: d:\project\e-ticket\resources\views\mahberat\layout\header.blade.php --}}
<header class="bg-white shadow p-4 flex justify-between items-center z-0 pl-16 md:pl-4 fixed top-0 left-0 right-0 w-full transition-all duration-200">
    <h1 class="text-xl font-semibold">Mahberat Dashboard</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
    </form>
</header>
{{-- <header class="bg-white text-gray-900 shadow p-4 flex justify-between items-center z-30 pl-16 md:pl-4">
    <h1 class="text-lg font-semibold"><a href="/home">Mahberat Dashboard</a></h1>
    <div class="flex items-center gap-4">
        <span class="hidden md:block">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-700 hover:underline">Logout</button>
        </form>
    </div>
</header> --}}