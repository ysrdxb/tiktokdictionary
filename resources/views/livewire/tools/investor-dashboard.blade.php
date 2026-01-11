<div class="min-h-screen bg-[#09090b] text-white font-mono">
    <!-- Navbar (Simplified for Dashboard) -->
    <div class="border-b border-white/10 bg-black/20 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl tracking-tight flex items-center gap-2">
                <span class="text-emerald-400">📈</span> TikTok<span class="opacity-50">Dictionary</span> <span class="text-xs bg-white/10 px-2 py-0.5 rounded text-white/60">PRO</span>
            </a>
            <div class="flex items-center gap-6 text-sm font-medium text-white/60">
                <div class="hidden md:flex gap-6">
                    <span class="text-white">Markets</span>
                    <span>Watchlist</span>
                    <span>Portfolio</span>
                </div>
                <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-emerald-500 to-cyan-500"></div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-10">
        
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-bold mb-2">Trend Market <span class="text-emerald-500">Live</span></h1>
            <p class="text-white/40">Real-time valuation of viral terminology assets.</p>
        </div>

        <!-- Ticker Tape (Static Mock) -->
        <div class="flex gap-4 mb-8 overflow-hidden opacity-50 text-xs text-emerald-400 border-y border-white/5 py-2">
            <span>RIZZ +12.4%</span> •
            <span>GYATT +8.2%</span> •
            <span>FANUM TAX +4.1%</span> •
            <span>DELULU +15.2%</span> •
            <span>SKIBIDI -2.1%</span> •
            <span>SUS +0.5%</span>
        </div>

        <!-- Table Card -->
        <div class="bg-[#111113] border border-white/10 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs uppercase text-white/40 border-b border-white/10 tracking-widest">
                            <th class="p-6 font-medium">Asset Name</th>
                            <th class="p-6 font-medium">Domain Status</th>
                            <th class="p-6 font-medium text-right">Viral Velocity</th>
                            <th class="p-6 font-medium text-right">24h Change</th>
                            <th class="p-6 font-medium text-right">Market Price</th>
                            <th class="p-6 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($assets as $asset)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-lg font-bold text-white/30 group-hover:text-white transition-colors">
                                            {{ substr($asset['term'], 0, 1) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('word.show', $asset['slug']) }}" class="block font-bold text-white hover:text-emerald-400 transition-colors">
                                                {{ $asset['term'] }}
                                            </a>
                                            <span class="text-xs text-white/30">{{ $asset['domain'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    @if($asset['is_available'])
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-xs font-bold border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-500/10 text-red-500 text-xs font-bold border border-red-500/20">
                                            Taken
                                        </span>
                                    @endif
                                </td>
                                <td class="p-6 text-right font-medium text-white/70">
                                    {{ number_format($asset['velocity'], 2) }} <span class="text-xs text-white/30">V/H</span>
                                </td>
                                <td class="p-6 text-right font-bold {{ $asset['change_24h'] >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ $asset['change_24h'] > 0 ? '+' : '' }}{{ $asset['change_24h'] }}%
                                </td>
                                <td class="p-6 text-right font-bold text-lg">
                                    @if($asset['is_available'])
                                        ${{ number_format($asset['price'], 2) }}
                                    @else
                                        <span class="text-white/20">---</span>
                                    @endif
                                </td>
                                <td class="p-6 text-right">
                                    @if($asset['is_available'])
                                        <a href="https://www.godaddy.com/domainsearch/find?checkAvail=1&domainToCheck={{ $asset['domain'] }}" target="_blank" class="inline-block px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-black font-bold text-xs rounded-lg transition-colors shadow-[0_0_10px_rgba(16,185,129,0.3)]">
                                            BUY NOW
                                        </a>
                                    @else
                                         <button disabled class="inline-block px-4 py-2 bg-white/5 text-white/20 font-bold text-xs rounded-lg cursor-not-allowed">
                                            UNAVAILABLE
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <p class="mt-8 text-center text-xs text-white/20">
            *Market data is simulated for demonstration. Trends are real. Domain availability checks are estimated.
            <br>TikTokDictionary may earn a commission from domain sales.
        </p>
    </div>
</div>
