<x-app-layout>
    <!-- Main Content Wrapper -->
    <div class="h-screen bg-[#050810] text-white font-sans flex flex-col relative z-0" x-data="examDashboard()">
    
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('examDashboard', () => ({
                    questions: [],
                    activeQuestion: null,
                    confidence: 0,
                    
                    // Input & Portal State
                    inputUrl: localStorage.getItem('zenith_portal_url') || '',
                    portalUrl: localStorage.getItem('zenith_portal_url') || '',
                    useProxy: localStorage.getItem('zenith_use_proxy') === 'true',
                    iframeLoading: false,
                    
                    sidebarOpen: false, 
                    isConnected: false,

                    loadPortal() {
                        if(!this.inputUrl) return;
                        
                        this.iframeLoading = true; // Start loading functionality
                        
                        let url = this.inputUrl.trim();
                        if (!/^https?:\/\//i.test(url) && !this.useProxy) {
                            url = 'https://' + url;
                        }

                        // Save raw input for next time
                        localStorage.setItem('zenith_portal_url', url);
                        this.inputUrl = url;

                        if(this.useProxy) {
                            // secure proxy url encoding
                            this.portalUrl = '/proxy?url=' + encodeURIComponent(url);
                        } else {
                            this.portalUrl = url;
                        }
                        
                        localStorage.setItem('zenith_use_proxy', this.useProxy);
                    },

                    init() {
                        // Extension Handshake & Proxy Events
                        window.addEventListener('message', (event) => {
                            if (!event.data) return;
                            
                            if (event.data.type === 'ZENITH_CONNECTED') {
                                if(!this.isConnected) {
                                    this.isConnected = true;
                                    if(Alpine.store('modalState')) Alpine.store('modalState').isOpen = false;
                                    
                                    this.showToast('✅ EXTENSION DETECTED');
                                }
                            }
                            
                            if (event.data.type === 'ZENITH_PROXY_LOADING') {
                                this.iframeLoading = true;
                            }
                        });

                        // Ping Loop
                        setInterval(() => {
                            if(!this.isConnected) {
                                window.postMessage({ type: 'ZENITH_PING' }, '*');
                                const frame = this.$refs.portalFrame;
                                if(frame && frame.contentWindow) {
                                    frame.contentWindow.postMessage({ type: 'ZENITH_PING' }, '*');
                                }
                            }
                        }, 1000);

                        // Simulated Feed
                        setInterval(() => {
                            if(this.questions.length < 5) {
                                this.questions.unshift({
                                    id: Date.now(),
                                    text: 'Explain the concept of ' + ['Quantum Entanglement', 'Neoliberalism', 'Photosynthesis', 'Game Theory'][Math.floor(Math.random()*4)],
                                    status: 'pending'
                                });
                            }
                        }, 5000);
                        
                        if(this.portalUrl) {
                            this.$nextTick(() => { this.loadPortal(); });
                        }
                    },

                    solve(q) {
                        this.activeQuestion = q;
                        this.confidence = 0;
                        
                        fetch('/api/exam/solve', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ question: q.text })
                        })
                        .then(res => res.json())
                        .then(data => {
                            q.status = 'solved';
                            q.answer = data.answer;
                            this.confidence = data.confidence;
                        });
                    },
                    
                    showToast(msg) {
                        const toast = document.createElement('div');
                        toast.innerText = msg;
                        toast.className = 'fixed bottom-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg font-bold shadow-2xl z-[99999] animate-bounce';
                        document.body.appendChild(toast);
                        setTimeout(() => toast.remove(), 3000);
                    }
                }));
            });
        </script>
    
        <!-- Background Glows -->
        <div class="fixed top-0 left-0 w-[500px] h-[500px] bg-cyan-500/10 blur-[100px] rounded-full mix-blend-screen pointer-events-none z-[-1]"></div>
        <div class="fixed bottom-0 right-0 w-[500px] h-[500px] bg-blue-600/10 blur-[100px] rounded-full mix-blend-screen pointer-events-none z-[-1]"></div>

        <!-- App Header (Minimal) -->
        <div class="relative z-50 h-14 border-b border-white/10 bg-[#050810]/90 backdrop-blur flex items-center justify-between px-4 shrink-0">
            <div class="flex items-center gap-3">
                 <h1 class="text-sm font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Zenith Academy
                </h1>
                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">SPLIT VIEW</span>
            </div>

            <div class="flex items-center gap-3">
                <button x-show="!isConnected" 
                        @click="injectSidekick()" 
                        class="px-2.5 py-1 rounded-lg bg-cyan-900/20 border border-cyan-500/30 text-cyan-400 text-[10px] font-bold hover:bg-cyan-500 hover:text-white transition flex items-center gap-1.5">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Connect AI
                </button>

                <div x-show="isConnected" class="flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-[10px] font-bold text-green-500">SYSTEM ACTIVE</span>
                </div>
            </div>
        </div>

        <!-- Main Split Layout -->
        <div class="flex-1 flex overflow-hidden relative z-10">
            
            <!-- LEFT COLUMN: Tools & Feed (35%) -->
            <div class="w-[35%] min-w-[320px] max-w-[450px] flex flex-col bg-[#050810] border-r border-white/10 shadow-xl z-20">
                @include('exam.partials.tools-panel')
            </div>

            <!-- RIGHT COLUMN: Browser Area (65%) -->
            <div class="flex-1 flex flex-col bg-[#0a0a0c] relative z-0">
                
                <!-- Persistent Address Bar -->
                <div class="h-12 border-b border-white/5 flex items-center px-4 gap-3 bg-[#080b14]">
                    <!-- Navigation Controls -->
                    <div class="flex gap-2 text-gray-500">
                        <button class="hover:text-white transition p-1 hover:bg-white/5 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                        <button class="hover:text-white transition p-1 hover:bg-white/5 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                        <button @click="loadPortal()" class="hover:text-white transition p-1 hover:bg-white/5 rounded"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg></button>
                    </div>

                    <!-- URL Input -->
                    <div class="flex-1 relative group flex items-center gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-600 group-focus-within:text-cyan-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.85.59-4.17M5.38 2.62A8.1 8.1 0 0110.154 2m6.226.78a8.1 8.1 0 013.968 2.45"></path></svg>
                            </div>
                            <input type="text" 
                                   x-model="inputUrl" 
                                   @keydown.enter="loadPortal()"
                                   class="w-full bg-[#050810] border border-white/10 rounded-md pl-9 pr-4 py-1.5 text-xs text-gray-300 placeholder-gray-600 focus:border-cyan-500/50 focus:ring-0 focus:text-white transition font-mono shadow-inner"
                                   placeholder="Enter URL (e.g., moodle.university.edu)">
                        </div>
                        
                        <!-- Proxy Toggle -->
                         <button @click="useProxy = !useProxy; loadPortal()" 
                                class="px-2 py-1.5 rounded border text-[10px] font-bold transition flex items-center gap-1 shrink-0"
                                :class="useProxy ? 'bg-amber-500/10 border-amber-500/50 text-amber-500' : 'bg-white/5 border-white/10 text-gray-500 hover:text-white'">
                            <span class="w-1.5 h-1.5 rounded-full" :class="useProxy ? 'bg-amber-500' : 'bg-gray-500'"></span>
                            <span x-text="useProxy ? 'PROXY ACTIVE' : 'DIRECT MODE'"></span>
                        </button>
                    </div>
                </div>

                <!-- Iframe Container -->
                <div class="flex-1 bg-white relative">
                    <!-- Loading Overlay -->
                    <div x-show="iframeLoading" 
                         x-transition.opacity.duration.500ms
                         class="absolute inset-0 z-50 bg-[#0a0a0c] flex flex-col items-center justify-center">
                        <div class="w-10 h-10 border-2 border-cyan-900 border-t-cyan-500 rounded-full animate-spin mb-4"></div>
                        <p class="text-cyan-500 font-bold animate-pulse text-xs tracking-widest uppercase">Establishing Secure Tunnel...</p>
                    </div>

                    <template x-if="!$store.modalState?.isOpen">
                        <iframe x-ref="portalFrame" 
                                :src="portalUrl" 
                                @load="iframeLoading = false"
                                class="w-full h-full border-0" 
                                sandbox="allow-same-origin allow-scripts allow-forms allow-popups">
                        </iframe>
                    </template>
                    
                     <!-- Empty State -->
                    <template x-if="!portalUrl || $store.modalState?.isOpen">
                        <div class="absolute inset-0 bg-[#0a0a0c] flex flex-col items-center justify-center text-center p-12">
                            <div class="w-20 h-20 rounded-full bg-cyan-900/10 flex items-center justify-center mb-6 ring-1 ring-cyan-500/20" :class="isConnected ? 'bg-green-500/10 ring-green-500/20' : ''">
                                <svg x-show="!isConnected" class="w-8 h-8 text-cyan-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                <svg x-show="isConnected" class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h2 class="text-xl font-black text-white mb-2" x-text="isConnected ? 'System Ready' : 'Searching for Extension...'"></h2>
                            <p class="text-gray-400 max-w-sm mx-auto mb-6 text-sm" x-show="!isConnected">Ensure the Zenith Sidekick extension is installed and active.</p>
                            <p class="text-green-400 max-w-md mx-auto mb-8 font-bold text-sm" x-show="isConnected">AI Bridge Established. Enter URL above to begin.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    
    @push('modals')
        <x-connect-modal />
    @endpush
</x-app-layout>
