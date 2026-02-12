<section>
    <header class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-9 h-9 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h2 class="text-lg font-black text-white uppercase tracking-tight">
                {{ __('Profile Information') }}
            </h2>
        </div>
        <p class="text-sm text-gray-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Name') }}</label>
            <input id="name" name="name" type="text"
                   class="w-full h-12 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('Email') }}</label>
            <input id="email" name="email" type="email"
                   class="w-full h-12 px-4 rounded-xl bg-white/[0.03] border border-white/10 text-white placeholder-gray-600 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                   value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-amber-500/5 border border-amber-500/10 rounded-xl">
                    <p class="text-sm text-amber-400">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-amber-300 hover:text-white font-semibold transition">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-emerald-400 font-semibold">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="h-11 px-6 rounded-xl bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-400 hover:to-purple-400 text-sm font-bold text-white transition-all duration-300 shadow-lg shadow-blue-500/20 active:scale-95">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-400 font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
