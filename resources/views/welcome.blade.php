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
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue via-pink to-purple-100 text-gray-800">

    {{-- Navbar --}}
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-3xl font-extrabold text-purple-600 tracking-tight">ኢ-ትኬት</h1>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="#home" class="hover:text-purple-500 transition">ዋና ገጽ</a>
                <a href="#features" class="hover:text-purple-500 transition">ልዩ ልዩ</a>
                <a href="#contact" class="hover:text-purple-500 transition">ግንኙነት</a>
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2 rounded-full shadow hover:scale-105 transition transform duration-300">ግባ</a>
            </nav>
        </div>
    </header>

    {{-- Hero Section --}}
    <section id="home" class="bg-gradient-to-r from-purple-700 via-pink-600 to-red-500 text-white py-24">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-5xl font-extrabold mb-4 leading-tight drop-shadow-md">ዘመናዊ የህዝብ አውቶብስ ትኬት አስተዳደር</h2>
            <p class="text-xl mb-8 opacity-90">የአውቶቡስ ትኬቶችን፣ ሾፌሮችን እና መርሃ ግብሮችን ለማስተዳደር ቀላል፣ ፈጣን እና የተደራጀ መድረክ - ለውስጣዊ ሰራተኞች አጠቃቀም የተሰራ።</p>
            <a href="{{ route('login') }}" class="bg-white text-purple-700 font-bold px-8 py-3 rounded-full hover:bg-gray-100 shadow-lg transition transform hover:scale-105">አሁን ጀምር</a>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h3 class="text-4xl font-bold text-purple-700 mb-10">ግሩም ተግባራቶች</h3>
            <div class="grid md:grid-cols-3 gap-10">

                {{-- Feature Card 1 --}}
                <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-purple-400">
                    <div class="text-purple-500 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M9 17v-6h13V7H9V5a3 3 0 00-3-3H4a1 1 0 000 2h2a1 1 0 011 1v16a1 1 0 102 0v-2h13v-4H9z"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-2">ዘመናዊ ቲኬት አያያዝ</h4>
                    <p>ከሙሉ ክትትል እና የኦዲት መንገድ ጋር ትኬቶችን ያውጡ፣ ያረጋግጡ እና ይሰርዙ።</p>
                </div>

                {{-- Feature Card 2 --}}
                <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-pink-400">
                    <div class="text-pink-500 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M8 16l4-4-4-4m8 8l-4-4 4-4"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-2">የአሽከርካሪ እና መስመር ምደባ</h4>
                    <p>የአሽከርካሪ ፈረቃዎችን በቀላሉ ያስተዳድሩ እና ለተወሰኑ መስመሮች እና የአውቶቡስ ቁጥሮች ይመድቧቸው።</p>
                </div>

                {{-- Feature Card 3 --}}
                <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-blue-400">
                    <div class="text-blue-500 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M12 8c-1.1 0-2 .9-2 2v2h4v-2c0-1.1-.9-2-2-2z"/>
                            <path d="M6 12h12M4 4h16v16H4z"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-2">ሚና ላይ የተመሰረተ መዳረሻ
                        </h4>
                    <p>አስተዳዳሪዎች፣ የቲኬት ወንዶች እና አሽከርካሪዎች እያንዳንዳቸው የራሳቸው ዳሽቦርድ እና የመዳረሻ ደረጃ ያገኛሉ።</p>
                </div>

            </div>
        </div>
    </section>

    {{-- Contact / Footer --}}
    <footer id="contact" class="bg-white py-10 mt-20 border-t">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h5 class="text-2xl font-semibold text-purple-600 mb-2">እርዳታ ይፈልጋሉ ወይም የበለጠ ለማወቅ ይፈልጋሉ?
                </h5>
            <p class="text-gray-600 mb-4">ቡድናችንን በ0930608000 ያግኙ</a></p>
            <p class="text-sm text-gray-400">© {{ date('Y') }} Sevastopol Technology. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
