{{-- filepath: d:\project\e-ticket\resources\views\mahberat\schedule\create.blade.php --}}
@extends('mahberat.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 via-white to-gray-100 p-8">
    <!-- Page Heading -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">🚌 Schedule a New Bus</h2>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 p-4 mb-6 rounded shadow-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Animation -->
    @if(session('success'))
        <div id="success-animation" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-green-100 border border-green-400 text-green-800 px-8 py-6 rounded-xl shadow-2xl flex flex-col items-center animate-fade-in-up">
                <svg class="w-16 h-16 mb-4 text-green-500 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                </svg>
                <div class="text-2xl font-bold mb-2">Successfully Added!</div>
                <div class="text-lg">{{ session('success') }}</div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('success-animation').style.display = 'none';
            }, 2000);
        </script>
        <style>
            .animate-fade-in-up {
                animation: fadeInUp 0.5s, fadeOut 0.5s 1.5s forwards;
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(40px);}
                to { opacity: 1; transform: translateY(0);}
            }
            @keyframes fadeOut {
                to { opacity: 0; }
            }
        </style>
    @endif

    <!-- Schedule Form -->
    <form action="{{ route('mahberat.schedule.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf

        <!-- Select Bus -->
        <div>
            <label for="bus_id" class="block font-semibold text-gray-700 mb-1">Select Bus</label>
            <select name="bus_id" id="bus_id" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Choose Bus --</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}">{{ $bus->targa }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select Destination -->
        <div>
            <label for="destination_id" class="block font-semibold text-gray-700 mb-1">Select Destination</label>
            <select name="destination_id" id="destination_id" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <option value="">-- Select Destination --</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}">{{ $destination->destination_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition">
            ✅ Schedule Bus
        </button>
    </form>
</div>
@endsection
