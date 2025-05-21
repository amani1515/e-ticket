<div class="min-h-screen bg-gray-800 text-white flex flex-col p-4 w-64">
    <div class="text-2xl font-bold mb-6">
        <a href="/home">Traffic Dashboard</a>
    </div>

    <div x-data="{ openViolations: false, openDrivers: false }" class="space-y-2">
        <!-- Violations Menu -->
        <div>
            <button @click="openViolations = !openViolations"
                class="w-full text-left font-semibold flex justify-between items-center">
                Violations
                <svg :class="{ 'rotate-180': openViolations }"
                    class="w-4 h-4 transform transition-transform" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openViolations" x-cloak class="ml-4 mt-2 space-y-1">
                <a href="#" class="block hover:text-gray-300">View Violations</a>
                <a href="#" class="block hover:text-gray-300">Report Violation</a>
            </div>
        </div>

        <!-- Drivers Menu -->
        <div>
            <button @click="openDrivers = !openDrivers"
                class="w-full text-left font-semibold flex justify-between items-center">
                Drivers
                <svg :class="{ 'rotate-180': openDrivers }"
                    class="w-4 h-4 transform transition-transform" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openDrivers" x-cloak class="ml-4 mt-2 space-y-1">
                <a href="#" class="block hover:text-gray-300">Driver List</a>
                <a href="#" class="block hover:text-gray-300">Register Driver</a>
            </div>
        </div>
    </div>
</div>
