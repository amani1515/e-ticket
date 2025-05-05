<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-BusTicketPro - Public Bus Ticket System</title>
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
            <h1 class="text-3xl font-extrabold text-purple-600 tracking-tight">BusTicketPro</h1>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="#home" class="hover:text-purple-500 transition">Home</a>
                <a href="#features" class="hover:text-purple-500 transition">Features</a>
                <a href="#contact" class="hover:text-purple-500 transition">Contact</a>
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2 rounded-full shadow hover:scale-105 transition transform duration-300">Login</a>
            </nav>
        </div>
    </header>

    {{-- Hero Section --}}
    <section id="home" class="bg-gradient-to-r from-purple-700 via-pink-600 to-red-500 text-white py-24">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-5xl font-extrabold mb-4 leading-tight drop-shadow-md">Modern Public Bus Ticket Management</h2>
            <p class="text-xl mb-8 opacity-90">Simple, fast, and organized platform for managing bus tickets, drivers, and schedules — built for internal staff use.</p>
            <a href="{{ route('login') }}" class="bg-white text-purple-700 font-bold px-8 py-3 rounded-full hover:bg-gray-100 shadow-lg transition transform hover:scale-105">Get Started Now</a>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h3 class="text-4xl font-bold text-purple-700 mb-10">Awesome Features</h3>
            <div class="grid md:grid-cols-3 gap-10">

                {{-- Feature Card 1 --}}
                <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-purple-400">
                    <div class="text-purple-500 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M9 17v-6h13V7H9V5a3 3 0 00-3-3H4a1 1 0 000 2h2a1 1 0 011 1v16a1 1 0 102 0v-2h13v-4H9z"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-2">Smart Ticket Handling</h4>
                    <p>Issue, validate, and cancel tickets in real-time with full traceability and audit trail.</p>
                </div>

                {{-- Feature Card 2 --}}
                <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-pink-400">
                    <div class="text-pink-500 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M8 16l4-4-4-4m8 8l-4-4 4-4"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-2">Driver & Route Assignment</h4>
                    <p>Easily manage driver shifts and assign them to specific routes and bus numbers.</p>
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
                    <h4 class="text-2xl font-semibold mb-2">Role-based Access</h4>
                    <p>Admins, ticket men, and drivers each get their own dashboard and access level.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- Contact / Footer --}}
    <footer id="contact" class="bg-white py-10 mt-20 border-t">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h5 class="text-2xl font-semibold text-purple-600 mb-2">Need help or want to learn more?</h5>
            <p class="text-gray-600 mb-4">Contact our team at <a href="mailto:support@busticketpro.com" class="text-purple-500 hover:underline">support@busticketpro.com</a></p>
            <p class="text-sm text-gray-400">© {{ date('Y') }} BusTicketPro. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
