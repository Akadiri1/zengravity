<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            /* Hide scrollbar for Chrome, Safari and Opera */
            ::-webkit-scrollbar {
                display: none;
            }

            /* Hide scrollbar for IE, Edge and Firefox */
            html, body {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }

            @keyframes typing {
                from { width: 0 }
                to { width: 100% }
            }
            @keyframes blink-caret {
                from, to { border-color: transparent }
                50% { border-color: #a855f7; }
            }
            .typewriter {
                animation: 
                    typing 3s cubic-bezier(0.4, 0, 0.2, 1) forwards,
                    blink-caret .75s step-end infinite;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#050810] text-gray-200">
        <div class="flex h-screen overflow-hidden bg-[#050810]" x-data="{ sidebarOpen: false }">
            
            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Page Content -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <!-- Mobile Header -->
                <div class="sticky top-0 z-40 flex items-center justify-between h-14 px-4 bg-[#060608]/90 backdrop-blur-xl border-b border-white/5 md:hidden">
                    <button @click="$store.sidebar.mobileOpen = true" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center hover:bg-white/[0.06] text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-lg font-black text-white tracking-tighter uppercase leading-none" 
                          style="text-shadow: -1.5px -0.5px 0 rgba(255,0,0,0.5), 1.5px 0.5px 0 rgba(0,255,255,0.5);">
                        ZEN<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 font-mono typewriter inline-block" style="text-shadow:none;">GRAVITY</span>
                    </span>
                    @auth
                    <div class="flex items-center gap-2">
                        @php
                            $user = Auth::user();
                            $status = $user->subscribed('default') ? 'PRO' : ($user->onTrial() ? 'TRIAL' : 'SCOUT');
                            $statusColor = $status === 'PRO' ? 'text-blue-400 bg-blue-500/10' : ($status === 'TRIAL' ? 'text-purple-400 bg-purple-500/10' : 'text-gray-400 bg-white/10');
                        @endphp
                        <span class="text-[10px] font-black {{ $statusColor }} uppercase tracking-wider px-2.5 py-1 rounded-lg">{{ $status }}</span>
                        <a href="{{ route('profile.edit') }}" wire:navigate class="relative w-9 h-9 rounded-full bg-gradient-to-br from-red-500 via-yellow-500 via-green-500 to-blue-500 p-[2px] group">
                            <div class="w-full h-full bg-[#060608] rounded-full flex items-center justify-center text-xs font-bold text-white group-hover:bg-[#0a0a0a] transition overflow-hidden">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-[#060608]"></div>
                        </a>
                    </div>
                    @else
                    <div class="w-9"></div>
                    @endauth
                </div>

                <!-- Desktop Top Bar -->
                @auth
                <div class="hidden md:flex sticky top-0 z-40 items-center justify-end h-14 px-6 bg-[#050810]/80 backdrop-blur-xl border-b border-white/[0.03]">
                    <div class="flex items-center gap-3">
                        @php
                            $user = Auth::user();
                            $status = $user->subscribed('default') ? 'PRO' : ($user->onTrial() ? 'TRIAL' : 'SCOUT');
                            $statusColor = $status === 'PRO' ? 'text-blue-400 bg-blue-500/10' : ($status === 'TRIAL' ? 'text-purple-400 bg-purple-500/10' : 'text-gray-400 bg-white/10');
                        @endphp
                        <span class="text-[10px] font-black {{ $statusColor }} uppercase tracking-wider px-2.5 py-1 rounded-lg">{{ $status }}</span>
                        <a href="{{ route('profile.edit') }}" wire:navigate class="relative w-9 h-9 rounded-full bg-gradient-to-br from-red-500 via-yellow-500 via-green-500 to-blue-500 p-[2px] group">
                            <div class="w-full h-full bg-[#050810] rounded-full flex items-center justify-center text-xs font-bold text-white group-hover:bg-[#0a0a0a] transition overflow-hidden">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-[#050810]"></div>
                        </a>
                    </div>
                </div>
                @endauth

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#050810] [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('modals')
        @livewireScripts
    </body>
</html>
