<div class="min-h-screen bg-gray-800 text-white flex flex-col p-4 w-64">
    <div class="text-2xl font-bold mb-6">
        <a href="/balehabt/dashboard">Balehabt Dashboard</a>
    </div>

    <div x-data="{ openCars: false, openOwners: false }" class="space-y-2">
        <!-- Cars Menu -->
        <div>
            <button @click="openCars = !openCars"
                class="w-full text-left font-semibold flex justify-between items-center">
                Cars
                <svg :class="{ 'rotate-180': openCars }"
                    class="w-4 h-4 transform transition-transform" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openCars" x-cloak class="ml-4 mt-2 space-y-1">
                <a href="{{ route('balehabt.overallBusReport') }}" class="block hover:text-gray-300">OverallBusReport</a>
                <a href="/home" class="block hover:text-gray-300">Daily report</a>
            </div>
        </div>

        <!-- Owners Menu -->
        <div>
            <button @click="openOwners = !openOwners"
                class="w-full text-left font-semibold flex justify-between items-center">
                Owners
                <svg :class="{ 'rotate-180': openOwners }"
                    class="w-4 h-4 transform transition-transform" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openOwners" x-cloak class="ml-4 mt-2 space-y-1">
                <a href="#" class="block hover:text-gray-300">Owner List</a>
                <a href="#" class="block hover:text-gray-300">Register Owner</a>
            </div>
        </div>
    </div>
</div>
