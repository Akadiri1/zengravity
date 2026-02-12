<x-app-layout>
    <div class="min-h-full py-6 md:py-12 px-4 sm:px-6 lg:px-8 bg-black">
        <div class="max-w-2xl mx-auto space-y-8">

            <!-- Header -->
            <div class="space-y-3">
                <a href="{{ route('app') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-white text-xs font-bold uppercase tracking-widest transition group">
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Dashboard
                </a>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 p-[2px]">
                        <div class="w-full h-full bg-[#0a0a0a] rounded-[14px] flex items-center justify-center text-xl font-black text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">{{ Auth::user()->name }}</h1>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 md:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Password -->
            <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 md:p-8">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Danger Zone -->
            <div class="bg-[#0a0a0a] border border-red-500/10 rounded-3xl p-6 md:p-8">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>
