<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400 leading-relaxed">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Security Code') }}</label>
            <input id="password" class="w-full h-11 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" 
                   type="password" name="password" required autocomplete="current-password" placeholder="Confirm session credentials" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full h-11 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold text-sm tracking-wide shadow-lg shadow-blue-500/20 transition-all active:scale-[0.98]">
                {{ __('Confirm Access') }}
            </button>
        </div>
    </form>

    <x-slot name="feature_showcase">
        <div class="max-w-md">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/20 mb-6 group">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Restricted Area</span>
            </div>
            
            <h2 class="text-4xl font-black text-white leading-tight mb-6">
                Identity <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-pink-500 italic">Re-Authorization</span>
            </h2>
            
            <p class="text-gray-400 text-lg mb-10 leading-relaxed">
                You are entering a high-clearance zone. Double-check your bio-signature before proceeding to critical system settings.
            </p>

            <div class="p-4 rounded-2xl bg-white/[0.03] border border-red-500/20">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] text-gray-500 uppercase font-black">Firewall Status</span>
                    <span class="text-[10px] text-red-500 uppercase font-black tracking-tighter animate-pulse">Maximum Depth</span>
                </div>
                <div class="flex gap-1">
                    @for($i = 0; $i < 12; $i++)
                        <div class="h-8 flex-1 bg-red-500/10 rounded-sm"></div>
                    @endfor
                </div>
            </div>
        </div>
    </x-slot>
</x-guest-layout>
