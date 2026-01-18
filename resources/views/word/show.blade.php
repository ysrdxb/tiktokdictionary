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

        <div class="max-w-[1240px] mx-auto px-6 space-y-8 pt-0">
            
            <!-- Section 1: Main Definition Card -->
            <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-12 shadow-xl border border-[#00336E]/5 relative overflow-hidden group hover:shadow-2xl transition-all">
                <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                    <div class="flex-1 min-w-0">
                        <!-- Title -->
                        <h1 class="text-5xl md:text-[5rem] font-bold text-[#00336E] tracking-tighter leading-none break-words font-title mb-6">
                            {{ $word->term }}
                        </h1>
                        
                        @if($word->alternate_spellings)
                            <p class="text-sm font-black text-[#00336E]/40 uppercase tracking-widest mb-6 -mt-4">
                                Also known as: <span class="text-[#00336E]/60">{{ $word->alternate_spellings }}</span>
                            </p>
                        @endif
                        
                        <!-- Live Trend Indicator + Metrics -->
                        <div class="flex flex-wrap items-center gap-4 mb-8">
                            <!-- Live View Counter -->
                            <div class="flex items-center gap-2 bg-[#0F62FE]/5 px-4 py-2 rounded-full border border-[#0F62FE]/10">
                                <span class="relative flex h-2.5 w-2.5">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                </span>
                                <span class="text-xs font-black text-[#00336E] uppercase tracking-widest">{{ number_format($word->views_buffer ?? rand(120, 5000)) }} Total Views</span>
                            </div>

                            <!-- Polar Trend Badge -->
                            @if($word->velocity_score > 5 || $word->is_polar_trend)
                                 <div class="flex items-center gap-2 bg-pink-500/5 px-4 py-2 rounded-full border border-pink-500/10">
                                     <span class="text-xs font-black text-pink-500 uppercase tracking-widest animate-pulse">🔥 Viral Vibe</span>
                                 </div>
                            @endif
                        </div>

                        @if($primaryDef)
                            <!-- Definition -->
                            <div class="relative">
                                <p class="text-[#00336E] text-xl md:text-3xl leading-snug font-medium mb-8 max-w-4xl">
                                    "{{ $primaryDef->definition }}"
                                </p>

                                <!-- Example -->
                                @if($primaryDef->example)
                                    <div class="bg-[#EFF6FE]/30 p-6 rounded-2xl mb-8 border-l-4 border-blue-400">
                                        <p class="text-[#00336E]/70 text-lg font-medium italic leading-relaxed">
                                            “{{ $primaryDef->example }}”
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions Row -->
                            <div class="flex flex-wrap items-center gap-6 border-t border-[#00336E]/5 pt-8 mt-10">
                                <!-- Voting -->
                                @livewire('voting-counter', [
                                    'definitionId' => $primaryDef->id, 
                                    'agrees' => $primaryDef->agrees, 
                                    'disagrees' => $primaryDef->disagrees
                                ])
                                
                                <div class="h-8 w-px bg-slate-200 mx-2 hidden sm:block"></div>
                                
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
                                        :class="playing ? 'bg-pink-500 text-white shadow-lg animate-pulse' : 'bg-slate-100 text-[#00336E] hover:bg-slate-200'"
                                        class="flex items-center gap-2 text-xs font-black transition-all uppercase tracking-widest px-6 py-3 rounded-full"
                                    >
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg> 
                                        <span x-text="playing ? 'Playing...' : 'Pronounce'"></span>
                                    </button>
                                </div>
                                
                                <!-- Vibe Check -->
                                <div class="w-full md:w-auto mt-4 md:mt-0">
                                    @livewire('reaction-bar', ['definitionId' => $primaryDef->id], key('primary-vote-'.$primaryDef->id))
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Interaction Column (Share & Receipt) -->
                    <div class="w-full md:w-80 flex flex-col gap-4">
                        <!-- Receipt Button -->
                        @if($primaryDef->source_url && Str::contains($primaryDef->source_url, 'tiktok.com'))
                             <button onclick="Livewire.dispatch('openReceiptModal', { sourceUrl: '{{ $primaryDef->source_url }}', term: '{{ addslashes($word->term) }}' })"
                                     class="w-full bg-black rounded-[24px] p-6 text-white group/play hover:scale-[1.02] transition-all flex flex-col items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center group-hover/play:bg-pink-500 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                                <span class="text-xs font-black uppercase tracking-[0.2em]">Watch Receipt</span>
                             </button>
                        @endif

                        <!-- Share Button -->
                        <div x-data="{ generating: false }">
                            <button @click="generating = true; setTimeout(() => { generating = false; Livewire.dispatch('openShareModal', { wordId: {{ $word->id }} }); }, 1500)" 
                                    class="w-full py-6 bg-gradient-to-br from-blue-600 to-indigo-700 text-white font-black rounded-[24px] hover:shadow-2xl transition-all active:scale-95 flex flex-col items-center gap-2 group">
                                <svg x-show="!generating" class="w-6 h-6 text-white/50 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <svg x-show="generating" class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span class="text-xs uppercase tracking-widest">{{ $word->is_polar_trend ? 'Get Sticky Card' : 'Share to Story' }}</span>
                            </button>
                        </div>

                        <!-- Report Button -->
                        <button onclick="Livewire.dispatch('openReportModal', { type: 'App\\Models\\Word', id: {{ $word->id }} })" 
                                class="text-[#00336E]/20 hover:text-red-400 text-[10px] font-black uppercase tracking-[0.2em] transition-colors mt-2">
                            Report This Word
                        </button>
                    </div>
                </div>
            </section>

            <!-- Section 2: AI Summary (Promoted to Priority) -->
            <section class="premium-card reveal-on-scroll bg-gradient-to-br from-[#00336E] to-[#00152e] rounded-[30px] p-8 md:p-12 shadow-xl text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-[120px] opacity-20"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center shrink-0 border border-white/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white/50 uppercase tracking-[0.3em] mb-2">AI Context Summary</h3>
                        <p class="text-xl md:text-2xl text-white leading-relaxed font-medium">
                            @if($word->ai_summary)
                                {{ $word->ai_summary }}
                            @else
                                "{{ $word->term }}" is blowing up in <span class="text-blue-400 font-bold">{{ $word->category }}</span> culture. It's often spotted in viral reaction clips and trending comments.
                            @endif
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 3: Alternate Definitions & Contribution -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Alt Column -->
                <div class="lg:col-span-2 space-y-8">
                     <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5">
                        <h2 class="text-3xl font-bold text-[#00336E] tracking-tight mb-8 font-title">Alternate Meanings</h2>

                        @if($word->definitions->count() > 1)
                            <div class="space-y-6 mb-12">
                                @foreach($word->definitions->skip(1) as $definition)
                                    <div class="p-6 rounded-2xl border border-[#00336E]/5 hover:bg-slate-50 transition-colors">
                                        <p class="text-[#00336E] text-lg font-bold mb-4">"{{ $definition->definition }}"</p>
                                        <div class="flex items-center justify-between">
                                            @livewire('voting-counter', [
                                                'definitionId' => $definition->id,
                                                'agrees' => $definition->agrees,
                                                'disagrees' => $definition->disagrees
                                            ], key('alt-vote-'.$definition->id))
                                            <span class="text-[10px] font-black text-[#00336E]/30 uppercase">Submitted by {{ $definition->submitted_by }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-12 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 mb-8">
                                <p class="text-[#00336E]/40 font-bold uppercase tracking-widest text-xs">No alternate meanings yet</p>
                            </div>
                        @endif

                        <div class="pt-8 border-t border-[#00336E]/5">
                            <h2 class="text-3xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Add your take:</h2>
                            @livewire('add-definition', ['wordId' => $word->id])
                        </div>
                    </section>
                </div>

                <!-- Sidebar column -->
                <div class="space-y-8">
                    <!-- Related Words -->
                    <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 shadow-sm border border-[#00336E]/5">
                        <h3 class="text-xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Related Words</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($relatedWords as $related)
                                <a href="{{ route('word.show', $related->slug) }}" class="px-4 py-2 bg-slate-50 hover:bg-blue-600 hover:text-white rounded-full text-sm font-bold text-[#00336E] transition-all">
                                    {{ $related->term }}
                                </a>
                            @empty
                                <span class="text-xs font-bold text-slate-400">No related words.</span>
                            @endforelse
                        </div>
                    </section>

                    <!-- Stats Card -->
                    <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 shadow-sm border border-[#00336E]/5">
                        <h3 class="text-xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Vital Stats</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-400 uppercase">First Spotted</span>
                                <span class="text-sm font-black text-[#00336E]">{{ $word->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-400 uppercase">Subculture</span>
                                <span class="text-sm font-black text-[#00336E]">{{ $word->category }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-400 uppercase">OG Contributor</span>
                                <span class="text-sm font-black text-[#00336E]">{{ $primaryDef->submitted_by ?? 'Anonymous' }}</span>
                            </div>
                            @if($word->vibes && count($word->vibes) > 0)
                                <div class="pt-4 border-t border-slate-100">
                                    <span class="text-[10px] font-black text-slate-400 uppercase block mb-2">Vibes</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($word->vibes as $vibe)
                                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">#{{ $vibe }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>

                    <!-- Domain Promo (Compact) -->
                    <section class="premium-card reveal-on-scroll bg-slate-50 rounded-[30px] p-8 border border-green-500/20">
                        <div class="mb-4">
                            <span class="text-[10px] font-black bg-green-500 text-white px-2 py-0.5 rounded uppercase">Invest</span>
                        </div>
                        <h4 class="text-lg font-black text-[#00336E] mb-2">{{ Str::slug($word->term) }}.com</h4>
                        <p class="text-xs font-bold text-slate-500 mb-6">Dictionary domains are prime digital assets.</p>
                        <a href="https://www.godaddy.com" target="_blank" class="block w-full py-3 bg-white border border-[#00336E]/10 rounded-xl text-center text-xs font-black text-[#00336E] hover:bg-[#00336E] hover:text-white transition-all">
                            Check Price on GoDaddy
                        </a>
                    </section>
                </div>
            </div>
        </div>
    </div>

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
