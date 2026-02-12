<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-3">Upgrade Your Arsenal</h2>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-6">
                Unleash the Full Power of <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">ZENGRAVITY</span>
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Unlock unlimited AI scans, deepfake detection, and advanced viral strategies. Choose the plan that fits your growth.
            </p>
        </div>

        <!-- Billing Toggle -->
        <div x-data="{ billing: 'monthly' }" class="space-y-12">
            <div class="flex justify-center">
                <div class="bg-white/[0.03] border border-white/10 p-1 rounded-xl inline-flex relative">
                    <div class="w-1/2 h-full absolute transition-all duration-300 ease-out bg-white/10 rounded-lg"
                         :class="billing === 'monthly' ? 'left-0 w-[100px]' : 'left-[100px] w-[90px]'"></div>
                    
                    <button @click="billing = 'monthly'" 
                            class="relative z-10 px-6 py-2 text-sm font-bold transition-colors duration-200"
                            :class="billing === 'monthly' ? 'text-white' : 'text-gray-500 hover:text-gray-300'">
                        Monthly
                    </button>
                    <button @click="billing = 'yearly'" 
                            class="relative z-10 px-6 py-2 text-sm font-bold transition-colors duration-200"
                            :class="billing === 'yearly' ? 'text-white' : 'text-gray-500 hover:text-gray-300'">
                        Yearly <span class="text-[10px] text-green-400 ml-1">-20%</span>
                    </button>
                </div>
            </div>

            <!-- Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                
                <!-- Free Tier -->
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-8 flex flex-col relative overflow-hidden group hover:border-white/10 transition-colors">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-24 h-24 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Free Scout</h3>
                        <p class="text-sm text-gray-400">Perfect for testing the waters.</p>
                    </div>

                    <div class="mb-8">
                        <span class="text-4xl font-black text-white">$0</span>
                        <span class="text-gray-500">/forever</span>
                    </div>

                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            5 AI Scans / month
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            5 Collab Matches
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Basic Reporting
                        </li>
                    </ul>

                    @if(auth()->user()->subscribed('default'))
                        <div class="text-center py-3 bg-white/5 rounded-xl text-gray-400 font-bold text-sm">
                            Current Plan
                        </div>
                    @else
                        <div class="text-center py-3 bg-white/10 rounded-xl text-white font-bold text-sm cursor-not-allowed border border-white/5">
                            Your Current Plan
                        </div>
                    @endif
                </div>

                <!-- Pro Tier (Highlighted) -->
                <div class="bg-[#060608] border border-blue-500/30 rounded-3xl p-8 flex flex-col relative overflow-hidden shadow-2xl shadow-blue-500/10 scale-105 z-10">
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                    <div class="absolute top-0 right-0 bg-gradient-to-l from-blue-600 to-purple-600 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-wider">
                        Most Popular
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Pro Creator</h3>
                        <p class="text-sm text-gray-400">For serious growth & safety.</p>
                    </div>

                    <div class="mb-8 font-mono">
                        <div x-show="billing === 'monthly'">
                            <span class="text-5xl font-black text-white">$10</span>
                            <span class="text-gray-500">/mo</span>
                        </div>
                        <div x-show="billing === 'yearly'" style="display: none;">
                            <span class="text-5xl font-black text-white">$100</span>
                            <span class="text-gray-500">/yr</span>
                            <div class="text-green-400 text-xs mt-1 font-sans font-bold">Save $20/year</div>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-white font-medium">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="bg-blue-500/10 text-blue-300 px-1.5 py-0.5 rounded textxs">UNLIMITED</span> AI Scans & History
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Deepfake Analysis
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Unlimited Collab Matches
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Priority AI Strategy Pitches
                        </li>
                    </ul>

                    @if(auth()->user()->subscribed('default'))
                         <a href="{{ route('subscription.portal') }}" class="w-full py-4 rounded-xl bg-white/[0.05] hover:bg-white/10 text-white font-bold text-sm text-center transition-all">
                            Manage Subscription
                        </a>
                    @else
                        <a :href="billing === 'monthly' ? '{{ route('subscription.checkout', 'pro-monthly') }}' : '{{ route('subscription.checkout', 'pro-yearly') }}'" 
                           class="w-full py-4 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold text-lg text-center shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition-all transform hover:-translate-y-1">
                            Upgrade to Pro
                        </a>
                    @endif
                </div>

                <!-- Team Tier -->
                <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-8 flex flex-col relative overflow-hidden group hover:border-white/10 transition-colors">
                    
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Agency Team</h3>
                        <p class="text-sm text-gray-400">Scale with your crew.</p>
                    </div>

                    <div class="mb-8 font-mono">
                        <div x-show="billing === 'monthly'">
                            <span class="text-4xl font-black text-white">$30</span>
                            <span class="text-gray-500">/mo</span>
                        </div>
                        <div x-show="billing === 'yearly'" style="display: none;">
                            <span class="text-4xl font-black text-white">$300</span>
                            <span class="text-gray-500">/yr</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Everything in Pro
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            5 Team Seats
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Shared Workspaces
                        </li>
                        <li class="flex items-start gap-3 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Advanced Analytics
                        </li>
                    </ul>

                    @if(auth()->user()->subscribed('default') && auth()->user()->subscription('default')->stripe_price == config('services.stripe.team_monthly_id'))
                        <a href="{{ route('subscription.portal') }}" class="w-full py-3 rounded-xl bg-white/[0.05] hover:bg-white/10 text-white font-bold text-sm text-center transition-all">
                            Manage Team
                        </a>
                    @else
                        <a :href="billing === 'monthly' ? '{{ route('subscription.checkout', 'team-monthly') }}' : '{{ route('subscription.checkout', 'team-yearly') }}'" 
                           class="w-full py-3 rounded-xl bg-white/[0.05] hover:bg-white/10 border border-white/10 hover:border-white/20 text-white font-bold text-sm text-center transition-all">
                            Upgrade to Team
                        </a>
                    @endif
                </div>
            </div>

            <!-- Guarantee -->
            <div class="text-center text-gray-500 text-sm mt-12">
                <p>Secure payment via Stripe. Cancel anytime.</p>
            </div>
        </div>
    </div>
</x-app-layout>
