<div class="w-full h-16 px-4 bg-white flex flex-col sm:flex-row items-center justify-between shadow">
    <!-- Left Side: Logo or Title -->
    <div class="text-lg font-semibold text-gray-800 mb-2 sm:mb-0">
        Traffic System
    </div>

    <!-- Right Side: User Info and Logout -->
    <div class="flex items-center space-x-4">
        <!-- User Info -->
        <div class="text-sm text-gray-700">
            {{ Auth::user()->name ?? 'Guest' }}
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                Logout
            </button>
        </form>
    </div>
</div>
