<x-app-layout>
    <div class="min-h-full py-6 md:py-12 px-4 sm:px-6 lg:px-8 bg-black">
        <div class="max-w-5xl mx-auto space-y-8">

            <!-- Top Navigation Bar -->
            <div class="flex items-center justify-between">
                <a href="{{ route('app') }}" class="flex items-center gap-2 text-gray-400 hover:text-white text-sm font-bold transition group">
                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-hover:bg-white/10 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </div>
                    <span class="hidden sm:inline">Dashboard</span>
                </a>
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-mono text-gray-600 bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">SCAN #{{ $scan->id }}</span>
                    <span class="text-[10px] font-mono text-gray-500">{{ $scan->created_at->format('M d, Y · h:i A') }}</span>
                </div>
            </div>

            <!-- Hero Score Section -->
            <div class="relative group">
                <div class="absolute -inset-1 rounded-[32px] blur opacity-20
                    {{ $scan->safety_score > 85 ? 'bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500' : ($scan->safety_score > 60 ? 'bg-gradient-to-r from-amber-500 via-yellow-500 to-orange-500' : 'bg-gradient-to-r from-red-500 via-rose-500 to-pink-500') }}"></div>
                <div class="relative bg-[#0a0a0a] border border-white/5 rounded-[32px] p-8 md:p-12 overflow-hidden">
                    <!-- Ambient glow -->
                    <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 rounded-full blur-[120px] opacity-30
                        {{ $scan->safety_score > 85 ? 'bg-emerald-600' : ($scan->safety_score > 60 ? 'bg-amber-600' : 'bg-red-600') }}"></div>

                    <div class="relative flex flex-col md:flex-row items-center gap-10">
                        <!-- Circular Score Gauge -->
                        <div class="relative w-44 h-44 md:w-52 md:h-52 flex-shrink-0">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 200 200">
                                <!-- Background circle -->
                                <circle cx="100" cy="100" r="85" stroke="rgba(255,255,255,0.05)" stroke-width="10" fill="transparent" />
                                <!-- Score arc -->
                                <circle cx="100" cy="100" r="85" stroke="url(#scoreGradient)" stroke-width="10" fill="transparent"
                                    stroke-dasharray="{{ 2 * 3.14159 * 85 }}"
                                    stroke-dashoffset="{{ (2 * 3.14159 * 85) - ((2 * 3.14159 * 85) * $scan->safety_score / 100) }}"
                                    stroke-linecap="round"
                                    class="transition-all duration-1000" />
                                <defs>
                                    <linearGradient id="scoreGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        @if($scan->safety_score > 85)
                                            <stop offset="0%" stop-color="#10b981" />
                                            <stop offset="100%" stop-color="#14b8a6" />
                                        @elseif($scan->safety_score > 60)
                                            <stop offset="0%" stop-color="#f59e0b" />
                                            <stop offset="100%" stop-color="#f97316" />
                                        @else
                                            <stop offset="0%" stop-color="#ef4444" />
                                            <stop offset="100%" stop-color="#ec4899" />
                                        @endif
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-5xl md:text-6xl font-black text-white">{{ $scan->safety_score }}</span>
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mt-1">Safety Score</span>
                            </div>
                        </div>

                        <!-- Score Info -->
                        <div class="flex-1 text-center md:text-left space-y-4">
                            <div>
                                @if($scan->safety_score > 85)
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 mb-3">
                                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                                        <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider">Verified Safe</span>
                                    </div>
                                @elseif($scan->safety_score > 60)
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 mb-3">
                                        <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                                        <span class="text-[11px] font-bold text-amber-400 uppercase tracking-wider">Needs Review</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/10 border border-red-500/20 mb-3">
                                        <div class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></div>
                                        <span class="text-[11px] font-bold text-red-400 uppercase tracking-wider">Action Required</span>
                                    </div>
                                @endif

                                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">
                                    {{ $scan->safety_score > 85 ? 'Content Approved' : ($scan->safety_score > 60 ? 'Refinement Recommended' : 'High Risk Detected') }}
                                </h1>
                                <p class="text-sm text-gray-500 mt-2 max-w-md">
                                    Your content has been analyzed by ZenGravity AI. 
                                    {{ $scan->safety_score > 85 ? 'No issues found — ready for distribution.' : 'Review the findings below for optimization.' }}
                                </p>
                            </div>

                            <!-- Quick Stats -->
                            <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                                <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/5">
                                    <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Violations</span>
                                    <span class="text-lg font-black text-white">{{ is_array($scan->violations) ? count($scan->violations) : 0 }}</span>
                                </div>
                                <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/5">
                                    <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Media Type</span>
                                    <span class="text-lg font-black text-white capitalize">{{ $scan->media_type ?? pathinfo($scan->file_path, PATHINFO_EXTENSION) }}</span>
                                </div>
                                <div class="px-4 py-2 rounded-xl bg-white/5 border border-white/5">
                                    <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Scanned</span>
                                    <span class="text-lg font-black text-white">{{ $scan->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Media Preview -->
                <div class="md:col-span-1">
                    <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl overflow-hidden">
                        <div class="aspect-square bg-black/50 flex items-center justify-center overflow-hidden">
                            @php
                                $ext = strtolower(pathinfo($scan->file_path, PATHINFO_EXTENSION));
                                $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']);
                                $isAudio = in_array($ext, ['mp3', 'wav', 'ogg', 'flac', 'aac']);
                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']);
                            @endphp

                            @if($isVideo)
                                <video src="{{ asset('storage/' . $scan->file_path) }}" controls class="w-full h-full object-cover"></video>
                            @elseif($isAudio)
                                <div class="flex flex-col items-center gap-4 p-6">
                                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500/20 to-pink-500/20 border border-purple-500/20 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                    <audio src="{{ asset('storage/' . $scan->file_path) }}" controls class="w-full"></audio>
                                </div>
                            @elseif($isImage)
                                <img src="{{ asset('storage/' . $scan->file_path) }}" class="w-full h-full object-cover" alt="Scanned media">
                            @else
                                <div class="flex flex-col items-center gap-3 p-6">
                                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-blue-500/20 to-cyan-500/20 border border-blue-500/20 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">{{ strtoupper($ext) }} File</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-4 border-t border-white/5">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest text-center">Source Media</p>
                            <p class="text-[11px] text-gray-600 text-center mt-1 truncate">{{ basename($scan->file_path) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Analysis Details -->
                <div class="md:col-span-2 space-y-6">

                    <!-- AI Feedback Card -->
                    <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500/20 to-purple-500/20 border border-blue-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-white uppercase tracking-tight">AI Analysis</h3>
                                <p class="text-[10px] text-gray-500 uppercase tracking-widest">ZenGravity Intelligence Engine</p>
                            </div>
                        </div>

                        <div class="p-5 bg-white/[0.02] rounded-2xl border border-white/5">
                            <p class="text-sm text-gray-300 leading-relaxed">
                                {{ $scan->ai_feedback ?? 'The ZEN algorithm has scanned your content. No further adjustments required for maximum reach.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Violations Card -->
                    <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-2xl flex items-center justify-center
                                {{ (is_array($scan->violations) && count($scan->violations) > 0) ? 'bg-gradient-to-br from-red-500/20 to-rose-500/20 border border-red-500/20' : 'bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-500/20' }}">
                                @if(is_array($scan->violations) && count($scan->violations) > 0)
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-base font-black text-white uppercase tracking-tight">
                                    {{ (is_array($scan->violations) && count($scan->violations) > 0) ? 'Detected Risks' : 'All Clear' }}
                                </h3>
                                <p class="text-[10px] text-gray-500 uppercase tracking-widest">Content Compliance Check</p>
                            </div>
                        </div>

                        @if(is_array($scan->violations) && count($scan->violations) > 0)
                            <div class="space-y-2">
                                @foreach($scan->violations as $violation)
                                    <div class="flex items-center gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/10">
                                        <div class="w-6 h-6 rounded-lg bg-red-500/20 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </div>
                                        <span class="text-sm text-red-300 font-medium">{{ $violation }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-500/5 border border-emerald-500/10">
                                <div class="w-8 h-8 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm text-emerald-300/80">No violations detected. Your content is clean and ready for distribution.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('app') }}" class="flex-1 h-12 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/10 flex items-center justify-center gap-2 text-sm font-bold text-gray-400 hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            New Scan
                        </a>
                        <form method="POST" action="{{ route('scans.destroy', $scan) }}" class="flex-1"
                              onsubmit="return confirm('Delete this scan permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full h-12 rounded-2xl bg-red-500/5 border border-red-500/10 hover:bg-red-500/15 hover:border-red-500/20 flex items-center justify-center gap-2 text-sm font-bold text-red-400/60 hover:text-red-400 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete Scan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
