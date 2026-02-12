<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Email') }}</label>
            <input id="email" class="w-full h-11 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" 
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Password') }}</label>
            <input id="password" class="w-full h-11 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" 
                   type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-white/5 border-white/10 text-blue-500 shadow-sm focus:ring-blue-500 focus:ring-offset-gray-900 transition" name="remember">
                <span class="ms-2 text-sm text-gray-400 group-hover:text-gray-300 transition">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full h-11 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold text-sm tracking-wide shadow-lg shadow-blue-500/20 transition-all active:scale-[0.98]">
                {{ __('Log in') }}
            </button>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="text-xs text-gray-500 hover:text-gray-300 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
             <a class="text-xs text-gray-500 hover:text-white transition" href="{{ route('register') }}">
                {{ __('Create an account') }}
            </a>
        </div>
        
        <!-- Divider -->
        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/10"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-[#0a0a0a] px-2 text-gray-500 font-bold tracking-wider">Or continue with</span>
            </div>
        </div>

        <!-- Google Login -->
        <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 w-full h-11 rounded-xl bg-white text-gray-900 hover:bg-gray-100 font-bold text-sm transition-all active:scale-[0.98]">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Google
        </a>
    </form>
</x-guest-layout>
