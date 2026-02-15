<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ZenGravity') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:300,400,500,600,700|jetbrains-mono:400,700" rel="stylesheet" />

    <!-- Vite + Livewire -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        :root {
            --bg: #050810;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
            --accent: #a855f7;
            --accent-dark: #7e22ce;
            --glass: rgba(255, 255, 255, 0.04);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        [data-theme="light"] {
            --bg: #f8fafc;
            --text: #0f172a;
            --text-muted: #64748b;
            --accent: #7c3aed;
            --accent-dark: #5b21b6;
            --glass: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(0, 0, 0, 0.06);
        }

        body {
            @apply bg-[var(--bg)] text-[var(--text)] transition-colors duration-500;
        }

        /* Hide scrollbar */
        ::-webkit-scrollbar { display: none; }
        html, body { -ms-overflow-style: none; scrollbar-width: none; }

        /* Typewriter */
        @keyframes typing { from { width: 0 } to { width: 100% } }
        @keyframes blink { 50% { border-color: transparent } }
        .typewriter {
            overflow: hidden;
            white-space: nowrap;
            border-right: 3px solid var(--accent);
            animation: typing 3.8s steps(38, end) forwards, blink 1s step-end infinite;
        }

        /* Glass effect */
        .glass {
            background: var(--glass);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }

        /* Card hover lift */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.3);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #60a5fa, #a855f7, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen font-['Instrument_Sans'] antialiased">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 border-b border-white/5 bg-[var(--bg)]/70 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-purple-500/30 group-hover:shadow-purple-500/50 transition-all duration-300">
                        Z
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-white group-hover:gradient-text transition-all duration-300">
                        ZenGravity
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-10">
                    <a href="#features" class="text-sm font-medium text-[var(--text-muted)] hover:text-white transition">Modules</a>
                    <a href="#pricing" class="text-sm font-medium text-[var(--text-muted)] hover:text-white transition">Pricing</a>

                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg hover:bg-white/10 transition">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 011.414-1.414zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm12-1a1 1 0 100 2h1a1 1 0 100-2h-1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4.243-3.05l-.707.707a1 1 0 011.414 1.414l.707-.707a1 1 0 01-1.414-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    @auth
                        <a href="{{ url('/app') }}" class="px-6 py-2.5 rounded-xl bg-white text-black font-semibold text-sm hover:bg-gray-100 transition shadow-lg">
                            Open Dashboard
                        </a>
                    @else
                        <div class="flex items-center gap-6">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-[var(--text-muted)] hover:text-white transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold text-sm hover:from-purple-700 hover:to-indigo-700 transition shadow-lg shadow-purple-500/20">
                                    Get Started
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-[var(--text-muted)] hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="relative min-h-screen flex items-center pt-24 pb-16 px-6 overflow-hidden">
        <!-- Background glows -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl animate-pulse-slow delay-1000"></div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-sm font-medium text-purple-400 mb-8">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                v2.0 – Systems Operational
            </div>

            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black tracking-tight leading-none mb-10">
                Command Your<br>
                <span class="gradient-text typewriter inline-block">Digital Empire</span>
            </h1>

            <p class="text-xl md:text-2xl text-[var(--text-muted)] max-w-3xl mx-auto mb-12 leading-relaxed">
                AI-powered compliance, synthetic collab matching, and real-time trend intelligence — built for creators who move fast.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-2xl shadow-purple-500/30 hover:shadow-purple-500/50 transform hover:scale-[1.03] duration-300">
                    Start Free Trial – No Card Needed
                </a>
                <a href="#features" class="w-full sm:w-auto px-10 py-5 rounded-2xl bg-white/5 border border-white/10 text-white font-bold text-lg hover:bg-white/10 transition backdrop-blur-md">
                    See How It Works
                </a>
            </div>

            <!-- Trust signals -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-black">12k+</div>
                    <div class="text-sm text-[var(--text-muted)] mt-1">Assets Scanned</div>
                </div>
                <div>
                    <div class="text-4xl font-black">99.98%</div>
                    <div class="text-sm text-[var(--text-muted)] mt-1">Uptime</div>
                </div>
                <div>
                    <div class="text-4xl font-black">24/7</div>
                    <div class="text-sm text-[var(--text-muted)] mt-1">AI Protection</div>
                </div>
                <div>
                    <div class="text-4xl font-black">Global</div>
                    <div class="text-sm text-[var(--text-muted)] mt-1">Ready</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-32 bg-[var(--bg)]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-black mb-6">Core Systems</h2>
                <p class="text-xl text-[var(--text-muted)] max-w-3xl mx-auto">
                    Three precision-engineered modules to protect, grow, and accelerate your digital presence.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Ghost Scanner -->
                <div class="glass p-10 rounded-3xl card-hover">
                    <div class="w-16 h-16 rounded-2xl bg-purple-500/10 flex items-center justify-center mb-8">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Ghost Scanner</h3>
                    <p class="text-[var(--text-muted)] mb-8 leading-relaxed">
                        Instant AI-powered compliance & integrity checks. Protect your brand from bans, deepfakes, and unsafe content.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> NSFW & Violence Detection</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Deepfake Suspicion Score</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Platform Risk Rating</li>
                    </ul>
                </div>

                <!-- Collab Forge -->
                <div class="glass p-10 rounded-3xl card-hover">
                    <div class="w-16 h-16 rounded-2xl bg-blue-500/10 flex items-center justify-center mb-8">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM6 5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Collab Forge</h3>
                    <p class="text-[var(--text-muted)] mb-8 leading-relaxed">
                        AI-driven creator matching. Find perfect collab partners based on vibe, niche, audience overlap & energy.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Vibe Compatibility Score</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> AI Outreach Scripts</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Synthetic Twin Discovery</li>
                    </ul>
                </div>

                <!-- Hive Scout -->
                <div class="glass p-10 rounded-3xl card-hover">
                    <div class="w-16 h-16 rounded-2xl bg-amber-500/10 flex items-center justify-center mb-8">
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Hive Scout</h3>
                    <p class="text-[var(--text-muted)] mb-8 leading-relaxed">
                        Real-time trend radar. Spot emerging niches, viral hooks and content pillars before everyone else.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Surge Velocity Tracking</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> AI Strategy Blueprints</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Early Mover Advantage</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="pricing" class="py-32 bg-[var(--bg)]">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-black mb-6">Choose Your Clearance Level</h2>
                <p class="text-xl text-[var(--text-muted)] max-w-3xl mx-auto">
                    Start free. Scale when you're ready. No surprises.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-10 max-w-5xl mx-auto">
                <!-- Free / Scout -->
                <div class="glass p-10 rounded-3xl flex flex-col border border-white/5">
                    <div class="mb-10">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-white/5 text-xs font-bold uppercase tracking-wider text-gray-400">Scout</span>
                        <div class="mt-6 flex items-baseline gap-2">
                            <span class="text-6xl font-black">Free</span>
                            <span class="text-2xl text-[var(--text-muted)]">forever</span>
                        </div>
                        <p class="mt-4 text-lg text-[var(--text-muted)]">Perfect for testing and light usage.</p>
                    </div>

                    <ul class="space-y-5 mb-12 flex-1 text-lg">
                        <li class="flex items-center gap-4"><svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> 30-day unlimited trial</li>
                        <li class="flex items-center gap-4"><svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> 15 tokens per day after trial</li>
                        <li class="flex items-center gap-4"><svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Community support</li>
                    </ul>

                    <a href="{{ route('register') }}" class="w-full py-5 rounded-2xl bg-white/10 border border-white/10 text-white font-bold text-lg text-center hover:bg-white/15 transition">
                        Create Free Account
                    </a>
                </div>

                <!-- Commander (Recommended) -->
                <div class="glass p-10 rounded-3xl flex flex-col border border-purple-500/30 relative shadow-2xl shadow-purple-900/20">
                    <div class="absolute -top-4 right-8 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-bold px-5 py-2 rounded-full uppercase tracking-wider shadow-lg">
                        Recommended
                    </div>

                    <div class="mb-10">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-purple-500/10 text-xs font-bold uppercase tracking-wider text-purple-300 border border-purple-500/20">Commander</span>
                        <div class="mt-6 flex items-baseline gap-2">
                            <span class="text-6xl font-black">$29</span>
                            <span class="text-2xl text-[var(--text-muted)]">/ month</span>
                        </div>
                        <p class="mt-4 text-lg text-purple-200/80">Unlimited power. Total control.</p>
                    </div>

                    <ul class="space-y-5 mb-12 flex-1 text-lg">
                        <li class="flex items-center gap-4"><svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> <strong>Unlimited</strong> AI tokens</li>
                        <li class="flex items-center gap-4"><svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Priority AI processing</li>
                        <li class="flex items-center gap-4"><svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Early access to new modules</li>
                        <li class="flex items-center gap-4"><svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Priority support</li>
                    </ul>

                    <a href="{{ route('register') }}" class="w-full py-5 rounded-2xl bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-lg text-center hover:from-purple-700 hover:to-pink-700 transition shadow-2xl shadow-purple-500/30">
                        Unlock Commander Access
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-16 bg-[var(--bg)]">
        <div class="max-w-7xl mx-auto px-6 text-center md:text-left">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-4 opacity-70 hover:opacity-100 transition">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-white font-bold text-2xl">
                        Z
                    </div>
                    <span class="text-lg font-medium text-[var(--text-muted)]">ZenGravity © {{ date('Y') }}</span>
                </div>

                <div class="flex gap-10 text-sm text-[var(--text-muted)]">
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
                    <a href="#" class="hover:text-white transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts

    <script>
        // Theme toggle
        const toggle = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
                darkIcon?.classList.add('hidden');
                lightIcon?.classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
                lightIcon?.classList.add('hidden');
                darkIcon?.classList.remove('hidden');
            }
        }

        // Initial load
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            setTheme('dark');
        } else {
            setTheme('light');
        }

        toggle?.addEventListener('click', () => {
            setTheme(localStorage.theme === 'dark' ? 'light' : 'dark');
        });
    </script>
</body>
</html>