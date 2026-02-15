@props(['mobile' => false])

<!-- Navigation -->
<nav class="space-y-1.5 px-3">
    
    @php
        $links = [
            [
                'route' => 'app',
                'routeMatch' => 'app',
                'label' => 'Hub',
                'color' => 'indigo',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />',
            ],
            [
                'route' => 'scans.index',
                'routeMatch' => 'scans.*',
                'label' => 'Ghost Scanner',
                'color' => 'blue',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />',
            ],
            [
                'route' => 'collab.matches',
                'routeMatch' => 'collab.*',
                'label' => 'Collab Forge',
                'color' => 'purple',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />',
            ],
            [
                'route' => 'hive.index',
                'routeMatch' => 'hive.*',
                'label' => 'Hive Scout',
                'color' => 'amber',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z" />',
            ],
            /*
            [
                'route' => 'exam.dashboard',
                'routeMatch' => 'exam.*',
                'label' => 'Zenith Academy',
                'color' => 'cyan',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />',
            ],
            */

            [
                'route' => 'updates',
                'routeMatch' => 'updates',
                'label' => 'Updates',
                'color' => 'teal',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />',
            ],
        ];

        if (auth()->user() && auth()->user()->is_admin) {
            $links[] = [
                'route' => 'admin.dashboard',
                'routeMatch' => 'admin.*',
                'label' => 'Admin Dashboard',
                'color' => 'red',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />',
            ];
        }
    @endphp

    @foreach($links as $link)
        @php
            $isActive = request()->routeIs($link['routeMatch']);
            $color = $link['color'];
        @endphp
        <a href="{{ route($link['route']) }}" wire:navigate
           class="group relative flex items-center gap-3.5 px-3 py-2.5 rounded-2xl transition-all duration-300 {{ $isActive ? 'bg-white/[0.06]' : 'hover:bg-white/[0.04]' }}"
           :class="expanded || {{ $mobile ? 'true' : 'false' }} ? '' : 'justify-center px-0'">
            
            {{-- Active indicator line --}}
            @if($isActive)
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-{{ $color }}-500 rounded-r-full shadow-lg shadow-{{ $color }}-500/50"
                     x-show="expanded || {{ $mobile ? 'true' : 'false' }}"></div>
            @endif

            {{-- Icon circle --}}
            <div class="relative w-11 h-11 flex items-center justify-center rounded-full shrink-0 transition-all duration-300 group-hover:scale-110
                {{ $isActive 
                    ? 'bg-'.$color.'-500/20 text-'.$color.'-400 ring-1 ring-'.$color.'-500/30' 
                    : 'bg-white/[0.04] text-gray-500 group-hover:bg-'.$color.'-500/15 group-hover:text-'.$color.'-400' }}">
                <svg class="w-[22px] h-[22px] transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    {!! $link['icon'] !!}
                </svg>
                @if($isActive)
                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-{{ $color }}-500 rounded-full border-2 border-[#050505] shadow-sm shadow-{{ $color }}-500/50"></div>
                @endif
            </div>

            {{-- Label --}}
            <span class="text-[13px] font-semibold tracking-wide whitespace-nowrap transition-all duration-200 {{ $isActive ? 'text-white' : 'text-gray-500 group-hover:text-gray-200' }}"
                  x-show="expanded || {{ $mobile ? 'true' : 'false' }}"
                  x-transition:enter="transition ease-out duration-150"
                  x-transition:enter-start="opacity-0 translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0">
                {{ $link['label'] }}
            </span>
        </a>
    @endforeach

</nav>

<!-- Divider -->
<div class="my-5 mx-4">
    <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
</div>

<!-- Recent Audits -->
<div class="px-4 mb-2" x-show="expanded || {{ $mobile ? 'true' : 'false' }}" x-transition>
    <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-[0.15em]">Recent Audits</h3>
</div>

<div class="space-y-0.5 px-3">
    @php
        $recentScans = \App\Models\Scan::latest()->take(3)->get();
    @endphp

    @forelse($recentScans as $scan)
        <a href="{{ route('scans.show', $scan) }}" wire:navigate
           class="group flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/[0.04] transition-all duration-200"
           :class="expanded || {{ $mobile ? 'true' : 'false' }} ? '' : 'justify-center px-0'">
            <span class="w-2 h-2 rounded-full shrink-0 {{ $scan->safety_score > 80 ? 'bg-emerald-500' : ($scan->safety_score > 50 ? 'bg-amber-500' : 'bg-red-500') }}"></span>
            <span class="text-xs text-gray-500 group-hover:text-gray-300 truncate transition font-medium" 
                  x-show="expanded || {{ $mobile ? 'true' : 'false' }}"
                  x-transition>
                Audit #{{ $scan->id }}
            </span>
        </a>
    @empty
        <div class="px-3 py-2 text-xs text-gray-700 italic" x-show="expanded || {{ $mobile ? 'true' : 'false' }}">
            No recent activity
        </div>
    @endforelse
</div>
