<div x-data="{ open: false }" 
     @open-connect-modal.window="open = true; Alpine.store('modalState').isOpen = true" 
     x-init="Alpine.store('modalState', { isOpen: false })"
     x-effect="if(!open) Alpine.store('modalState').isOpen = false"
     style="display: none;"
     x-show="open" 
     class="fixed inset-0 z-[99999] flex items-center justify-center px-4 custom-backdrop">
    
    <div class="absolute inset-0 bg-black/95 backdrop-blur-md" @click="open = false"></div>
    
    <div class="relative w-full max-w-2xl bg-[#050810] border border-white/10 rounded-3xl p-8 shadow-2xl overflow-hidden" @click.stop>
        <div class="absolute top-0 right-0 p-4">
            <button @click="open = false" class="text-gray-500 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <h2 class="text-2xl font-black text-white mb-2">Connect Zenith AI</h2>
        <p class="text-gray-400 mb-6">To let Zenith "see" your exam questions inside the secure browser, you need to create a bridge.</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Option 1: Browser Extension (Recommended) -->
            <div class="p-6 rounded-2xl bg-gradient-to-br from-purple-500/20 to-blue-500/10 border border-purple-500/30 text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-purple-500/5 group-hover:bg-purple-500/10 transition"></div>
                <div class="absolute top-0 right-0 bg-purple-500 text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg">RECOMMENDED</div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-full bg-purple-600 text-white flex items-center justify-center mx-auto mb-4 font-bold text-xl ring-4 ring-purple-500/20">1</div>
                    <h3 class="text-white font-bold mb-2">Browser Extension</h3>
                    <p class="text-xs text-gray-400 mb-4">Auto-connects to any portal. No manual steps needed after setup.</p>
                    
                    <div class="bg-black/50 rounded-lg p-3 text-left mb-3 border border-white/10">
                        <ol class="list-decimal list-inside text-[10px] text-gray-300 space-y-1">
                            <li>Go to <span class="text-cyan-400 font-mono">chrome://extensions</span></li>
                            <li>Enable "Developer mode" (top right)</li>
                            <li>Click "Load unpacked"</li>
                            <li>Select folder: <span class="text-yellow-400 font-mono select-all">C:\ZENGRAVITY\public\sidekick</span></li>
                        </ol>
                    </div>
                    
                     <button onclick="navigator.clipboard.writeText('C:\\ZENGRAVITY\\public\\sidekick'); this.innerText = 'Path Copied!';" 
                            class="w-full py-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold transition shadow-lg shadow-purple-500/30">
                        Copy Extension Path
                    </button>
                </div>
            </div>

            <!-- Option 2: Bookmarklet -->
            <div class="p-6 rounded-2xl bg-white/5 border border-white/10 text-center group hover:bg-white/10 transition">
                <div class="w-12 h-12 rounded-full bg-gray-700 text-white flex items-center justify-center mx-auto mb-4 font-bold text-xl">2</div>
                <h3 class="text-white font-bold mb-2">Magic Button</h3>
                <p class="text-xs text-gray-400 mb-4">Drag to Bookmarks Bar. Click when on exam page.</p>
                
                <a href="javascript:(function(){var s=document.createElement('script');s.src='http://127.0.0.1:8000/js/scraper.js';document.body.appendChild(s);})();" 
                   class="inline-block px-6 py-3 rounded-full bg-cyan-600 text-white font-bold shadow-lg cursor-grab active:cursor-grabbing hover:bg-cyan-500 transition border-2 border-white/10"
                   onclick="alert('Drag this button to your Bookmarks Bar, don\'t click it!')">
                    ⚡ Zenith AI Bridge
                </a>
            </div>

            <!-- Option 3: Manual Script -->
            <div class="p-6 rounded-2xl bg-white/5 border border-white/10 text-center">
                 <div class="w-12 h-12 rounded-full bg-gray-800 text-gray-400 flex items-center justify-center mx-auto mb-4 font-bold text-xl">3</div>
                <h3 class="text-white font-bold mb-2">Manual Code</h3>
                <p class="text-xs text-gray-400 mb-4">Paste into Console (F12) if all else fails.</p>
                <div class="relative">
                    <input type="text" readonly value="(function(){var s=document.createElement('script');s.src='http://127.0.0.1:8000/js/scraper.js';document.body.appendChild(s);})();" 
                           class="w-full bg-black border border-white/10 rounded-lg px-3 py-2 text-[10px] text-gray-500 font-mono mb-2">
                    <button onclick="navigator.clipboard.writeText(this.previousElementSibling.value); this.innerText = 'Copied!';" 
                            class="w-full py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold transition">
                        Copy Snippet
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
