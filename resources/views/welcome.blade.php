<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ኢ-ትኬት - የህዝብ ማመላለሻ አውቶብስ መቆጣጠሪያ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') {{-- Tailwind with Vite --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 text-gray-800">

    {{-- Navbar --}}
    <header class="bg-white shadow-lg sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-3xl font-extrabold text-yellow-600 tracking-tight">ኢ-ትኬት</h1>

            {{-- Hamburger Icon (Visible on Mobile) --}}
            <button @click="open = !open" class="md:hidden p-2 text-yellow-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Navigation Links (Hidden on Mobile) --}}
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="#home" class="hover:text-yellow-500 transition">ዋና ገጽ</a>
                <a href="/bus-display" class="hover:text-yellow-500 transition">ወረፋ ምልከታ</a>
                <a href="#features" class="hover:text-yellow-500 transition">ልዩ ልዩ</a>
                <a href="#contact" class="hover:text-yellow-500 transition">ግንኙነት </a>
                
                <a href="{{ route('login') }}"
                    class="bg-gradient-to-r from-yellow-600 to-yellow-500 text-white px-5 py-2 rounded-full shadow hover:scale-105 transition transform duration-300">ግባ</a>
            </nav>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-cloak class="md:hidden bg-white shadow-lg">
            <nav class="flex flex-col space-y-4 p-4 text-lg">
                <a href="#home" class="hover:text-yellow-500 transition">ዋና ገጽ</a>
                <a href="/bus-display" class="hover:text-yellow-500 transition">ወረፋ ምልከታ</a>
                <a href="/shop" class="hover:text-yellow-500 transition">ትኬት መቁረጫ</a>
                <a href="#contact" class="hover:text-yellow-500 transition">ግንኙነት</a>
                <a href="{{ route('login') }}"
                    class="bg-gradient-to-r from-yellow-600 to-yellow-500 text-white px-5 py-2 rounded-full shadow hover:scale-105 transition transform duration-300">ግባ</a>
            </nav>
        </div>
    </header>

    {{-- Hero Section --}}
    <section id="home" class="bg-gradient-to-r from-yellow-700 via-yellow-600 to-yellow-500 text-white py-24">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-5xl font-extrabold mb-4 leading-tight drop-shadow-md">ዘመናዊ የህዝብ አውቶብስ ትኬት አስተዳደር</h2>
            <p class="text-xl mb-8 opacity-90">የአውቶቡስ ትኬቶችን፣ ሾፌሮችን እና መርሃ ግብሮችን ለማስተዳደር ቀላል፣ ፈጣን እና የተደራጀ መድረክ - ለውስጣዊ
                ሰራተኞች አጠቃቀም የተሰራ system።</p>
                
{{-- <a href="{{ route('login') }}"
   class="bg-white text-yellow-700 font-bold px-8 py-3 rounded-full shadow-lg transition-all duration-300 ease-in-out transform hover:bg-gray-100 hover:scale-110 hover:shadow-xl active:scale-95 focus:outline-none focus:ring-4 focus:ring-yellow-300 animate-bounce">
   አሁን ጀምር
</a> --}}
<a href="{{ route('online-ticket.create') }}"
   class="inline-block bg-white text-yellow-700 px-8 py-3 rounded-lg text-lg font-semibold shadow hover:text-amber-500 transition animate-bounce">
   አሁን ጀምር
</a>
    
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h3 class="text-4xl font-bold text-yellow-700 mb-10">ግሩም ተግባራቶች</h3>
            <div class="grid md:grid-cols-3 gap-10">
                {{-- Feature Cards --}}
                <div
                    class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-yellow-400">
                    <div class="text-yellow-500 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M9 17v-6h13V7H9V5a3 3 0 00-3-3H4a1 1 0 000 2h2a1 1 0 011 1v16a1 1 0 102 0v-2h13v-4H9z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-2">ዘመናዊ ቲኬት አያያዝ</h4>
                    <p>ከሙሉ ክትትል እና የኦዲት መንገድ ጋር ትኬቶችን ያውጡ፣ ያረጋግጡ እና ይሰርዙ።</p>
                </div>
                <!-- Scheduling and Fare Collection of Mewucha Fee -->
<div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-green-400">
    <div class="text-green-500 mb-4">
        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 9c-3.866 0-7 3.134-7 7h14c0-3.866-3.134-7-7-7z" />
        </svg>
    </div>
    <h4 class="text-2xl font-semibold mb-2">መውጫ ክፍያ ዘመናዊ አስተዳደር </h4>
    <p>የመውጫ ክፍያን በቀላሉና በመረጡት የባንክ አማራጭ ይክፈሉ </p>
</div>

<!-- Bus Scheduling -->
<div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-blue-500">
    <div class="text-blue-500 mb-4">
        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M4 16v2a2 2 0 002 2h1a2 2 0 002-2v-2H4zm11 0v2a2 2 0 002 2h1a2 2 0 002-2v-2h-5zM4 6v7h16V6a2 2 0 00-2-2H6a2 2 0 00-2 2z" />
        </svg>
    </div>
    <h4 class="text-2xl font-semibold mb-2">የየተሽከርካሪ መርሃ ግብር</h4>
    <p> ዘመናዊና ግልጽ የተሽከርካሪ ወረፋ አያያዝ </p>
</div>

<!-- Monitoring Work Environment of Menaharia -->
<div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-purple-500">
    <div class="text-purple-500 mb-4">
        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v4H3V4zm0 6h18v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z" />
        </svg>
    </div>
    <h4 class="text-2xl font-semibold mb-2">ዘመናዊ የመረጃ አያያዝ </h4>
    <p>ዘመናዊ የመረጃ አያያዝ ሲስተም </p>
</div>

            </div>
        </div>
    </section>

    {{-- Contact / Footer --}}
    <footer id="contact" class="bg-white py-10 mt-20 border-t">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h5 class="text-2xl font-semibold text-yellow-600 mb-2">እርዳታ ይፈልጋሉ ወይም የበለጠ ለማወቅ ይፈልጋሉ?</h5>
            <p class="text-gray-600 mb-4">ቡድናችንን በ0930608000 ያግኙ </p>
            <p class="text-sm text-gray-400">© {{ date('Y') }} Sevastopol Technology. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
