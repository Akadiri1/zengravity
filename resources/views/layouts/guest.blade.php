<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 antialiased bg-[#050810]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#050810] relative overflow-hidden">
            
            <!-- Background Ambient Glow -->
            <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="mb-8 relative z-10">
                <a href="/" class="flex flex-col items-center group">
                    <span class="text-4xl font-black text-white tracking-tighter uppercase leading-none mb-2 transition-transform duration-300 group-hover:scale-105" 
                          style="text-shadow: -1.5px -0.5px 0 rgba(255, 0, 0, 0.5), 1.5px 0.5px 0 rgba(0, 255, 255, 0.5);">
                        ZEN<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 font-mono typewriter inline-block" style="text-shadow: none;">GRAVITY</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-[#0a0a0a] shadow-2xl overflow-hidden sm:rounded-3xl border border-white/5 relative z-10 backdrop-blur-sm">
                {{ $slot }}
            </div>
            
            <!-- Footer Links -->
            <div class="mt-8 text-center text-xs text-gray-600 relative z-10">
                &copy; {{ date('Y') }} ZenGravity. All rights reserved.
            </div>
        </div>
    </body>
</html>
