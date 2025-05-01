<header class="bg-yellow-500 text-gray-900 shadow p-4 flex justify-between items-center">
    <h1 class="text-lg font-semibold"><a href="{{ route('admin.index') }}">Admin Dashboard</a> </h1>
    <div class="flex items-center gap-4">
        <span>{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-700 hover:underline">Logout</button>
        </form>
    </div>
</header>
