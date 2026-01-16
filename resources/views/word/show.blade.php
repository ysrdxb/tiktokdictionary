<x-layouts.app>
    <x-slot:title>
        {{ $word->term }} - TikTokDictionary
    </x-slot>

    @php
        $primaryDef = $word->definitions->first();
        $relatedWords = $word->getRelatedWords(4);
    @endphp

    <!-- Hero Background Section (Top) -->
    <div class="w-full bg-[#E9F2FE] pt-24 md:pt-28 pb-40 px-6 text-center relative z-10">
        <p class="text-[#00336E]/60 font-bold uppercase tracking-widest text-xs mb-4 animate-pulse">Word of the Moment</p>
    </div>

    <!-- Main Content Wrapper (Transparent Container) -->
    <div class="w-full min-h-screen -mt-32 relative z-20 pb-20">
        <!-- Lower Page Global Background (Starts after overlap) -->
        <div class="absolute top-32 bottom-0 left-0 right-0 bg-[#FFFFFF] -z-10"></div>

        <div class="max-w-[1240px] mx-auto px-6 space-y-6 pt-0">
            
            <!-- Section 1: Main Definition Card -->
            <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-lg border border-[#00336E]/5 relative overflow-hidden group hover:shadow-xl transition-all">
                <!-- Title -->
                <h1 class="text-4xl md:text-[4rem] font-bold text-[#00336E] tracking-tighter leading-none break-words font-title mb-2">
                    {{ $word->term }}
                </h1>
                
                <!-- Live Trend Indicator + Metrics -->
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <!-- Live View Counter -->
                    <div class="flex items-center gap-2 bg-[#0F62FE]/5 px-3 py-1.5 rounded-full border border-[#0F62FE]/10">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                        </span>
                        <span class="text-xs font-bold text-[#00336E] uppercase tracking-widest">{{ number_format(rand(120, 5000)) }} Live Views</span>
                    </div>

                    <!-- Polar Trend Badge -->
                    @if($word->velocity_score > 5 || $word->is_polar_trend)
                         <span class="text-xs font-bold text-pink-500 uppercase tracking-widest animate-pulse">🔥 Possible Polar Trend</span>
                    @endif
                    
                    <!-- RFCI Score -->
                    @if($word->rfci_score)
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 border border-slate-200" title="Reference Frequency & Cultural Impact">
                             <span class="text-[10px] font-black text-slate-400 uppercase">RFCI</span>
                             <span class="text-xs font-black text-[#00336E]">{{ $word->rfci_score }}</span>
                        </div>
                    @endif
                </div>

                <!-- CREATIVE: Hype Meter -->
                <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100 relative overflow-hidden">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black text-[#00336E] uppercase tracking-widest">Viral Velocity</span>
                        <span class="text-xs font-black text-[#00336E]">{{ number_format(min(($word->velocity_score ?? 10) * 10, 100), 0) }}% Hype</span>
                    </div>
                    <!-- Bar Background -->
                    <div class="h-4 w-full bg-slate-200 rounded-full overflow-hidden relative">
                        <!-- Fire Gradient Bar -->
                        <div class="h-full bg-gradient-to-r from-orange-400 via-red-500 to-pink-600 rounded-full shadow-[0_0_15px_rgba(236,72,153,0.5)] transition-all duration-1000 ease-out"
                             style="width: {{ min(($word->velocity_score ?? 10) * 10, 100) }}%">
                             <!-- Animating Shine -->
                             <div class="absolute inset-0 bg-white/30 w-full animate-[shimmer_2s_infinite] skew-x-12"></div>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-tight">Based on views, shares, and votes in the last 24h.</p>
                </div>

                @if($primaryDef)
                    <!-- Definition -->
                    <p class="text-[#00336E] text-lg md:text-2xl leading-relaxed font-normal mb-4 max-w-4xl">
                        {{ $primaryDef->definition }}
                    </p>

                    <!-- Example -->
                    @if($primaryDef->example)
                        <div class="bg-[#EFF6FE]/50 p-5 rounded-2xl mb-6 border-l-4 border-[#00336E]/20">
                            <p class="text-[#00336E]/80 text-lg font-normal italic">"{{ $primaryDef->example }}"</p>
                        </div>
                    @endif

                    <!-- Actions Row -->
                    <div class="flex flex-wrap items-center gap-6 border-t border-[#00336E]/5 pt-6 mt-6">
                        <!-- Voting -->
                        @livewire('voting-counter', [
                            'definitionId' => $primaryDef->id,
                            'agrees' => $primaryDef->agrees,
                            'disagrees' => $primaryDef->disagrees
                        ], key('primary-vote-'.$primaryDef->id))

                        <!-- Audio Player -->
                        <div x-data="{ 
                            playing: false,
                            async playAudio(text) {
                                if(this.playing) return;
                                this.playing = true;
                                try {
                                    const audio = await puter.ai.txt2speech(text, { voice: 'Kimberly', speed: 1.1 });
                                    audio.onended = () => { this.playing = false; };
                                    audio.play();
                                } catch (error) {
                                    console.error('Audio failed:', error);
                                    this.playing = false;
                                }
                            }
                        }">
                            <button 
                                @click="playAudio('{{ addslashes($word->term) }}: {{ addslashes($primaryDef->definition) }}')"
                                :class="playing ? 'text-pink-500 animate-pulse' : 'text-[#00336E]/60 hover:text-[#00336E]'"
                                class="flex items-center gap-2 text-xs font-bold transition-colors uppercase tracking-widest bg-slate-50 hover:bg-white px-4 py-2 rounded-full border border-transparent hover:border-[#00336E]/10 hover:shadow-sm"
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg> 
                                <span x-text="playing ? 'Playing...' : 'Pronounce'"></span>
                            </button>
                        </div>

                        <!-- Report Button -->
                        <button onclick="Livewire.dispatch('openReportModal', { type: 'App\\Models\\Definition', id: {{ $primaryDef->id }} })" 
                                class="text-[#00336E]/30 hover:text-red-500 transition-colors ml-auto flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest group/report"
                                title="Report this definition">
                            <svg class="w-4 h-4 group-hover/report:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h10a2 2 0 012 2v8m2-2a2 2 0 00-2-2H5a2 2 0 00-2 2m0-10V5a2 2 0 012-2h6.19a2 2 0 011.85.93l.3.38a2 2 0 001.7 1.07h2.9A2 2 0 0121 7v6a2 2 0 01-2 2h-6.19a2 2 0 01-1.85-.93l-.3-.38a2 2 0 00-1.7-1.07H5a2 2 0 01-2-2"></path></svg>
                            Report
                            Report
                        </button>
                    </div>

                    <!-- CREATIVE: Receipt (TikTok Embed) -->
                    @if($primaryDef->source_url && Str::contains($primaryDef->source_url, 'tiktok.com'))
                        <div class="mt-8 border-t border-[#00336E]/5 pt-6">
                             <h4 class="text-sm font-black text-[#00336E] uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                                The Receipt (Proof)
                             </h4>
                             <button onclick="Livewire.dispatch('openReceiptModal', { sourceUrl: '{{ $primaryDef->source_url }}', term: '{{ addslashes($word->term) }}' })"
                                     class="w-full h-32 rounded-2xl bg-black/5 hover:bg-black/10 border border-black/10 flex flex-col items-center justify-center gap-2 transition-all group/play">
                                <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center group-hover/play:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-black ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                                <span class="text-xs font-bold text-[#00336E]/60 uppercase tracking-widest group-hover/play:text-[#00336E]">Watch Receipt</span>
                             </button>
                        </div>
                    @elseif($primaryDef->source_url)
                        <div class="mt-6">
                            <a href="{{ $primaryDef->source_url }}" target="_blank" class="text-xs font-bold text-[#00336E]/50 hover:text-[#00336E] flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                View Source Context
                            </a>
                        </div>
                    @endif

                    <!-- CREATIVE: Share Card Generator -->
                    <div class="mt-6 border-t border-[#00336E]/5 pt-6" x-data="{ generating: false }">
                        <button @click="generating = true; setTimeout(() => { generating = false; Livewire.dispatch('openShareModal', { wordId: {{ $word->id }} }); }, 1500)" 
                                class="w-full py-4 bg-[#00336E] text-white font-bold rounded-xl hover:bg-black transition-all shadow-lg active:scale-[0.98] flex items-center justify-center gap-2 group">
                            <span x-show="!generating" class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-pink-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Generate Shareable 'Story' Card
                            </span>
                            <span x-show="generating" class="flex items-center gap-2 animate-pulse">
                                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Baking fresh pixels...
                            </span>
                        </button>
                        <p class="text-center text-[10px] text-slate-400 font-bold mt-2 uppercase">Perfect for Instagram Stories & TikTok</p>
                    </div>
                @endif
            </section>

            <!-- Section 2: Alternate Definitions & Contribution -->
            <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5">
                <h2 class="text-3xl font-bold text-[#00336E] tracking-tight mb-8 font-title">Alternate Definitions</h2>

                @if($word->definitions->count() > 1)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                        @foreach($word->definitions->skip(1)->take(3) as $definition)
                            <div class="bg-[#F8FAFC] rounded-[20px] p-6 flex flex-col h-full hover:bg-[#F1F5F9] transition-colors group border border-transparent hover:border-[#00336E]/10">
                                <p class="text-[#00336E] text-base leading-relaxed font-bold mb-4 flex-grow">
                                    "{{ Str::limit($definition->definition, 100) }}"
                                </p>
                                <div class="flex items-center gap-3 mt-auto pt-4 border-t border-[#00336E]/5">
                                    @livewire('voting-counter', [
                                        'definitionId' => $definition->id,
                                        'agrees' => $definition->agrees,
                                        'disagrees' => $definition->disagrees
                                    ], key('alt-vote-'.$definition->id))
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Your Meaning Section (Merged) -->
                <div class="@if($word->definitions->count() > 1) pt-8 border-t border-[#00336E]/5 @endif">
                    <h2 class="text-4xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Your meaning of this word:</h2>
                    <div class="bg-white">
                         @livewire('add-definition', ['wordId' => $word->id])
                    </div>
                </div>
            </section>

            <!-- Section 4: Related Words -->
            <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5">
                <h3 class="text-3xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Related Words</h3>
                @if($relatedWords->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($relatedWords as $related)
                            <a href="{{ route('word.show', $related->slug) }}" 
                               class="bg-[#EFF6FE]/50 hover:bg-[#EFF6FE] px-6 py-4 rounded-[20px] text-center transition-all group border border-transparent hover:border-[#00336E]/10 hover:shadow-sm">
                                <span class="text-[#00336E] font-bold group-hover:text-blue-600 transition-colors">{{ $related->term }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-sm font-medium text-[#00336E]/50">No related words yet.</div>
                @endif
            </section>

            <!-- Section 3: AI Summary (Mock) -->
            <section class="premium-card reveal-on-scroll bg-gradient-to-br from-[#00336E] to-[#00152e] rounded-[30px] p-8 md:p-10 shadow-xl text-white relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-[#0F62FE] rounded-full blur-[100px] opacity-20 mix-blend-screen"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-pink-500 rounded-full blur-[80px] opacity-20 mix-blend-screen"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-md border border-white/20">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white/90 uppercase tracking-widest">AI Context Summary</h3>
                    </div>
                    <p class="text-white/80 text-lg leading-relaxed font-medium">
                        "{{ $word->term }}" is currently trending in <span class="text-white font-bold underline decoration-pink-500/50 decoration-2">Gen-Z</span> circles. Often used as a reaction to <span class="text-white font-bold">unexpected news</span> or <span class="text-white font-bold">viral videos</span>. Sentiment is generally positive but context-dependent.
                    </p>
                </div>
            </section>

             <!-- Section 4: Domain Availability (Mock - GoDaddy Affiliate) -->
            <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5 relative overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1">
                        <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-[10px] font-black uppercase tracking-widest mb-3">Available</span>
                        <h3 class="text-3xl font-black text-[#00336E] mb-2 font-title">Get {{ Str::slug($word->term) }}.com</h3>
                        <p class="text-[#00336E]/60 font-medium mb-6 max-w-lg">
                            Own this viral word before someone else does. Dictionary domains are high-value digital assets for branding and SEO.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="https://www.godaddy.com" target="_blank" class="px-8 py-3 bg-[#00336E] text-white font-bold rounded-full hover:bg-black transition-all shadow-lg hover:-translate-y-1 text-center">
                                Buy on GoDaddy &rarr;
                            </a>
                            <span class="text-[10px] text-[#00336E]/30 self-center max-w-[200px] leading-tight text-center sm:text-left">
                                Affiliate Disclaimer: Check exact value with external tools first.
                            </span>
                        </div>
                    </div>
                    <!-- Visual Mockup -->
                    <div class="w-full md:w-auto p-6 bg-slate-50 rounded-2xl border border-slate-200 transform md:rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="text-2xl font-black text-[#00336E] font-title">{{ Str::slug($word->term) }}.com</div>
                        <div class="text-green-500 font-bold text-lg">$2,400 <span class="text-xs text-slate-400 font-normal line-through ml-2">$5,000</span></div>
                    </div>
                </div>
            </section>

            <!-- Section 5: Word Origin / First Use -->
            <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5">
                <h3 class="text-3xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Word Origin / First Use</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-[#EFF6FE]/50 rounded-[20px] p-6 border border-transparent hover:border-[#00336E]/10 transition-colors">
                        <div class="text-xs font-bold text-[#00336E]/40 uppercase tracking-widest mb-2">Submitted originally by:</div>
                        <div class="text-[#00336E] font-bold text-lg">{{ $primaryDef->submitted_by ?? '@username' }}</div>
                    </div>
                    <div class="bg-[#EFF6FE]/50 rounded-[20px] p-6 border border-transparent hover:border-[#00336E]/10 transition-colors">
                        <div class="text-xs font-bold text-[#00336E]/40 uppercase tracking-widest mb-2">Date first submitted:</div>
                        <div class="text-[#00336E] font-bold text-lg">{{ $word->created_at ? $word->created_at->format('d M Y') : '18 Jul 2025' }}</div>
                    </div>
                </div>
            </section>

            <!-- Section 6: Local Investor (Disabled/Hidden or kept styled) -->
            @if(\App\Models\Setting::get('domain_checker_enabled', 'true') === 'true')
            <section class="premium-card reveal-on-scroll w-full bg-[#00336E] rounded-[30px] p-8 md:p-10 text-white relative overflow-hidden shadow-lg">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-accent/20 blur-[80px] rounded-full pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex-1">
                        <h3 class="text-2xl md:text-3xl font-bold font-[GRIFTER] mb-2">Investor View</h3>
                        <p class="text-white/80 font-medium">This word is trending. Check if the domain is available and invest early.</p>
                    </div>
                    <div class="w-full md:w-auto">
                        @livewire('tools.domain-checker', ['term' => $word->term])
                    </div>
                </div>
            </section>
            @endif

            <!-- Section 7: Lore Timeline -->
            <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5">
                <h3 class="text-3xl font-bold text-[#00336E] tracking-tight mb-6 flex items-center gap-3 font-title">
                    Lore Timeline
                    <span class="text-xs bg-[#EFF6FE] text-[#00336E] px-3 py-1 rounded-full uppercase tracking-wider font-bold font-sans">Chronology</span>
                </h3>
                
                <x-lore-timeline :entries="$word->lore" />
            </section>

            <!-- Section 8: Sticker & Report -->
            <section class="flex flex-col items-center gap-6 py-6">
                 <button onclick="Livewire.dispatch('openReportModal', { type: 'App\\Models\\Word', id: {{ $word->id }} })" class="px-6 py-2 rounded-full border border-[#00336E]/10 text-xs font-bold text-[#00336E]/50 hover:text-red-500 hover:border-red-200 hover:bg-red-50 flex items-center justify-center gap-2 transition-all bg-white shadow-sm hover:shadow-md">
                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h10a2 2 0 012 2v8m2-2a2 2 0 00-2-2H5a2 2 0 00-2 2m0-10V5a2 2 0 012-2h6.19a2 2 0 011.85.93l.3.38a2 2 0 001.7 1.07h2.9A2 2 0 0121 7v6a2 2 0 01-2 2h-6.19a2 2 0 01-1.85-.93l-.3-.38a2 2 0 00-1.7-1.07H5a2 2 0 01-2-2"></path></svg>
                     Report this Word
                </button>
            </section>
        </div>
    </div>
    
    <!-- Modals -->
    <livewire:tools.share-modal /> 
    <livewire:tools.report-modal />
    <livewire:tools.receipt-modal />
</x-layouts.app>
