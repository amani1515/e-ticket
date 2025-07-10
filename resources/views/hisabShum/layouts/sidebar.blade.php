<!-- filepath: resources/views/hisabShum/layouts/sidebar.blade.php -->
<aside class="w-64 bg-blue-900 text-white min-h-screen p-6">
    <nav class="space-y-4">
        <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Dashboard</a>
        
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full text-left py-2 px-4 rounded hover:bg-blue-700 flex justify-between items-center">
                Reports
                <svg :class="{'rotate-180': open}" class="w-4 h-4 ml-2 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-cloak class="ml-4 mt-1 space-y-1">
                <a href="{{ route('hisabshum.allReports') }}" class="block py-2 px-4 rounded hover:bg-blue-600">All Reports</a>
                <a href="{{ route('hisabshum.paidReports') }}" class="block py-2 px-4 rounded hover:bg-blue-600">Paid Reports</a>
            </div>
        </div>

        <!-- Add more sidebar links here -->
    </nav>
</aside>

<!-- Make sure Alpine.js is loaded in your main layout for the dropdown to work -->