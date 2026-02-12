<x-app-layout>
    <div class="min-h-full py-6 md:py-12 px-4 sm:px-6 lg:px-8 bg-black"
         x-data="{
            showStrategy: false,
            activeHive: '',
            activeHook: '',
            activePillar: '',
            activeVibe: '',
            openStrategy(name, hook, pillar, vibe) {
                this.activeHive = name;
                this.activeHook = hook;
                this.activePillar = pillar;
                this.activeVibe = vibe;
                this.showStrategy = true;
            }
         }">
        <div class="max-w-5xl mx-auto space-y-10">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3">
                    <a href="{{ route('app') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-white text-xs font-bold uppercase tracking-widest transition group">
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Dashboard
                    </a>
                    <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                        HIVE<span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-500">SCOUT</span>
                    </h1>
                    <p class="text-sm text-gray-500">Scanning global data streams for emerging Masterpiece opportunities.</p>
                </div>

                <!-- Radar Status -->
                <div class="flex items-center gap-3 px-5 py-3 bg-amber-500/5 border border-amber-500/10 rounded-2xl">
                    <div class="relative">
                        <div class="w-3 h-3 bg-amber-400 rounded-full"></div>
                        <div class="absolute inset-0 w-3 h-3 bg-amber-400 rounded-full animate-ping opacity-40"></div>
                    </div>
                    <span class="text-xs font-bold text-amber-400 uppercase tracking-wider">Live Pulse</span>
                </div>
            </div>

            <!-- AI Banner -->
            <div class="relative overflow-hidden bg-[#0a0a0a] border border-white/5 rounded-2xl p-5">
                <div class="absolute top-0 right-0 w-40 h-40 bg-amber-500/5 rounded-full blur-[80px]"></div>
                <div class="relative flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">ZEN AI Strategist</p>
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest">Architecture by Famous_of_Wealth</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-amber-400/60 uppercase tracking-wider bg-amber-500/5 px-3 py-1.5 rounded-lg border border-amber-500/10">
                        {{ empty(config('services.gemini.key')) ? 'API Key Pending' : 'Connected' }}
                    </span>
                </div>
            </div>

            <!-- Trend Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @foreach($hives as $hive)
                @php
                    $strategyData = [
                        'hook' => $hive['strategy']['hook'] ?? 'Strategy loading...',
                        'pillar' => is_array($hive['strategy']['pillars'] ?? null) ? ($hive['strategy']['pillars'][0] ?? 'N/A') : ($hive['strategy']['pillars'] ?? 'N/A'),
                        'vibe' => $hive['strategy']['vibe'] ?? 'High Energy',
                    ];
                @endphp
                <div class="group bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 md:p-8 hover:border-amber-500/20 transition-all duration-500 relative overflow-hidden">
                    <!-- Ambient glow on hover -->
                    <div class="absolute -top-20 -right-20 w-48 h-48 bg-amber-500/5 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                    <div class="relative">
                        <!-- Top Row -->
                        <div class="flex items-start justify-between mb-6">
                            <div class="space-y-2">
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-amber-400 uppercase tracking-widest bg-amber-500/10 px-2.5 py-1 rounded-lg border border-amber-500/15">
                                    <div class="w-1.5 h-1.5 bg-amber-400 rounded-full"></div>
                                    {{ $hive['platform'] }}
                                </span>
                                <h3 class="text-xl font-black text-white tracking-tight">{{ $hive['name'] }}</h3>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl md:text-3xl font-black text-emerald-400">+{{ $hive['surge'] }}%</span>
                                <p class="text-[9px] text-gray-600 uppercase tracking-widest">Surge</p>
                            </div>
                        </div>

                        <!-- Stats Row -->
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="bg-white/[0.03] p-3.5 rounded-xl border border-white/5">
                                <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mb-1">Competition</p>
                                <p class="text-sm font-bold text-gray-300">{{ $hive['competition'] }}</p>
                            </div>
                            <div class="bg-white/[0.03] p-3.5 rounded-xl border border-white/5">
                                <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mb-1">Monetization</p>
                                <p class="text-sm font-bold text-gray-300">High Tier</p>
                            </div>
                        </div>

                        <!-- AI Preview -->
                        <div class="p-4 bg-amber-500/[0.03] rounded-xl border border-amber-500/10 mb-6">
                            <div class="flex items-center gap-2 mb-2.5">
                                <div class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></div>
                                <span class="text-[9px] font-bold text-amber-400/70 uppercase tracking-widest">AI Strategy Blueprint</span>
                            </div>
                            <div class="space-y-1.5 opacity-40">
                                <div class="h-1.5 w-full bg-gray-800 rounded-full"></div>
                                <div class="h-1.5 w-3/4 bg-gray-800 rounded-full"></div>
                            </div>
                        </div>

                        <!-- Action -->
                        <button
                            @click="openStrategy(
                                {{ json_encode($hive['name']) }},
                                {{ json_encode($strategyData['hook']) }},
                                {{ json_encode($strategyData['pillar']) }},
                                {{ json_encode($strategyData['vibe']) }}
                            )"
                            class="w-full h-11 rounded-xl bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 hover:border-amber-500 text-xs font-black uppercase tracking-widest transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Build Strategy
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Footer -->
            <div class="text-center py-6">
                <p class="text-xs text-gray-600">New trends are synthesized every 6 hours. Stay in the Zen flow.</p>
            </div>
        </div>

        <!-- Strategy Modal -->
        <div x-show="showStrategy"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="display: none;"
             @keydown.escape.window="showStrategy = false">

            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="showStrategy = false"></div>

            <!-- Panel -->
            <div class="relative w-full max-w-lg bg-[#0a0a0a] border border-amber-500/20 rounded-3xl overflow-hidden shadow-2xl shadow-amber-500/10"
                 x-show="showStrategy"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4">

                <!-- Amber glow -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-20 w-64 h-64 bg-amber-500/10 rounded-full blur-[100px]"></div>

                <div class="relative p-6 md:p-8">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Strategy</h3>
                            <p class="text-sm text-amber-400 font-bold mt-0.5" x-text="activeHive"></p>
                        </div>
                        <button @click="showStrategy = false" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-500 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Hook -->
                        <div class="p-4 bg-white/[0.03] rounded-2xl border border-white/5">
                            <p class="text-[9px] font-bold text-amber-400 uppercase tracking-widest mb-2">Target Hook</p>
                            <p class="text-sm text-gray-300 leading-relaxed italic" x-text="activeHook"></p>
                        </div>

                        <!-- Pillar + Vibe -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-4 bg-white/[0.03] rounded-2xl border border-white/5">
                                <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mb-2">Primary Pillar</p>
                                <p class="text-sm font-bold text-white" x-text="activePillar"></p>
                            </div>
                            <div class="p-4 bg-white/[0.03] rounded-2xl border border-white/5">
                                <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mb-2">Vibe Check</p>
                                <p class="text-sm font-bold text-white" x-text="activeVibe"></p>
                            </div>
                        </div>

                        <!-- Script Generator CTA -->
                        <div class="p-4 bg-amber-500/5 rounded-2xl border border-amber-500/10 text-center">
                            <p class="text-[10px] text-amber-400/70 font-bold uppercase tracking-widest mb-2">Pro Feature</p>
                            <button class="h-9 px-5 rounded-xl bg-amber-500/20 text-amber-400 text-[10px] font-black uppercase tracking-widest opacity-60 cursor-not-allowed border border-amber-500/20">
                                Connect API Key for Full Script
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
