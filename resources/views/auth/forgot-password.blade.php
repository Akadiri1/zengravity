<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400 leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Email') }}</label>
            <input id="email" class="w-full h-11 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" 
                   type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full h-11 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold text-sm tracking-wide shadow-lg shadow-blue-500/20 transition-all active:scale-[0.98]">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
        
        <div class="flex items-center justify-center mt-4">
             <a class="text-xs text-gray-500 hover:text-white transition" href="{{ route('login') }}">
                {{ __('Back to login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
