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
            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Email Address') }}</label>
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

    <x-slot name="feature_showcase">
        <div class="max-w-md">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 mb-6 group">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Hive Scout Active</span>
            </div>
            
            <h2 class="text-4xl font-black text-white leading-tight mb-6">
                Recovery with <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500 italic">Community Intel</span>
            </h2>
            
            <p class="text-gray-400 text-lg mb-10 leading-relaxed">
                Even if you lose access, the Hive Scout keeps your profile guarded through collaborative security protocols.
            </p>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5 hover:border-white/10 transition-colors">
                    <div class="text-blue-500 font-black text-2xl mb-1">24/7</div>
                    <div class="text-[10px] text-gray-500 uppercase font-black">Profile Guard</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5 hover:border-white/10 transition-colors">
                    <div class="text-indigo-500 font-black text-2xl mb-1">Encrypted</div>
                    <div class="text-[10px] text-gray-500 uppercase font-black">Session Log</div>
                </div>
            </div>
        </div>
    </x-slot>
</x-guest-layout>
