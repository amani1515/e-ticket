<div class="min-h-screen bg-gray-800 text-white flex flex-col p-4 w-64">
    <div class="text-2xl font-bold mb-6">
        <a href="/balehabt/dashboard">Balehabt Dashboard</a>
    </div>

    <div x-data="{ openAppointments: false, openPatients: false }" class="space-y-2">
        <!-- Appointments Menu -->
        <div>
            <button @click="openAppointments = !openAppointments"
                class="w-full text-left font-semibold flex justify-between items-center">
                Appointments
                <svg :class="{ 'rotate-180': openAppointments }"
                    class="w-4 h-4 transform transition-transform" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openAppointments" x-cloak class="ml-4 mt-2 space-y-1">
                <a href="#" class="block hover:text-gray-300">View Appointments</a>
                <a href="#" class="block hover:text-gray-300">Schedule Appointment</a>
            </div>
        </div>

        <!-- Patients Menu -->
        <div>
            <button @click="openPatients = !openPatients"
                class="w-full text-left font-semibold flex justify-between items-center">
                Patients
                <svg :class="{ 'rotate-180': openPatients }"
                    class="w-4 h-4 transform transition-transform" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="openPatients" x-cloak class="ml-4 mt-2 space-y-1">
                <a href="#" class="block hover:text-gray-300">Patient List</a>
                <a href="#" class="block hover:text-gray-300">Register Patient</a>
            </div>
        </div>
    </div>
</div>
