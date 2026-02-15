<div class="h-full flex flex-col bg-[#050810] border-r border-white/10 relative z-20">
    <!-- Knowledge Input -->
    <div class="p-4 border-b border-white/10 shrink-0">
        <button @click="sidebarOpen = !sidebarOpen" class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-600/10 to-blue-600/10 border border-cyan-500/20 hover:border-cyan-500/50 transition flex items-center justify-center gap-2 group">
            <svg class="w-5 h-5 text-cyan-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            <span class="text-sm font-bold text-cyan-100">Upload Course Material</span>
        </button>
        <!-- Upload Expansion -->
        <div x-show="sidebarOpen" class="mt-4 p-4 rounded-xl bg-white/5 border border-white/10" x-transition>
            <form action="{{ route('exam.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="text" name="course_name" class="w-full bg-black/40 border-white/10 rounded-lg text-xs" placeholder="Course Name">
                 <input type="file" name="file" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-cyan-500/10 file:text-cyan-400 hover:file:bg-cyan-500/20">
                <button class="w-full py-2 bg-cyan-600 text-xs font-bold rounded-lg text-white">Index Now</button>
            </form>
        </div>
    </div>

    <!-- Live Intercept Feed -->
    <div class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-3">
        <div class="flex items-center justify-between mb-2 px-2 shrink-0">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Intercept Stream</span>
            <span class="text-[10px] font-mono text-cyan-500 bg-cyan-500/10 px-1.5 py-0.5 rounded">LIVE</span>
        </div>

        <template x-for="q in questions" :key="q.id">
            <div class="p-3 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-500/30 hover:bg-white/10 transition cursor-pointer group" @click="solve(q)">
                <div class="flex justify-between items-start gap-2">
                    <p class="text-sm text-gray-300 font-medium line-clamp-3" x-text="q.text"></p>
                    <span class="text-[10px] font-mono text-gray-600 shrink-0" x-text="new Date(q.id).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                </div>
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-[10px] text-gray-500 font-bold" :class="q.status === 'solved' ? 'text-green-500' : 'text-amber-500'" x-text="q.status.toUpperCase()"></span>
                    <button class="opacity-0 group-hover:opacity-100 px-2 py-1 rounded bg-cyan-500 text-white text-[10px] font-bold transition">SOLVE</button>
                </div>
                
                <div x-show="activeQuestion && activeQuestion.id === q.id" class="mt-3 pt-3 border-t border-white/10" x-transition>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] uppercase font-bold text-cyan-400">Zenith Analysis</span>
                        <span class="text-[10px] font-black" :class="confidence > 80 ? 'text-green-400' : 'text-amber-400'" x-text="confidence + '% CONFIDENCE'"></span>
                    </div>
                    <div class="prose prose-invert prose-sm max-w-none text-xs text-gray-300">
                        <div x-html="q.answer || '<span class=\'animate-pulse\'>Deciphering...</span>'"></div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
