<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400 leading-relaxed">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Password') }}</label>
            <input id="password" class="w-full h-11 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" 
                   type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full h-11 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold text-sm tracking-wide shadow-lg shadow-blue-500/20 transition-all active:scale-[0.98]">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
