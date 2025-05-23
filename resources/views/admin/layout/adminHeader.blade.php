<header class="bg-yellow-500 text-gray-900 shadow p-4 flex justify-between items-center z-30 pl-16 md:pl-4">
    <h1 class="text-lg font-semibold"><a href="{{ route('admin.index') }}">Admin Dashboard</a></h1>
    <div class="flex items-center gap-4">
        <span class="hidden md:block">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-700 hover:underline">Logout</button>
        </form>
    </div>
</header>
