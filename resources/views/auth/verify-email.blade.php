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
</x-guest-layout>
