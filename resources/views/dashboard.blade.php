    <x-app-layout>
        <div class="min-h-full py-6 md:py-12 px-4 sm:px-6 lg:px-8 bg-black">
            <div class="max-w-5xl mx-auto space-y-12">
                
                <div class="space-y-2">
                    <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">
                        Hi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">{{ explode(' ', Auth::user()->name)[0] }}</span>,
                    </h1>
                    <p class="text-lg md:text-xl text-gray-500 font-medium">
                        Welcome back to the Command Center.
                    </p>
                </div>

                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-[32px] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative bg-[#0a0a0a] border border-white/5 rounded-[32px] p-8 md:p-12 overflow-hidden shadow-2xl backdrop-blur-xl">
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-blue-600/10 rounded-full blur-[100px]"></div>
                        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-purple-600/10 rounded-full blur-[100px]"></div>

                        <div class="relative flex flex-col md:flex-row items-center gap-10">
                            <div class="w-24 h-24 md:w-32 md:h-32 bg-white/5 rounded-3xl flex items-center justify-center p-6 border border-white/10 shadow-inner group-hover:scale-105 transition duration-500">
                                <svg class="w-full h-full text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                                </svg>
                            </div>

                            <div class="flex-1 text-center md:text-left space-y-4">
                                <div>
                                    <h2 class="text-2xl md:text-3xl font-black text-white tracking-tighter uppercase">Ghost Scanner</h2>
                                    <p class="text-sm md:text-base text-gray-400 font-medium max-w-md mx-auto md:mx-0">
                                        AI-powered compliance and integrity check for your digital masterpieces.
                                    </p>
                                </div>

                                <form x-data="ghostScanner()" 
                                @submit.prevent="handleScan" 
                                enctype="multipart/form-data" 
                                class="pt-4 flex flex-col gap-5">

                                    <!-- Upload Dropzone -->
                                    <label class="relative flex-1 min-w-[240px] rounded-2xl flex items-center justify-center gap-3 cursor-pointer transition-all duration-500 group/upload overflow-hidden"
                                           :class="hasFile 
                                               ? 'h-auto p-0 border-2 border-emerald-500/40 bg-emerald-500/5' 
                                               : 'h-16 bg-white/5 hover:bg-white/10 border-2 border-dashed border-white/15 hover:border-blue-500/50'">
                                        
                                        <input type="file" name="media" class="hidden" @change="updateFile($event)">
                                        
                                        <!-- Empty State -->
                                        <div x-show="!hasFile" class="flex items-center gap-3 py-1">
                                            <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center group-hover/upload:bg-blue-500/20 transition-colors duration-300">
                                                <svg class="w-5 h-5 text-gray-500 group-hover/upload:text-blue-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-sm font-bold text-gray-300 group-hover/upload:text-white transition block">Drop file or click to upload</span>
                                                <span class="text-[11px] text-gray-600">Images, videos, audio, documents — up to 15GB</span>
                                            </div>
                                        </div>

                                        <!-- File Selected State (Preview Card) -->
                                        <div x-show="hasFile" class="w-full p-4 flex items-center gap-4" style="display:none;" x-transition>
                                            <!-- File Type Icon -->
                                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-500/20">
                                                <template x-if="fileType === 'image'">
                                                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </template>
                                                <template x-if="fileType === 'video'">
                                                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                </template>
                                                <template x-if="fileType === 'audio'">
                                                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                                </template>
                                                <template x-if="fileType === 'other'">
                                                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </template>
                                            </div>

                                            <!-- File Info -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-white truncate" x-text="fileName"></p>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <span class="text-[11px] text-emerald-400 font-bold uppercase tracking-wider bg-emerald-500/10 px-2 py-0.5 rounded-full" x-text="fileExt"></span>
                                                    <span class="text-[11px] text-gray-500" x-text="fileSize"></span>
                                                </div>
                                                <p class="text-[11px] text-emerald-400 font-semibold mt-1.5 flex items-center gap-1">
                                                    <span>✅</span> File selected — Ready to scan
                                                </p>
                                            </div>

                                            <!-- Remove Button -->
                                            <button type="button" @click.prevent="resetFile()" class="w-8 h-8 rounded-full bg-white/5 hover:bg-red-500/20 flex items-center justify-center transition-all duration-300 group/remove shrink-0">
                                                <svg class="w-4 h-4 text-gray-500 group-hover/remove:text-red-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </label>

                                    <!-- Scan Button -->
                                    <div class="flex flex-col gap-2">
                                        <button type="submit" 
                                                :disabled="!hasFile || uploading"
                                                class="w-full h-14 rounded-2xl font-bold transition-all duration-500 flex items-center justify-center gap-3 group/btn relative overflow-hidden"
                                                :class="!hasFile 
                                                    ? 'bg-gray-800/60 border border-white/10 cursor-not-allowed opacity-50' 
                                                    : (uploading 
                                                        ? 'bg-gray-800 border border-white/10' 
                                                        : 'bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/50 hover:scale-[1.03] border border-emerald-400/30')">
                                            
                                            <!-- Shimmer sweep on hover -->
                                            <div x-show="hasFile && !uploading" 
                                                 class="absolute inset-0 bg-gradient-to-r from-transparent via-white/15 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700" 
                                                 style="display:none;"></div>

                                            <!-- Default / Ready Label -->
                                            <div class="relative flex items-center gap-3" x-show="!uploading">
                                                <svg class="w-5 h-5" :class="hasFile ? 'text-white' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                                <span class="text-sm font-bold" :class="hasFile ? 'text-white' : 'text-gray-400'">Run Scan</span>
                                                <svg x-show="hasFile" class="w-4 h-4 text-white/70 transition-transform duration-300 group-hover/btn:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </div>
                                            
                                            <!-- Uploading State -->
                                            <div class="flex items-center gap-3" x-show="uploading" style="display: none;">
                                                <svg class="animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span class="text-sm text-white font-bold">Analyzing...</span>
                                            </div>
                                        </button>
                                        <p x-show="errorMessage" x-text="errorMessage" class="text-red-400 text-xs font-bold text-center" style="display: none;"></p>
                                    </div>
                                </form>
        
                                <script>
                                    document.addEventListener('alpine:init', () => {
                                        Alpine.data('ghostScanner', () => ({
                                            hasFile: false,
                                            fileName: '',
                                            fileSize: '',
                                            fileExt: '',
                                            fileType: 'other',
                                            uploading: false,
                                            errorMessage: '',
                                            file: null, // Store the actual File object
                                
                                            updateFile(event) {
                                                const file = event.target.files[0];
                                                if (!file) return;

                                                // Client-side size check (15GB)
                                                const maxSize = 15 * 1024 * 1024 * 1024;
                                                if (file.size > maxSize) {
                                                    this.errorMessage = 'File exceeds the 15GB limit.';
                                                    event.target.value = '';
                                                    return;
                                                }

                                                // Store file reference
                                                this.file = file;
                                                this.hasFile = true;
                                                this.fileName = file.name;
                                                this.errorMessage = '';

                                                // File size formatting
                                                if (file.size < 1024) this.fileSize = file.size + ' B';
                                                else if (file.size < 1048576) this.fileSize = (file.size / 1024).toFixed(1) + ' KB';
                                                else if (file.size < 1073741824) this.fileSize = (file.size / 1048576).toFixed(1) + ' MB';
                                                else this.fileSize = (file.size / 1073741824).toFixed(2) + ' GB';

                                                // Extension
                                                const ext = file.name.split('.').pop().toLowerCase();
                                                this.fileExt = ext;

                                                // Type detection
                                                if (['jpg','jpeg','png','gif','webp','svg','bmp','tiff','ico'].includes(ext)) this.fileType = 'image';
                                                else if (['mp4','mov','avi','mkv','webm','flv','wmv'].includes(ext)) this.fileType = 'video';
                                                else if (['mp3','wav','ogg','flac','aac','wma'].includes(ext)) this.fileType = 'audio';
                                                else this.fileType = 'other';
                                            },

                                            resetFile() {
                                                this.hasFile = false;
                                                this.fileName = '';
                                                this.fileSize = '';
                                                this.fileExt = '';
                                                this.fileType = 'other';
                                                this.file = null;
                                                this.errorMessage = '';
                                                const input = this.$el.querySelector('input[type=file]');
                                                if (input) input.value = '';
                                            },

                                            handleScan() {
                                                if (!this.file || this.uploading) return;

                                                this.uploading = true;
                                                this.errorMessage = '';

                                                // Build FormData manually with stored file
                                                const formData = new FormData();
                                                formData.append('media', this.file);

                                                fetch('{{ route("scan.upload") }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Accept': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: formData
                                                })
                                                .then(async response => {
                                                    const data = await response.json();
                                                    if (!response.ok) {
                                                        // Handle validation errors
                                                        if (data.errors) {
                                                            const firstError = Object.values(data.errors)[0];
                                                            throw new Error(Array.isArray(firstError) ? firstError[0] : firstError);
                                                        }
                                                        throw new Error(data.message || 'Upload failed');
                                                    }
                                                    return data;
                                                })
                                                .then(data => {
                                                    if (data.redirect) {
                                                        window.location.href = data.redirect;
                                                    } else {
                                                        this.errorMessage = 'Scan complete!';
                                                        this.uploading = false;
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Scan Error:', error);
                                                    this.errorMessage = error.message || 'An error occurred during the scan.';
                                                    this.uploading = false;
                                                });
                                            }
                                        }))
                                    })
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('collab.matches') }}" class="group relative">
                        <div class="absolute inset-0 bg-purple-600/20 rounded-3xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        <div class="relative bg-white/5 border border-white/10 p-8 rounded-3xl hover:border-purple-500/30 transition duration-300">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Collab Forge</h3>
                            <p class="text-sm text-gray-500 leading-relaxed font-medium">Find your perfect synthetic twin match.</p>
                        </div>
                    </a>

                    <a href="{{ route('hive.index') }}" class="group relative">
                        <div class="absolute inset-0 bg-amber-600/20 rounded-3xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        <div class="relative bg-white/5 border border-white/10 p-8 rounded-3xl hover:border-amber-500/30 transition duration-300">
                            <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Hive Scout</h3>
                            <p class="text-sm text-gray-500 leading-relaxed font-medium">Real-time niche trend intelligence.</p>
                        </div>
                    </a>

                    <a href="{{ route('scans.index') }}" class="group relative lg:col-span-1">
                        <div class="absolute inset-0 bg-green-600/20 rounded-3xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        <div class="relative bg-white/5 border border-white/10 p-8 rounded-3xl hover:border-green-500/30 transition duration-300 h-full">
                            <div class="w-12 h-12 bg-green-500/10 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Audit History</h3>
                            <p class="text-sm text-gray-500 leading-relaxed font-medium">Review your past compliance tests.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </x-app-layout>