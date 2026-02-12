<x-app-layout>
    <div class="min-h-full py-6 md:py-12 px-4 sm:px-6 lg:px-8 bg-black">
        <div class="max-w-5xl mx-auto space-y-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight uppercase">Scan History</h1>
                    <p class="text-sm text-gray-500">{{ $scans->count() }} {{ Str::plural('scan', $scans->count()) }} in your ledger</p>
                </div>
                <a href="{{ route('app') }}" class="h-10 px-5 rounded-xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-500/20 hover:border-blue-500/40 flex items-center gap-2 text-sm font-bold text-blue-400 hover:text-blue-300 transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    New Scan
                </a>
            </div>

            @if($scans->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($scans as $scan)
                        <a href="{{ route('scans.show', $scan) }}" class="group block">
                            <div class="bg-[#0a0a0a] border border-white/5 rounded-2xl overflow-hidden hover:border-white/10 transition-all duration-300 hover:translate-y-[-2px]">
                                
                                <!-- Media Thumbnail -->
                                <div class="h-40 bg-black/50 overflow-hidden relative">
                                    @php
                                        $ext = strtolower(pathinfo($scan->file_path, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']);
                                        $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $scan->file_path) }}" alt="" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500">
                                    @elseif($isVideo)
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-900/30 to-blue-900/30">
                                            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white/60" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-900/50 to-gray-800/50">
                                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Score Badge -->
                                    <div class="absolute top-3 right-3">
                                        <div class="h-8 min-w-[2rem] px-2.5 rounded-lg flex items-center justify-center text-xs font-black
                                            {{ $scan->safety_score > 85 ? 'bg-emerald-500/90 text-white' : ($scan->safety_score > 60 ? 'bg-amber-500/90 text-black' : 'bg-red-500/90 text-white') }}
                                            shadow-lg backdrop-blur-sm">
                                            {{ $scan->safety_score }}
                                        </div>
                                    </div>

                                    <!-- Ext Badge -->
                                    <div class="absolute bottom-3 left-3">
                                        <span class="text-[9px] font-black text-gray-400 uppercase bg-black/60 backdrop-blur-sm px-2 py-1 rounded-md tracking-wider">{{ strtoupper($ext) }}</span>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="p-4 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-mono text-gray-600">Scan #{{ $scan->id }}</span>
                                        <span class="text-[10px] text-gray-600">{{ $scan->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full
                                            {{ $scan->safety_score > 85 ? 'bg-emerald-400' : ($scan->safety_score > 60 ? 'bg-amber-400' : 'bg-red-400') }}"></div>
                                        <span class="text-xs font-bold text-gray-400">
                                            {{ $scan->safety_score > 85 ? 'Verified Safe' : ($scan->safety_score > 60 ? 'Needs Review' : 'High Risk') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-16 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-3xl bg-white/5 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-white mb-2">No scans yet</h3>
                    <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">Upload your first file to get an AI-powered safety analysis.</p>
                    <a href="{{ route('app') }}" class="inline-flex items-center gap-2 h-11 px-6 rounded-xl bg-gradient-to-r from-blue-500 to-purple-500 text-sm font-bold text-white hover:from-blue-400 hover:to-purple-400 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Start Scanning
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
