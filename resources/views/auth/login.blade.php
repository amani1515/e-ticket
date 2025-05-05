<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('tik1.png') }}" alt="Logo" class="h-16 w-auto mx-auto">
            <h1 class="text-center text-xl font-bold text-purple-600 mt-4">LOGIN</h1>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-purple-600" />
                <x-input id="email"
                    class="block mt-1 w-full border-purple-600 focus:ring-gold-500 focus:border-gold-500" type="email"
                    name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="text-purple-600" />
                <x-input id="password"
                    class="block mt-1 w-full border-purple-600 focus:ring-gold-500 focus:border-gold-500"
                    type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember"
                        class="text-gold-500 border-purple-600 focus:ring-gold-500" />
                    <span class="ms-2 text-sm text-purple-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-purple-600 hover:text-gold-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4 bg-gold-500 hover:bg-gold-600 text-white">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
