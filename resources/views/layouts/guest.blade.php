<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-black text-white antialiased selection:bg-blue-500/30 font-['Instrument_Sans']">
        <div class="min-h-screen flex flex-col lg:flex-row overflow-hidden relative">
            
            <!-- Left Side: Auth Forms -->
            <div class="w-full lg:w-[450px] shrink-0 bg-[#070707] border-r border-white/5 relative z-20 flex flex-col shadow-2xl">
                <!-- Branding Header -->
                <div class="p-8 pb-0">
                    <a href="/" class="group">
                        <span class="text-3xl font-black text-white tracking-tighter uppercase transition-all duration-300 group-hover:opacity-80 flex items-center gap-1" 
                              style="text-shadow: -1.5px -0.5px 0 rgba(255, 0, 0, 0.4), 1.5px 0.5px 0 rgba(0, 255, 255, 0.4);">
                            ZEN<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 typewriter inline-block overflow-hidden whitespace-nowrap border-r-2 border-purple-500/50 pr-1">GRAVITY</span>
                        </span>
                    </a>
                </div>

                <!-- Form Container -->
                <div class="flex-1 flex flex-col justify-center px-8 lg:px-12 py-12">
                    <div class="w-full max-w-sm mx-auto">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-8 text-xs text-gray-600 font-medium">
                    &copy; {{ date('Y') }} ZenGravity. System Online.
                </div>
            </div>

            <!-- Right Side: Feature Showcase -->
            <div class="hidden lg:flex flex-1 relative bg-black items-center justify-center overflow-hidden">
                <!-- Ambient Background Effects -->
                <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-600/10 rounded-full blur-[150px] -mr-96 -mt-96 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-purple-600/10 rounded-full blur-[120px] -ml-48 -mb-48"></div>
                
                <!-- Grid Pattern Overlay -->
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>

                <!-- Dynamic Content Slot for Features -->
                <div class="relative z-10 w-full max-w-2xl px-12">
                    @yield('feature_showcase')
                </div>

                <!-- Floating Decor Elements -->
                <div class="absolute top-20 right-20 w-32 h-32 border border-white/5 rounded-full animate-spin-slow"></div>
                <div class="absolute bottom-40 right-40 w-16 h-16 border border-white/5 rotate-45"></div>
            </div>

            <!-- Ambient Glow for Mobile (at bottom) -->
            <div class="lg:hidden absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-blue-500/10 to-transparent pointer-events-none"></div>
        </div>

        <style>
            /* Hide scrollbar for Chrome, Safari and Opera */
            ::-webkit-scrollbar {
                display: none;
            }

            /* Hide scrollbar for IE, Edge and Firefox */
            html, body {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }

            @keyframes spin-slow {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .animate-spin-slow {
                animation: spin-slow 20s linear infinite;
            }
            
            @keyframes typing {
                from { width: 0 }
                to { width: 100% }
            }
            @keyframes blink-caret {
                from, to { border-color: transparent }
                50% { border-color: #a855f7; }
            }
            .typewriter {
                animation: 
                    typing 3s cubic-bezier(0.4, 0, 0.2, 1) forwards,
                    blink-caret .75s step-end infinite;
            }
        </style>
    </body>
</html>
