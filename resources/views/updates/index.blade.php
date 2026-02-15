<x-app-layout>
    <div class="py-12 bg-[#050810] min-h-screen text-gray-200">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">What's New</h1>
                <p class="text-gray-400">Verify the latest updates, transparently.</p>
            </div>

            <div class="relative border-l border-gray-800 ml-4 md:ml-0 space-y-12">
                @foreach($updates as $update)
                    <div class="mb-10 ml-8 relative group">
                        <!-- Timeline Dot -->
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-900 rounded-full -left-11 ring-8 ring-[#050810] group-hover:bg-blue-600 transition">
                            <svg class="w-3 h-3 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>

                        <!-- Content Card -->
                        <div class="bg-gray-900/50 backdrop-blur border border-gray-800 rounded-lg p-6 shadow-xl hover:border-blue-900/50 transition duration-300">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                                <h3 class="flex items-center text-xl font-bold text-white">
                                    {{ $update->title }}
                                    @if($update->version)
                                        <span class="bg-blue-900/30 text-blue-400 text-xs font-medium px-2.5 py-0.5 rounded ml-3 border border-blue-900/50">{{ $update->version }}</span>
                                    @endif
                                </h3>
                                <time class="block mb-2 text-sm font-normal text-gray-500 md:mb-0">
                                    {{ $update->published_at->format('F j, Y') }}
                                </time>
                            </div>
                            
                            <div class="prose prose-invert prose-sm max-w-none text-gray-300">
                                {!! Str::markdown($update->body) !!}
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($updates->isEmpty())
                    <div class="ml-8 text-gray-500 italic">No updates published yet.</div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
