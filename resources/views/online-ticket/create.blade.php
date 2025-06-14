<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>መቀመጫ ቲኬት መግዣ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-100 min-h-screen py-10 px-4 sm:px-6 lg:px-8">

    <h2 class="text-3xl font-bold text-center text-yellow-800 mb-8">መቀመጫ ቲኬት መግዣ</h2>

    {{-- Search Bar --}}
    <form action="{{ route('online-ticket.search') }}" method="GET" class="max-w-2xl mx-auto mb-10">
        <div class="flex items-center space-x-4">
            <input type="text" name="search" placeholder="መድረሻን ያስገቡ..." class="w-full px-4 py-2 rounded-lg border border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition">ፈልግ</button>
        </div>
    </form>

    {{-- Schedule Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse ($schedules as $schedule)
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border-2 border-yellow-300 hover:shadow-yellow-400 transition">
            <div class="p-6">
                <h3 class="text-xl font-bold text-yellow-700 mb-2">መኪና ታርጋ: {{ $schedule->bus->targa }}</h3>
                <p><span class="font-semibold">መነሻ:</span> {{ $schedule->destination->start_from }}</p>
                <p><span class="font-semibold">መድረሻ:</span> {{ $schedule->destination->destination_name }}</p>
                <p><span class="font-semibold">የመነሻ ሰዓት:</span> {{ \Carbon\Carbon::parse($schedule->departure_time)->format('g:i A') }}</p>
                <p><span class="font-semibold">ታሪፍ:</span> {{ number_format($schedule->destination->tariff, 2) }} ብር</p>
                <p><span class="font-semibold">ቀሪ ቲኬቶች:</span> {{ $schedule->bus->capacity - $schedule->boarding }}</p>

                <a href="#"
                   class="block mt-4 text-center bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">
                    ቲኬት ይቁረጡ
                </a>
            </div>
        </div>
    @empty
        <p class="col-span-full text-center text-gray-600 text-lg">የተመዘገቡ መንገዶች አልተገኙም።</p>
    @endforelse
</div>


</body>
</html>
