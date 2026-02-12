<x-app-layout>
    <div class="min-h-full py-6 md:py-12 px-4 sm:px-6 lg:px-8 bg-black"
         x-data="{
            showPitch: false,
            activeName: '',
            activePitch: '',
            openPitch(name, pitch) {
                this.activeName = name;
                this.activePitch = pitch;
                this.showPitch = true;
            }
         }">
        <div class="max-w-5xl mx-auto space-y-10">

            <!-- Header -->
            <div class="space-y-3">
                <a href="{{ route('app') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-white text-xs font-bold uppercase tracking-widest transition group">
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Dashboard
                </a>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                    Vibe <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-500">Matches</span>
                </h1>
                <p class="text-sm text-gray-500">Curated creators aligned with your <span class="text-pink-400 font-semibold">'{{ $userProfile->niche }}'</span> energy.</p>
            </div>

            <!-- Match Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($matches as $match)
                    <div class="group bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 hover:border-pink-500/20 transition-all duration-500 relative overflow-hidden">
                        <!-- Ambient glow -->
                        <div class="absolute -top-16 -right-16 w-40 h-40 bg-pink-500/5 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                        <div class="relative">
                            <!-- Profile Header -->
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-pink-500 to-purple-600 p-[2px]">
                                        <div class="w-full h-full bg-[#0a0a0a] rounded-[14px] flex items-center justify-center text-sm font-black text-white">
                                            {{ substr($match->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-white leading-tight">{{ $match->name }}</h3>
                                        <p class="text-[10px] text-gray-500 uppercase tracking-widest">{{ $match->niche }}</p>
                                    </div>
                                </div>
                                <!-- Vibe Score -->
                                <div class="text-center">
                                    <span class="text-lg font-black {{ $match->vibe_score >= 90 ? 'text-emerald-400' : 'text-pink-400' }}">{{ $match->vibe_score }}%</span>
                                    <p class="text-[8px] text-gray-600 uppercase tracking-widest">Vibe</p>
                                </div>
                            </div>

                            <!-- Bio -->
                            <p class="text-xs text-gray-500 leading-relaxed mb-5 line-clamp-2 min-h-[2rem]">{{ $match->bio_summary }}</p>

                            <!-- Vibe Bar -->
                            <div class="mb-5">
                                <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-700
                                        {{ $match->vibe_score >= 90 ? 'bg-gradient-to-r from-emerald-500 to-teal-400' : 'bg-gradient-to-r from-pink-500 to-purple-500' }}"
                                        style="width: {{ $match->vibe_score }}%"></div>
                                </div>
                            </div>

                            <!-- CTA -->
                            <button
                                @click="openPitch({{ json_encode($match->name) }}, {{ json_encode($match->ai_pitch) }})"
                                class="w-full h-11 rounded-xl bg-white/[0.03] border border-white/10 hover:bg-pink-500 hover:border-pink-500 text-xs font-bold text-gray-400 hover:text-white uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-2 group/btn">
                                <svg class="w-4 h-4 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Generate AI Pitch
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-16 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/5 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h3 class="text-lg font-black text-white mb-1">No Matches Found</h3>
                            <p class="text-sm text-gray-500">Try updating your niche to cast a wider net.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pitch Modal -->
        <div x-show="showPitch"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="display: none;"
             @keydown.escape.window="showPitch = false">

            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="showPitch = false"></div>

            <!-- Panel -->
            <div class="relative w-full max-w-lg bg-[#0a0a0a] border border-pink-500/20 rounded-3xl overflow-hidden shadow-2xl shadow-pink-500/10"
                 x-show="showPitch"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4">

                <!-- Pink glow -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-20 w-64 h-64 bg-pink-500/10 rounded-full blur-[100px]"></div>

                <div class="relative p-6 md:p-8">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Pitch to</h3>
                            <p class="text-sm text-pink-400 font-bold mt-0.5" x-text="activeName"></p>
                        </div>
                        <button @click="showPitch = false" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-500 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Pitch Content -->
                        <div class="p-5 bg-white/[0.03] rounded-2xl border border-white/5">
                            <p class="text-[9px] font-bold text-pink-400 uppercase tracking-widest mb-3">AI Generated Pitch</p>
                            <p class="text-sm text-gray-300 leading-relaxed italic" x-text="activePitch"></p>
                        </div>

                        <!-- Copy Action -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button @click="navigator.clipboard.writeText(activePitch); $el.textContent = '✓ Copied!'; setTimeout(() => $el.textContent = 'Copy Pitch', 2000)"
                                class="flex-1 h-11 rounded-xl bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-400 hover:to-purple-400 text-sm font-bold text-white transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-pink-500/20">
                                Copy Pitch
                            </button>
                            <button @click="showPitch = false"
                                class="flex-1 h-11 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-sm font-bold text-gray-400 hover:text-white transition-all duration-300">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
