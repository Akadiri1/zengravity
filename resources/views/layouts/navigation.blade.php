<div x-data="{ 
        expanded: localStorage.getItem('sidebarExpanded') !== null 
            ? localStorage.getItem('sidebarExpanded') === 'true' 
            : true
     }" 
     x-init="$watch('expanded', value => localStorage.setItem('sidebarExpanded', value))"
     class="flex-shrink-0 h-full">

    <!-- ============================================== -->
    <!-- MOBILE SIDEBAR (Overlay, Fixed, z-50)          -->
    <!-- Visible only on small screens (< md)           -->
    <!-- ============================================== -->
    <div x-show="$store.sidebar.mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         class="fixed inset-0 z-50 md:hidden font-sans">
        
        <!-- Backdrop -->
        <div @click="$store.sidebar.mobileOpen = false"
             class="absolute inset-0 bg-black/80 backdrop-blur-sm">
        </div>

        <!-- Mobile Drawer -->
        <div x-show="$store.sidebar.mobileOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="absolute inset-y-0 left-0 w-64 bg-[#050505] border-r border-white/10 shadow-2xl flex flex-col h-full">
            
            <!-- Mobile Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-white/5">
                <span class="text-xl font-black text-white tracking-tighter uppercase leading-none" 
                      style="text-shadow: -1.5px -0.5px 0 rgba(255, 0, 0, 0.5), 1.5px 0.5px 0 rgba(0, 255, 255, 0.5);">
                    ZEN<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 relative -top-0.5 font-mono typewriter inline-block" style="text-shadow: none;">GRAVITY</span>
                </span>
                <button @click="$store.sidebar.mobileOpen = false" type="button" class="p-2 -mr-2 text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Links -->
            <div class="flex-1 overflow-y-auto py-4 px-4 space-y-2" @click="$store.sidebar.mobileOpen = false">
                @include('layouts.partials.sidebar-links', ['mobile' => true])
            </div>

            <!-- Mobile Footer -->
            <div class="p-4 border-t border-white/5">
                @include('layouts.partials.sidebar-footer', ['mobile' => true])
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- DESKTOP SIDEBAR (Static, Flex Item, z-0)       -->
    <!-- Visible only on desktop (>= md)                -->
    <!-- ============================================== -->
    <div class="hidden md:flex flex-col h-full bg-[#060608] transition-all duration-300 relative"
         :class="expanded ? 'w-64' : 'w-[72px]'">
        
        <!-- Subtle right border gradient -->
        <div class="absolute right-0 inset-y-0 w-px bg-gradient-to-b from-transparent via-white/[0.06] to-transparent"></div>
        
        <!-- Desktop Header -->
        <div class="h-20 flex items-center px-4 justify-between flex-shrink-0">
            <!-- Logo -->
            <div x-show="expanded" x-transition.opacity.duration.200ms class="flex items-center overflow-hidden whitespace-nowrap pl-1">
                 <span class="text-lg font-black text-white tracking-tighter uppercase leading-none" 
                       style="text-shadow: -1.5px -0.5px 0 rgba(255, 0, 0, 0.4), 1.5px 0.5px 0 rgba(0, 255, 255, 0.4);">
                      ZEN<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 relative -top-0.5 font-mono typewriter inline-block" style="text-shadow: none;">GRAVITY</span>
                 </span>
            </div>

            <!-- Toggle Button -->
            <button @click="expanded = !expanded" 
                    type="button"
                    class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300 hover:bg-white/[0.06] text-gray-500 hover:text-gray-300"
                    :class="expanded ? '' : 'mx-auto'">
                
                <div class="w-5 h-5 flex flex-col justify-center items-center gap-[5px] overflow-hidden">
                    <span class="w-4 h-[1.5px] bg-current rounded-full transition-all duration-300 transform origin-center" 
                          :class="expanded ? '' : 'rotate-45 translate-y-[6.5px]'"></span>
                    <span class="h-[1.5px] bg-current rounded-full transition-all duration-300"
                          :class="expanded ? 'w-2.5' : 'w-0 opacity-0'"></span>
                    <span class="w-4 h-[1.5px] bg-current rounded-full transition-all duration-300 transform origin-center" 
                          :class="expanded ? '' : '-rotate-45 -translate-y-[6.5px]'"></span>
                </div>
            </button>
        </div>

        <!-- Desktop Links -->
        <div class="flex-1 overflow-y-auto py-2 scrollbar-hide">
            @include('layouts.partials.sidebar-links', ['mobile' => false])
        </div>

        <!-- Desktop Footer -->
        <div class="py-3 px-1 flex-shrink-0">
            <div class="mx-3 mb-3 h-px bg-gradient-to-r from-transparent via-white/[0.06] to-transparent"></div>
            @include('layouts.partials.sidebar-footer', ['mobile' => false])
        </div>
    </div>

</div>
