<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'ZenGravity') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|jetbrains-mono:400,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>

        <style>
            /* Custom Scrollbar Hide */
            ::-webkit-scrollbar { display: none; }
            html, body { -ms-overflow-style: none; scrollbar-width: none; }
            
            /* Typewriter Effect */
            @keyframes typing { from { width: 0 } to { width: 100% } }
            @keyframes blink-caret { from, to { border-color: transparent } 50% { border-color: #a855f7; } }
            .typewriter {
                overflow: hidden;
                white-space: nowrap;
                border-right: 4px solid #a855f7;
                animation: typing 3.5s steps(30, end), blink-caret .75s step-end infinite;
            }

            /* Glassmorphism Utilities - ADAPTIVE */
            /* Light Mode Glass */
            .glass-panel {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            /* Dark Mode Glass */
            .dark .glass-panel {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.05);
                box-shadow: none;
            }

            .glass-card {
                transition: all 0.3s ease;
                backdrop-filter: blur(16px);
            }
            /* Light Mode Card */
            .glass-card {
                background: rgba(255, 255, 255, 0.8);
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 4px 20px -5px rgba(0,0,0,0.05);
            }
            .glass-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            }
            /* Dark Mode Card */
            .dark .glass-card {
                background: linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.01) 100%);
                border: 1px solid rgba(255, 255, 255, 0.05);
                box-shadow: none;
            }
            .dark .glass-card:hover {
                background: linear-gradient(145deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.02) 100%);
                border-color: rgba(255, 255, 255, 0.1);
                box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-[#050810] dark:text-gray-200 selection:bg-purple-500 selection:text-white transition-colors duration-300">

        <!-- Navigation -->
        <nav class="fixed w-full z-50 top-0 start-0 border-b border-gray-200 dark:border-white/5 bg-white/80 dark:bg-[#050810]/80 backdrop-blur-xl transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-purple-500/20 group-hover:shadow-purple-500/40 transition duration-300">
                        Z
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-transparent dark:group-hover:bg-clip-text dark:group-hover:bg-gradient-to-r dark:group-hover:from-blue-400 dark:group-hover:to-purple-500 transition-all duration-300">
                        ZenGravity
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white transition">Modules</a>
                    <a href="#pricing" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white transition">Clearance</a>
                    
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 transition">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 011.414-1.414zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm12-1a1 1 0 100 2h1a1 1 0 100-2h-1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4.243-3.05l-.707.707a1 1 0 011.414 1.414l.707-.707a1 1 0 01-1.414-1.414z" clip-rule="evenodd"></path></svg>
                    </button>

                    @if (Route::has('login'))
                        <div class="flex items-center gap-4 ml-4">
                            @auth
                                <a href="{{ url('/app') }}" class="px-5 py-2.5 rounded-xl bg-gray-900 dark:bg-white text-white dark:text-black font-bold text-sm hover:bg-gray-800 dark:hover:bg-gray-100 transition shadow-lg shadow-gray-900/10 dark:shadow-white/5">
                                    Launch Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 dark:text-white hover:text-purple-600 dark:hover:text-purple-400 transition">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-purple-600 text-white font-bold text-sm hover:bg-purple-500 transition shadow-lg shadow-purple-600/20 hover:shadow-purple-600/40">
                                        Initialize System
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" class="md:hidden text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
            <!-- Animated Background Glow (Dark Mode Only) -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-purple-600/20 blur-[120px] rounded-full mix-blend-screen opacity-50 animate-pulse hidden dark:block"></div>
            <div class="absolute bottom-0 right-0 w-[800px] h-[800px] bg-blue-600/10 blur-[100px] rounded-full mix-blend-screen opacity-30 hidden dark:block"></div>
            
            <!-- Light Mode Background Mesh -->
            <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)] dark:hidden opacity-40"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-xs font-mono text-purple-600 dark:text-purple-400 mb-8 animate-bounce">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    SYSTEMS ONLINE: v2.0
                </div>

                <h1 class="text-5xl md:text-8xl font-black text-gray-900 dark:text-white tracking-tight leading-tight mb-8">
                    Elevate Your <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-500 dark:to-pink-500 typewriter inline-block pb-2">
                        Digital Sovereignty
                    </span>
                </h1>

                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                    The ultimate command center for modern creators. Harness AI-powered compliance tools, find your synthetic twin, and scout niche trends in real-time.
                </p>

                <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full md:w-auto px-8 py-4 rounded-2xl bg-gray-900 dark:bg-white text-white dark:text-black font-bold text-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition shadow-xl shadow-gray-900/10 dark:shadow-white/10 hover:scale-105 transform duration-200">
                        Start Free Trial 🚀
                    </a>
                    <a href="#features" class="w-full md:w-auto px-8 py-4 rounded-2xl bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-white font-bold text-lg hover:bg-gray-50 dark:hover:bg-white/10 transition backdrop-blur-md">
                        Explore Modules
                    </a>
                </div>

                <!-- Trusted By / Metrics -->
                <div class="mt-20 pt-10 border-t border-gray-200 dark:border-white/5 grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <div class="text-3xl font-black text-gray-900 dark:text-white mb-1">10k+</div>
                        <div class="text-xs uppercase tracking-wider text-gray-500">Scans Conducted</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-gray-900 dark:text-white mb-1">99.9%</div>
                        <div class="text-xs uppercase tracking-wider text-gray-500">Uptime</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-gray-900 dark:text-white mb-1">24/7</div>
                        <div class="text-xs uppercase tracking-wider text-gray-500">AI Monitoring</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-gray-900 dark:text-white mb-1">IPv6</div>
                        <div class="text-xs uppercase tracking-wider text-gray-500">Ready</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Grid -->
        <section id="features" class="py-32 relative bg-white dark:bg-[#060912] transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-6">Operational Modules</h2>
                    <p class="text-gray-600 dark:text-gray-400 max-w-xl mx-auto">Three powerful engines designed to accelerate your workflow and protect your digital assets.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Ghost Scanner -->
                    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                        <!-- Dark Mode Glow -->
                        <div class="hidden dark:block absolute -right-10 -top-10 w-40 h-40 bg-purple-600/20 blur-[60px] rounded-full group-hover:bg-purple-600/30 transition duration-500"></div>
                        
                        <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center text-purple-600 dark:text-purple-400 mb-8 border border-purple-200 dark:border-purple-500/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Ghost Scanner</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-8">AI-powered compliance checks. Scan your creative assets against millions of data points to ensure originality and safety.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Deep Web Analysis
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Instant Risk Score
                            </li>
                        </ul>
                    </div>

                    <!-- Collab Forge -->
                    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                        <div class="hidden dark:block absolute -right-10 -top-10 w-40 h-40 bg-blue-600/20 blur-[60px] rounded-full group-hover:bg-blue-600/30 transition duration-500"></div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-8 border border-blue-200 dark:border-blue-500/20">
                           <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Collab Forge</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-8">Find your perfect synthetic twin. Our matching algorithm connects you with creators who complement your skill set.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Skill Matching
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Portfolio Sync
                            </li>
                        </ul>
                    </div>

                    <!-- Hive Scout -->
                    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                        <div class="hidden dark:block absolute -right-10 -top-10 w-40 h-40 bg-amber-600/20 blur-[60px] rounded-full group-hover:bg-amber-600/30 transition duration-500"></div>
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400 mb-8 border border-amber-200 dark:border-amber-500/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Hive Scout</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-8">Real-time niche trend intelligence. Discover rising waves before they break and capitalize on early mover advantage.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Trend Forecasting
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Niche Analysis
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-32 relative bg-gray-50 dark:bg-[#050810] transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-6">
                 <div class="text-center mb-20">
                    <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-6">Clearance Levels</h2>
                    <p class="text-gray-600 dark:text-gray-400 max-w-xl mx-auto">Choose your access tier. Upgrade at any time.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Scout Tier -->
                    <div class="glass-panel p-10 rounded-3xl flex flex-col">
                        <div class="mb-8">
                            <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Scout</span>
                            <div class="mt-4 flex items-baseline gap-2">
                                <span class="text-5xl font-black text-gray-900 dark:text-white">Free</span>
                                <span class="text-gray-500">/ forever</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mt-4 text-sm">Perfect for testing the waters and occasional scans.</p>
                        </div>
                        <ul class="space-y-4 mb-10 flex-1">
                            <li class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>7-Day Unlimited Trial</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>15 Daily Tokens (after trial)</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Basic Support</span>
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full py-4 rounded-xl border border-gray-300 dark:border-white/10 text-gray-900 dark:text-white font-bold text-center hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            Create Account
                        </a>
                    </div>

                    <!-- Commander Tier -->
                    <div class="glass-card p-10 rounded-3xl border border-purple-200 dark:border-purple-500/30 relative flex flex-col shadow-2xl shadow-purple-500/10 dark:shadow-purple-900/20">
                        <div class="absolute top-0 right-0 bg-gradient-to-l from-purple-600 to-blue-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-bl-xl rounded-tr-2xl uppercase tracking-widest">
                            Recommended
                        </div>
                        <div class="mb-8">
                            <span class="px-3 py-1 rounded-full bg-purple-50 dark:bg-purple-500/10 text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-widest border border-purple-100 dark:border-purple-500/20">Commander</span>
                            <div class="mt-4 flex items-baseline gap-2">
                                <span class="text-5xl font-black text-gray-900 dark:text-white">$29</span>
                                <span class="text-gray-500">/ month</span>
                            </div>
                             <p class="text-purple-900/60 dark:text-purple-200/60 mt-4 text-sm">Full power. No restrictions. Total sovereignty.</p>
                        </div>
                        <ul class="space-y-4 mb-10 flex-1">
                             <li class="flex items-center gap-3 text-gray-900 dark:text-white">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Unlimited</strong> Tokens</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-900 dark:text-white">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Priority Processing</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-900 dark:text-white">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Early Access to New Features</span>
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full py-4 rounded-xl bg-gray-900 dark:bg-white text-white dark:text-black font-bold text-center hover:bg-gray-800 dark:hover:bg-gray-100 transition shadow-lg shadow-gray-900/10 dark:shadow-white/10 relative overflow-hidden group">
                           <span class="relative z-10">Get Started</span>
                           <div class="absolute inset-0 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 opacity-0 group-hover:opacity-10 transition duration-300"></div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-gray-200 dark:border-white/5 bg-white dark:bg-[#030408] py-12 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3 opacity-50 hover:opacity-100 transition">
                     <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-white/10 flex items-center justify-center text-gray-900 dark:text-white font-bold">Z</div>
                     <span class="text-sm font-medium text-gray-500 dark:text-gray-400">ZenGravity &copy; {{ date('Y') }}</span>
                </div>
                <div class="flex gap-8 text-sm text-gray-500">
                    <a href="#" class="hover:text-black dark:hover:text-white transition">Privacy Protocol</a>
                    <a href="#" class="hover:text-black dark:hover:text-white transition">Terms of Service</a>
                    <a href="#" class="hover:text-black dark:hover:text-white transition">Contact Command</a>
                </div>
            </div>
        </footer>

        @livewireScripts
        <script>
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Change the icons inside the button based on previous settings
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            var themeToggleBtn = document.getElementById('theme-toggle');

            themeToggleBtn.addEventListener('click', function() {
                // toggle icons inside button
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // if set via local storage previously
                if (localStorage.theme === 'dark') {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
            });
        </script>
    </body>
</html>
        <title>{{ config('app.name', 'ZenGravity') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|jetbrains-mono:400,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            /* Custom Scrollbar Hide */
            ::-webkit-scrollbar { display: none; }
            html, body { -ms-overflow-style: none; scrollbar-width: none; }
            
            /* Typewriter Effect */
            @keyframes typing { from { width: 0 } to { width: 100% } }
            @keyframes blink-caret { from, to { border-color: transparent } 50% { border-color: #a855f7; } }
            .typewriter {
                overflow: hidden;
                white-space: nowrap;
                border-right: 4px solid #a855f7;
                animation: typing 3.5s steps(30, end), blink-caret .75s step-end infinite;
            }

            /* Glassmorphism Utilities */
            .glass-panel {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            .glass-card {
                background: linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.01) 100%);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.05);
                transition: all 0.3s ease;
            }
            .glass-card:hover {
                background: linear-gradient(145deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.02) 100%);
                border-color: rgba(255, 255, 255, 0.1);
                transform: translateY(-5px);
                box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#050810] text-gray-200 selection:bg-purple-500 selection:text-white">

        <!-- Navigation -->
        <nav class="fixed w-full z-50 top-0 start-0 border-b border-white/5 bg-[#050810]/80 backdrop-blur-xl">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-purple-500/20 group-hover:shadow-purple-500/40 transition duration-300">
                        Z
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-blue-400 group-hover:to-purple-500 transition-all duration-300">
                        ZenGravity
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-medium text-gray-400 hover:text-white transition">Modules</a>
                    <a href="#pricing" class="text-sm font-medium text-gray-400 hover:text-white transition">Clearance</a>
                    
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4 ml-4">
                            @auth
                                <a href="{{ url('/app') }}" class="px-5 py-2.5 rounded-xl bg-white text-black font-bold text-sm hover:bg-gray-100 transition shadow-lg shadow-white/5">
                                    Launch Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-purple-400 transition">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-purple-600 text-white font-bold text-sm hover:bg-purple-500 transition shadow-lg shadow-purple-600/20 hover:shadow-purple-600/40">
                                        Initialize System
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
            <!-- Animated Background Glow -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-purple-600/20 blur-[120px] rounded-full mix-blend-screen opacity-50 animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-[800px] h-[800px] bg-blue-600/10 blur-[100px] rounded-full mix-blend-screen opacity-30"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-mono text-purple-400 mb-8 animate-bounce">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    SYSTEMS ONLINE: v2.0
                </div>

                <h1 class="text-5xl md:text-8xl font-black text-white tracking-tight leading-tight mb-8">
                    Elevate Your <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 typewriter inline-block pb-2">
                        Digital Sovereignty
                    </span>
                </h1>

                <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                    The ultimate command center for modern creators. Harness AI-powered compliance tools, find your synthetic twin, and scout niche trends in real-time.
                </p>

                <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full md:w-auto px-8 py-4 rounded-2xl bg-white text-black font-bold text-lg hover:bg-gray-100 transition shadow-xl shadow-white/10 hover:scale-105 transform duration-200">
                        Start Free Trial 🚀
                    </a>
                    <a href="#features" class="w-full md:w-auto px-8 py-4 rounded-2xl bg-white/5 border border-white/10 text-white font-bold text-lg hover:bg-white/10 transition backdrop-blur-md">
                        Explore Modules
                    </a>
                </div>

                <!-- Trusted By / Metrics -->
                <div class="mt-20 pt-10 border-t border-white/5 grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <div class="text-3xl font-black text-white mb-1">10k+</div>
                        <div class="text-xs uppercase tracking-wider text-gray-500">Scans Conducted</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-white mb-1">99.9%</div>
                        <div class="text-xs uppercase tracking-wider text-gray-500">Uptime</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-white mb-1">24/7</div>
                        <div class="text-xs uppercase tracking-wider text-gray-500">AI Monitoring</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-white mb-1">IPv6</div>
                        <div class="text-xs uppercase tracking-wider text-gray-500">Ready</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Grid -->
        <section id="features" class="py-32 relative bg-[#060912]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Operational Modules</h2>
                    <p class="text-gray-400 max-w-xl mx-auto">Three powerful engines designed to accelerate your workflow and protect your digital assets.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Ghost Scanner -->
                    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-purple-600/20 blur-[60px] rounded-full group-hover:bg-purple-600/30 transition duration-500"></div>
                        <div class="w-14 h-14 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-400 mb-8 border border-purple-500/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Ghost Scanner</h3>
                        <p class="text-gray-400 leading-relaxed mb-8">AI-powered compliance checks. Scan your creative assets against millions of data points to ensure originality and safety.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Deep Web Analysis
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Instant Risk Score
                            </li>
                        </ul>
                    </div>

                    <!-- Collab Forge -->
                    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-600/20 blur-[60px] rounded-full group-hover:bg-blue-600/30 transition duration-500"></div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 mb-8 border border-blue-500/20">
                           <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Collab Forge</h3>
                        <p class="text-gray-400 leading-relaxed mb-8">Find your perfect synthetic twin. Our matching algorithm connects you with creators who complement your skill set.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Skill Matching
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Portfolio Sync
                            </li>
                        </ul>
                    </div>

                    <!-- Hive Scout -->
                    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-600/20 blur-[60px] rounded-full group-hover:bg-amber-600/30 transition duration-500"></div>
                        <div class="w-14 h-14 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-400 mb-8 border border-amber-500/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Hive Scout</h3>
                        <p class="text-gray-400 leading-relaxed mb-8">Real-time niche trend intelligence. Discover rising waves before they break and capitalize on early mover advantage.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Trend Forecasting
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Niche Analysis
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-32 relative">
            <div class="max-w-7xl mx-auto px-6">
                 <div class="text-center mb-20">
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Clearance Levels</h2>
                    <p class="text-gray-400 max-w-xl mx-auto">Choose your access tier. Upgrade at any time.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Scout Tier -->
                    <div class="glass-panel p-10 rounded-3xl border border-white/5 flex flex-col">
                        <div class="mb-8">
                            <span class="px-3 py-1 rounded-full bg-white/5 text-xs font-bold text-gray-400 uppercase tracking-widest">Scout</span>
                            <div class="mt-4 flex items-baseline gap-2">
                                <span class="text-5xl font-black text-white">Free</span>
                                <span class="text-gray-500">/ forever</span>
                            </div>
                            <p class="text-gray-400 mt-4 text-sm">Perfect for testing the waters and occasional scans.</p>
                        </div>
                        <ul class="space-y-4 mb-10 flex-1">
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>7-Day Unlimited Trial</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>15 Daily Tokens (after trial)</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Basic Support</span>
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full py-4 rounded-xl border border-white/10 text-white font-bold text-center hover:bg-white/5 transition">
                            Create Account
                        </a>
                    </div>

                    <!-- Commander Tier -->
                    <div class="glass-card p-10 rounded-3xl border border-purple-500/30 relative flex flex-col shadow-2xl shadow-purple-900/20">
                        <div class="absolute top-0 right-0 bg-gradient-to-l from-purple-600 to-blue-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-bl-xl rounded-tr-2xl uppercase tracking-widest">
                            Recommended
                        </div>
                        <div class="mb-8">
                            <span class="px-3 py-1 rounded-full bg-purple-500/10 text-xs font-bold text-purple-400 uppercase tracking-widest border border-purple-500/20">Commander</span>
                            <div class="mt-4 flex items-baseline gap-2">
                                <span class="text-5xl font-black text-white">$29</span>
                                <span class="text-gray-500">/ month</span>
                            </div>
                             <p class="text-purple-200/60 mt-4 text-sm">Full power. No restrictions. Total sovereignty.</p>
                        </div>
                        <ul class="space-y-4 mb-10 flex-1">
                             <li class="flex items-center gap-3 text-white">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Unlimited</strong> Tokens</span>
                            </li>
                            <li class="flex items-center gap-3 text-white">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Priority Processing</span>
                            </li>
                            <li class="flex items-center gap-3 text-white">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Early Access to New Features</span>
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full py-4 rounded-xl bg-white text-black font-bold text-center hover:bg-gray-100 transition shadow-lg shadow-white/10 relative overflow-hidden group">
                           <span class="relative z-10">Get Started</span>
                           <div class="absolute inset-0 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 opacity-0 group-hover:opacity-10 transition duration-300"></div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-white/5 bg-[#030408] py-12">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3 opacity-50 hover:opacity-100 transition">
                     <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white font-bold">Z</div>
                     <span class="text-sm font-medium text-gray-400">ZenGravity &copy; {{ date('Y') }}</span>
                </div>
                <div class="flex gap-8 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition">Privacy Protocol</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                    <a href="#" class="hover:text-white transition">Contact Command</a>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
