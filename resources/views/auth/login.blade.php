<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex flex-col items-center">
                <img src="{{ asset('tik1.png') }}" alt="Logo"
                    class="h-20 w-auto mx-auto drop-shadow-lg animate-bounce" />
                <h1 class="text-center text-2xl font-extrabold text-yellow-500 mt-4 tracking-widest drop-shadow">LOGIN
                </h1>
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 animate-pulse">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-yellow-700 font-semibold" />
                <x-input id="email"
                    class="block mt-1 w-full border-yellow-500 focus:ring-yellow-400 focus:border-yellow-600 bg-yellow-50/50 placeholder-yellow-400"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="Enter your email" />
            </div>

            <div>
                <x-label for="password" value="{{ __('Password') }}" class="text-yellow-700 font-semibold" />
                <x-input id="password"
                    class="block mt-1 w-full border-yellow-500 focus:ring-yellow-400 focus:border-yellow-600 bg-yellow-50/50 placeholder-yellow-400"
                    type="password" name="password" required autocomplete="current-password"
                    placeholder="Enter your password" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember"
                        class="text-yellow-600 border-yellow-500 focus:ring-yellow-400" />
                    <span class="ms-2 text-sm text-yellow-700">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-yellow-700 hover:text-yellow-500 transition"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div>
                <x-button
                    class="w-full bg-gradient-to-r from-yellow-500 to-yellow-400 hover:from-yellow-600 hover:to-yellow-500 text-white font-bold py-2 rounded-full shadow-lg transition transform hover:scale-105 duration-200">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
