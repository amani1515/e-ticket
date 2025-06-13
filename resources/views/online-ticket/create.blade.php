<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Long Distance Buses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-50 text-gray-800 font-sans min-h-screen py-10 px-6">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-yellow-700 text-center mb-10">🔍 የባስ ታቦሎችን ፈልግ</h1>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('online-ticket.search') }}" class="mb-10">
            <div class="flex items-center gap-2">
                <input
                    type="text"
                    name="query"
                    placeholder="ቦታ ፈልግ... (e.g. Addis Ababa)"
                    class="w-full px-4 py-3 rounded-lg border border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                />
                <button
                    type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold shadow">
                    Search
                </button>
            </div>
        </form>

        <!-- Results / Bus Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            @foreach ($buses as $bus)
                <div class="bg-white p-6 rounded-lg shadow border border-yellow-200">
                    <h2 class="text-xl font-bold text-yellow-700 mb-2">{{ $bus->travel_name }}</h2>
                    <p class="text-sm text-gray-600">Departure: <span class="font-medium">{{ $bus->departure_time }}</span></p>
                    <p class="text-sm text-gray-600">From: <span class="font-medium">{{ $bus->departure }}</span> → To: <span class="font-medium">{{ $bus->destination }}</span></p>
                    <p class="text-sm text-gray-600">Tariff: <span class="font-medium">{{ $bus->tariff }} Birr</span></p>
                    <p class="text-sm text-gray-600">Tickets Left: <span class="font-medium">{{ $bus->available_seats }}</span></p>

                    <div class="mt-4">
                        <a href="{{ route('online-ticket.book', $bus->id) }}"
                           class="block bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 rounded-md font-semibold">
                            Book Now
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

        @if ($buses->isEmpty())
            <p class="text-center text-gray-500 mt-12 text-lg">🚫 No buses found for your search.</p>
        @endif

    </div>

</body>
</html>
