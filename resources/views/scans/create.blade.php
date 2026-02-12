<x-app-layout>
    <div class="py-12" x-data="{ fileName: null, isLoading: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0D1117] border border-white/10 overflow-hidden shadow-2xl sm:rounded-3xl relative">
                <!-- Background Glow -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>

                <div class="p-8 relative z-10 text-gray-100">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center border border-blue-500/30">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Ghost Scanner</h3>
                            <p class="text-xs text-gray-400 uppercase tracking-widest">AI-Powered Safety & Shadowban Analysis</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('scans.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" @submit="isLoading = true">
                        @csrf
                        
                        <div>
                            <div class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-dashed border-white/10 rounded-2xl hover:border-blue-500/50 hover:bg-white/5 transition duration-300 group cursor-pointer relative">
                                <input id="image" name="image" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" required accept="image/*" @change="fileName = $event.target.files[0].name">
                                
                                <div class="space-y-4 text-center z-10">
                                    <div class="w-20 h-20 mx-auto bg-gray-800 rounded-full flex items-center justify-center group-hover:scale-110 transition duration-300">
                                        <svg x-show="!fileName" class="h-10 w-10 text-gray-400 group-hover:text-blue-400 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <svg x-show="fileName" class="h-10 w-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    
                                    <div class="text-sm text-gray-400">
                                        <span x-show="!fileName" class="font-bold text-blue-400">Upload a file</span>
                                        <span x-show="!fileName">or drag and drop</span>
                                        <p x-show="fileName" class="text-lg font-bold text-white mt-2" x-text="fileName"></p>
                                        <p x-show="fileName" class="text-green-400 text-xs uppercase tracking-widest mt-1">Ready to Scan</p>
                                    </div>
                                    <p class="text-xs text-gray-600 uppercase tracking-widest">
                                        PNG, JPG, GIF up to 10MB
                                    </p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-400 font-bold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="relative group w-full sm:w-auto overflow-hidden rounded-xl bg-blue-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg transition-all hover:bg-blue-500 hover:shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="isLoading">
                                <span class="relative flex items-center justify-center space-x-2">
                                    <svg x-show="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" x-cloak>
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-text="isLoading ? 'Analyzing Integrity...' : 'Run Ghost Scan'"></span>
                                    <svg x-show="!isLoading" class="w-5 h-5 ml-2 -mr-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
