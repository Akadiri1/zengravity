<x-app-layout>
    <div class="min-h-full py-6 md:py-12 px-4 sm:px-6 lg:px-8 bg-black">
        <div class="max-w-3xl mx-auto">
            
            <!-- Header -->
            <div class="text-center mb-12 space-y-4">
                <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-purple-500/10 border border-purple-500/20 mb-4">
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight italic uppercase">
                    Collab <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">Forge</span>
                </h1>
                <p class="text-gray-500 text-lg max-w-xl mx-auto">
                    Initialize your founder profile to activate the vibe-matching neural network.
                </p>
            </div>

            <!-- Setup Form -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-[32px] blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                <div class="relative bg-[#0a0a0a] border border-white/5 rounded-[32px] p-8 md:p-12 shadow-2xl overflow-hidden">
                    
                    <form action="{{ route('collab.profile') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <!-- Niche Input -->
                        <div class="space-y-3">
                            <label for="niche" class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Your Primary Niche</label>
                            <input type="text" name="niche" id="niche" placeholder="e.g. Cyberpunk Aesthetics, Synthetic Music, AI Ethics" required
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all duration-300">
                            <p class="text-[10px] text-gray-500 italic">This is used to match you with compatible creator energies.</p>
                        </div>

                        <!-- Bio Input -->
                        <div class="space-y-3">
                            <label for="bio_summary" class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Founder Manifesto (Bio)</label>
                            <textarea name="bio_summary" id="bio_summary" rows="4" placeholder="Describe your vision and what you're building..." required
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all duration-300 resize-none"></textarea>
                        </div>

                        <!-- Action -->
                        <div class="pt-4">
                            <button type="submit" class="w-full h-16 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-black text-white uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all duration-300 shadow-xl shadow-purple-500/20">
                                Forge Profile & Find Matches
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Info Footer -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="space-y-2">
                    <div class="text-purple-400 font-bold uppercase tracking-tighter text-sm">01. Identity</div>
                    <p class="text-xs text-gray-600">Establish your digital footprint in the ZENGRAVITY ecosystem.</p>
                </div>
                <div class="space-y-2">
                    <div class="text-purple-400 font-bold uppercase tracking-tighter text-sm">02. Neural-Match</div>
                    <p class="text-xs text-gray-600">Our AI scans the "Hive" for creators with complementary vibes.</p>
                </div>
                <div class="space-y-2">
                    <div class="text-purple-400 font-bold uppercase tracking-tighter text-sm">03. Synthesis</div>
                    <p class="text-xs text-gray-600">Generate high-conversion outreach pitches instantly.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
