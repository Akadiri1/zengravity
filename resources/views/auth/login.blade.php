<x-guest-layout>
    @section('feature_showcase')
        <div class="space-y-8 animate-in fade-in slide-in-from-right-10 duration-1000">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold uppercase tracking-widest">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Featured Module
            </div>
            
            <div class="space-y-4">
                <h2 class="text-5xl font-black text-white tracking-tighter leading-none">
                    GHOST <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">SCANNER</span>
                </h2>
                <p class="text-xl text-gray-400 font-medium leading-relaxed max-w-lg">
                    Uncover the hidden architecture of your digital assets. Our AI-driven integrity engine ensures every masterpiece is built on a foundation of perfection.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-4">
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="text-blue-400 font-bold mb-1">99.9%</div>
                    <div class="text-xs text-gray-500 uppercase font-black">Detection Accuracy</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="text-purple-400 font-bold mb-1">< 2s</div>
                    <div class="text-xs text-gray-500 uppercase font-black">Scan Latency</div>
                </div>
            </div>

            <!-- Decorative Visual -->
            <div class="relative aspect-video rounded-3xl overflow-hidden border border-white/10 group shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-purple-600/20 group-hover:opacity-30 transition-opacity"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-32 h-32 text-blue-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <!-- Shimmer -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full animate-shimmer"></div>
            </div>
        </div>
    @endsection

    <div class="space-y-8 animate-in fade-in slide-in-from-left-6 duration-700">
        <div class="space-y-2">
            <h1 class="text-4xl font-black text-white tracking-tighter">WELCOME BACK</h1>
            <p class="text-gray-500 font-medium">Log in to your command center.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">{{ __('Email Address') }}</label>
                <div class="relative group">
                    <input id="email" class="w-full h-12 px-5 rounded-2xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 outline-none" 
                           type="email" name="email" :value="old('email')" required autofocus placeholder="name@domain.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex justify-between items-center ml-1">
                    <label for="password" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a class="text-[10px] font-black text-blue-500 hover:text-blue-400 uppercase tracking-wider transition" href="{{ route('password.request') }}">
                            {{ __('Forgot?') }}
                        </a>
                    @endif
                </div>
                <input id="password" class="w-full h-12 px-5 rounded-2xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 outline-none" 
                       type="password" name="password" required placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 rounded bg-white/5 border-white/10 text-blue-500 focus:ring-blue-500/20 focus:ring-offset-0 transition-all cursor-pointer" name="remember">
                    <span class="ms-2 text-xs font-bold text-gray-500 group-hover:text-gray-300 transition uppercase tracking-wider">{{ __('Stay Logged In') }}</span>
                </label>
            </div>

            <button type="submit" class="w-full h-14 rounded-2xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-black text-sm uppercase tracking-[0.15em] shadow-xl shadow-blue-500/20 transition-all active:scale-[0.98] group flex items-center justify-center gap-2">
                {{ __('Initiate Login') }}
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
            
            <div class="relative py-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
                <div class="relative flex justify-center text-[10px] uppercase font-black tracking-widest text-gray-600"><span class="bg-[#070707] px-4">Social Access</span></div>
            </div>

            <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 w-full h-14 rounded-2xl bg-white text-gray-900 hover:bg-gray-100 font-black text-sm uppercase tracking-wider transition-all active:scale-[0.98]">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Google Identity
            </a>

            <div class="text-center">
                <a class="text-[11px] font-black text-gray-500 hover:text-white uppercase tracking-widest transition" href="{{ route('register') }}">
                    {{ __('New here? Create Operator Key') }}
                </a>
            </div>
        </form>
    </div>

    <style>
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
    </style>
</x-guest-layout>
