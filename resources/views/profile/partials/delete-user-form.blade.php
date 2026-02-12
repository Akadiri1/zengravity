<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-black text-red-500 uppercase tracking-tighter">
            Danger <span class="text-white">Zone</span>
        </h2>
        <p class="mt-2 text-sm font-medium text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="h-12 px-8 bg-red-500/10 hover:bg-red-500/20 text-red-500 border border-red-500/20 hover:border-red-500/50 font-bold text-sm uppercase tracking-wider rounded-2xl transition-all active:scale-95 flex items-center gap-2"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-[#0a0a0a] border border-white/10 rounded-3xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-white uppercase tracking-wider mb-2">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-sm text-gray-400 leading-relaxed mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-white/5 border-white/10 text-white focus:border-red-500 focus:ring-red-500 rounded-xl h-12"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-300 font-bold text-sm uppercase tracking-wider rounded-xl transition-all">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-bold text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-red-500/20 transition-all">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
