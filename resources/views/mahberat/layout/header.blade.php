<!-- filepath: d:\My comany\e-ticket\resources\views\mahberat\layout\header.blade.php -->
<header class="bg-yellow-500 text-gray-900 shadow p-4 flex justify-between items-center z-30 pl-16 md:pl-4 fixed top-0 left-0 right-0 w-full transition-all duration-200">
    <div class="flex items-center gap-3 text-lg font-semibold">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-auto" />
        Mahberat Dashboard
    </div>
    <div class="flex items-center gap-4">
        <!-- User Dropdown -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center text-sm font-medium focus:outline-none">
                    <span class="mr-2">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route('profile.show') }}">
                    Change Password / Profile
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>