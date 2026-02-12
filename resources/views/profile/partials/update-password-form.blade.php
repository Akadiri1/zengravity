<section>
    <header class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h2 class="text-lg font-black text-white uppercase tracking-tight">
                {{ __('Update Password') }}
            </h2>
        </div>
        <p class="text-sm text-gray-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                   class="w-full h-12 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition"
                   autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password"
                   class="w-full h-12 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition"
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                   class="w-full h-12 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition"
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Save -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="h-11 px-6 rounded-xl bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 hover:border-amber-500 text-sm font-bold transition-all duration-300 active:scale-95">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-400 font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
