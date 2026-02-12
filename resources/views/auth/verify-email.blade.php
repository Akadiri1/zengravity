<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400 leading-relaxed">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf

            <button type="submit" class="w-full h-11 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold text-sm tracking-wide shadow-lg shadow-blue-500/20 transition-all active:scale-[0.98]">
                {{ __('Resend Verification Email') }}
            </button>
        </form>
    </div>
    
    <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-gray-500 hover:text-white transition">
                    {{ __('Log Out') }}
                </button>
            </form>
    </div>

    <x-slot name="feature_showcase">
        <div class="max-w-md">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/10 border border-orange-500/20 mb-6 group">
                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                <span class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">Awaiting Validation</span>
            </div>
            
            <h2 class="text-4xl font-black text-white leading-tight mb-6">
                Light the <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-500 italic">Trusted Beacon</span>
            </h2>
            
            <p class="text-gray-400 text-lg mb-10 leading-relaxed">
                Verification ensures your connection to the ZenGravity network is legitimate and secure. One click and you're in.
            </p>

            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.03] border border-white/5">
                    <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center text-orange-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L22 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <div class="text-white font-bold text-sm">Waiting for signal...</div>
                        <div class="text-[10px] text-gray-500 uppercase font-black">Email Delivery Engine</div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-guest-layout>
