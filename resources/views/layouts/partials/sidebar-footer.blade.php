<div class="space-y-1 px-3">
    <!-- User Profile -->
    <a href="{{ route('profile.edit') }}" wire:navigate @click="$store.sidebar.mobileOpen = false" 
       class="group flex items-center gap-3.5 px-3 py-2.5 rounded-2xl hover:bg-white/[0.04] transition-all duration-300"
       :class="expanded || {{ $mobile ? 'true' : 'false' }} ? '' : 'justify-center px-0'">
        
        <!-- Avatar Circle -->
        <div class="relative w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shrink-0 ring-2 ring-white/10 group-hover:ring-purple-500/30 transition-all duration-300">
            <span class="text-sm font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 rounded-full border-2 border-[#050505]"></div>
        </div>

        <!-- User Info -->
        <div class="flex-1 min-w-0 text-left"
             x-show="{{ $mobile ? 'true' : 'expanded' }}"
             x-transition
             style="{{ $mobile ? '' : 'display:none;' }}">
            <p class="text-sm font-semibold text-gray-200 truncate leading-tight">{{ Auth::user()->name }}</p>
            <p class="text-[11px] text-gray-600 font-medium">Settings</p>
        </div>

        <!-- Chevron -->
        <svg class="w-4 h-4 text-gray-700 group-hover:text-gray-400 transition shrink-0"
             x-show="{{ $mobile ? 'true' : 'expanded' }}"
             fill="none" stroke="currentColor" viewBox="0 0 24 24"
             style="{{ $mobile ? '' : 'display:none;' }}">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </a>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" 
                class="group flex items-center gap-3.5 px-3 py-2.5 w-full rounded-2xl text-gray-500 hover:text-red-400 hover:bg-red-500/[0.06] transition-all duration-300"
                :class="expanded || {{ $mobile ? 'true' : 'false' }} ? '' : 'justify-center px-0'">
            <div class="w-10 h-10 rounded-full bg-white/[0.03] flex items-center justify-center shrink-0 group-hover:bg-red-500/10 transition-all duration-300">
                <svg class="w-5 h-5 transition-all duration-300 group-hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            <span class="text-[13px] font-semibold tracking-wide" 
                  x-show="{{ $mobile ? 'true' : 'expanded' }}"
                  x-transition
                  style="{{ $mobile ? '' : 'display:none;' }}">Sign Out</span>
        </button>
    </form>
</div>
