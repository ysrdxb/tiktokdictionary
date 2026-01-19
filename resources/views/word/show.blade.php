<x-layouts.app>
    <x-slot:title>
        {{ $word->term }} - TikTokDictionary
    </x-slot>

    @php
        $primaryDef = $word->definitions->first();
        $relatedWords = $word->getRelatedWords(4);
    @endphp

    <div class="w-full bg-[#E9F2FE] pt-24 md:pt-32 pb-44 px-6 text-center relative z-10 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1200px] h-[400px] blur-[120px] rounded-full"></div>

    </div>

    <div class="w-full min-h-screen -mt-40 md:-mt-48 relative z-20 pb-24">
        <div class="max-w-[1240px] mx-auto px-6 space-y-8 pt-0">
            
            <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-12 shadow-sm border border-[#00336E]/5 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="flex flex-col">
                    <div class="w-full">
                        <div class="flex flex-col mb-8">
                            <div class="flex flex-wrap md:flex-nowrap items-start md:items-center justify-between gap-6 mb-6">
                                <div class="flex items-center gap-4">
                                    <h1 class="text-6xl md:text-[5rem] font-bold text-[#00336E] tracking-tight leading-none font-title drop-shadow-sm text-left">
                                        {{ $word->term }}
                                    </h1>
                                    
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
                                    }" class="relative top-1 md:top-2">
                                        <button 
                                            @click="playAudio('{{ addslashes($word->term) }}: {{ addslashes($primaryDef->definition) }}')"
                                            :class="playing ? 'text-brand-accent scale-110' : 'text-[#00336E]/30 hover:text-brand-accent'"
                                            class="group flex items-center justify-center transition-all bg-transparent focus:outline-none"
                                            title="Listen to pronunciation"
                                        >
                                            <!-- Standard Speaker Icon -->
                                            <svg x-show="!playing" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5l-5 4H2v6h4l5 4V5zM15.54 8.46a5 5 0 010 7.08M19.07 4.93a10 10 0 010 14.14"></path>
                                            </svg>
                                            
                                            <!-- Loading/Playing State -->
                                            <div x-show="playing" class="flex items-center gap-1 h-8">
                                                <span class="w-1 h-3 bg-brand-accent rounded-full animate-[bounce_0.8s_infinite]"></span>
                                                <span class="w-1 h-5 bg-brand-accent rounded-full animate-[bounce_1.0s_infinite]"></span>
                                                <span class="w-1 h-3 bg-brand-accent rounded-full animate-[bounce_1.2s_infinite]"></span>
                                                <span class="w-1 h-5 bg-brand-accent rounded-full animate-[bounce_0.9s_infinite]"></span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Domain Trigger Pill (Right Aligned - Premium Widget) -->
                                <!-- Domain Trigger Pill (Right Aligned - High CTR) -->
                                <button onclick="Livewire.dispatch('openDomainModal', { term: @js($word->term) })" 
                                        class="hidden md:flex flex-col items-end group/domain cursor-pointer transition-all hover:-translate-y-0.5 active:scale-95">
                                    <div class="relative overflow-hidden inline-flex items-center gap-4 px-6 py-3 bg-[#00336E] text-white rounded-2xl shadow-xl shadow-brand-accent/10 border border-[#00336E]/5 group-hover/domain:shadow-brand-accent/20 group-hover/domain:border-brand-accent/50 transition-all">
                                        <!-- Shine Effect -->
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent skew-x-12 translate-x-[-150%] group-hover/domain:animate-[shimmer_1s_infinite]"></div>

                                        <div class="text-right relative z-10">
                                            <div class="flex items-center justify-end gap-2 mb-0.5">
                                                <span class="relative flex h-2 w-2">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                                </span>
                                                <span class="text-[10px] font-black uppercase tracking-widest text-[#FFB703]">Available Now</span>
                                            </div>
                                            <div class="text-base font-black leading-none group-hover/domain:text-[#FFB703] transition-colors">
                                                Get {{ Str::slug($word->term) }}.com
                                            </div>
                                        </div>
                                        
                                        <div class="relative z-10 w-10 h-10 rounded-xl bg-[#FFB703] text-[#00336E] flex items-center justify-center shadow-lg group-hover/domain:scale-110 group-hover/domain:rotate-[-10deg] transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            
                            @if($primaryDef)
                                <div class="space-y-4 text-left">
                                    <p class="text-[#00336E] text-lg md:text-xl font-medium leading-relaxed max-w-4xl">
                                        {{ $primaryDef->definition }}
                                    </p>

                                    @if($primaryDef->example)
                                        <p class="text-[#00336E]/70 text-base md:text-lg leading-relaxed">
                                            <span class="font-bold">Example:</span> "{{ $primaryDef->example }}"
                                        </p>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-8 flex flex-wrap items-center gap-4">
                                @if($word->alternate_spellings)
                                    <div class="flex items-center gap-3 bg-[#00336E]/5 px-4 py-2 rounded-xl border border-[#00336E]/5">
                                        <span class="text-[10px] font-black text-[#00336E]/40 uppercase tracking-[0.2em]">Pronounced:</span>
                                        <span class="text-sm font-bold text-[#00336E] italic">"{{ $word->alternate_spellings }}"</span>
                                    </div>
                                @endif

                                <div class="flex items-center gap-2 bg-brand-accent/10 px-4 py-2 rounded-xl border border-brand-accent/20">
                                    <span class="relative flex h-2.5 w-2.5">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                    </span>
                                    <span class="text-[10px] font-black text-[#00336E] uppercase tracking-widest">{{ number_format($word->views_buffer ?? rand(120, 5000)) }} Views</span>
                                </div>

                                @if($word->velocity_score > 5 || $word->is_polar_trend)
                                     <div class="flex items-center gap-2 bg-pink-500/5 px-4 py-2 rounded-xl border border-pink-500/10">
                                         <span class="text-[10px] font-black text-pink-500 uppercase tracking-widest animate-pulse">🔥 Viral Vibe</span>
                                     </div>
                                @endif
                            </div>
                        </div>

                            <!-- Interaction Dock -->
                            @if($primaryDef)
                            <div class="flex flex-wrap md:flex-nowrap items-center gap-3 md:gap-4 w-full mt-8">
                                
                                <!-- Voting -->
                                <div class="shrink-0 pl-2">
                                    @livewire('voting-counter', [
                                        'definitionId' => $primaryDef->id, 
                                        'agrees' => $primaryDef->agrees, 
                                        'disagrees' => $primaryDef->disagrees
                                    ])
                                </div>

                                <!-- Divider Removed -->

                                <!-- Audio Removed (Relocated to Header) -->

                                <!-- Reactions -->
                                <div class="hidden md:block">
                                    @livewire('reaction-bar', ['definitionId' => $primaryDef->id], key('primary-vote-'.$primaryDef->id))
                                </div>

                                <!-- Divider Removed -->

                                <!-- Actions -->
                                <div class="flex items-center gap-3 ml-auto">
                                    <button onclick="Livewire.dispatch('openShareModal', { wordId: {{ $word->id }} })" 
                                            class="px-5 py-2.5 flex items-center gap-2 bg-[#00336E] text-white rounded-full hover:bg-brand-accent hover:text-[#00336E] transition-all shadow-md active:scale-95 text-xs font-black uppercase tracking-wider"
                                            title="Share Story Sticker">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Share Sticker
                                    </button>
                                    
                                    <button onclick="Livewire.dispatch('openReportModal', { type: 'App\\Models\\Word', id: {{ $word->id }} })" 
                                            class="w-10 h-10 flex items-center justify-center text-slate-300 hover:text-red-500 rounded-full hover:bg-red-50 transition-all border border-transparent hover:border-red-100" title="Report">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Mobile Reactions Fallback -->
                            <div class="md:hidden mt-4 flex justify-center w-full">
                                @livewire('reaction-bar', ['definitionId' => $primaryDef->id], key('primary-vote-mobile-'.$primaryDef->id))
                            </div>
                        @endif
                    </div>
                </div>

                @if($primaryDef->source_url && Str::contains($primaryDef->source_url, 'tiktok.com'))
                    <div class="mt-8 pt-8 border-t border-[#00336E]/5">
                         <button onclick="Livewire.dispatch('openReceiptModal', { sourceUrl: '{{ $primaryDef->source_url }}', term: '{{ addslashes($word->term) }}' })"
                                 class="px-6 py-3 bg-black text-white rounded-full font-bold text-xs uppercase tracking-widest hover:bg-brand-accent hover:text-[#00336E] transition-all flex items-center justify-center gap-3 w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            Watch Receipt
                         </button>
                    </div>
                @endif
            </section>

            <section class="premium-card reveal-on-scroll bg-[#00336E] rounded-[24px] p-6 shadow-md text-white relative overflow-hidden group/summary border-none mb-8">
                <div class="absolute inset-0 bg-gradient-to-br from-[#00336E] to-[#011a3b]"></div>
                
                <div class="relative z-10 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0 border border-white/20 shadow-inner">
                        <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    
                    <div class="space-y-1">
                        <h3 class="text-[10px] font-black text-brand-accent uppercase tracking-[0.2em] flex items-center gap-2">
                            AI Analysis
                        </h3>
                        <p class="text-sm text-white/90 leading-relaxed font-medium">
                            @if($word->ai_summary)
                                {{ $word->ai_summary }}
                            @else
                                "{{ $word->term }}" is trending in <span class="text-brand-accent underline decoration-brand-accent/30 decoration-2 underline-offset-4">{{ $word->category }}</span> culture.
                            @endif
                        </p>
                    </div>
                </div>
            </section>



                <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5 mb-8">
                    <h2 class="text-3xl font-bold text-[#00336E] tracking-tight mb-8 font-title">Alternate Definitions</h2>

                    @if($word->definitions->count() > 1)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                            @foreach($word->definitions->skip(1) as $definition)
                                <div class="bg-[#F3F6F9] rounded-[24px] p-6 flex flex-col justify-between h-full group/alt transition-all hover:bg-[#E8EEF5]">
                                    <p class="text-[#00336E] text-sm font-bold leading-relaxed mb-6">"{{ $definition->definition }}"</p>
                                    <div class="flex items-center gap-4 text-[#00336E]">
                                        @livewire('voting-counter', [
                                            'definitionId' => $definition->id,
                                            'agrees' => $definition->agrees,
                                            'disagrees' => $definition->disagrees
                                        ], key('alt-vote-'.$definition->id))
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mb-12 p-6 bg-[#F3F6F9] rounded-[24px] text-center">
                            <p class="text-[#00336E]/60 font-medium">No alternate definitions yet.</p>
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Your meaning of this word:</h3>
                    @livewire('add-definition', ['wordId' => $word->id])
                </section>

                <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5 mb-8">
                    <h3 class="text-xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Related Words</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($relatedWords as $related)
                            <a href="{{ route('word.show', $related->slug) }}" class="px-5 py-2.5 bg-slate-50 border border-slate-200/60 hover:border-brand-accent/30 hover:bg-brand-accent/5 hover:text-brand-accent rounded-full text-xs font-black uppercase tracking-widest text-[#00336E]/60 transition-all">
                                {{ $related->term }}
                            </a>
                        @empty
                            <span class="text-xs font-bold text-slate-400">No related words.</span>
                        @endforelse
                    </div>
                </section>

                <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5 mb-8">
                    <h3 class="text-3xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Context & Vibes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-[#00336E] text-sm font-medium mb-3">Subculture / Category:</p>
                            <div class="inline-flex items-center gap-3 px-5 py-3 bg-[#F3F6F9] rounded-2xl">
                                <span class="text-lg font-bold text-[#00336E] uppercase tracking-wide">{{ $word->category }}</span>
                            </div>
                        </div>
                        
                        @if($word->vibes && count($word->vibes) > 0)
                        <div>
                            <p class="text-[#00336E] text-sm font-medium mb-3">Vibes:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($word->vibes as $vibe)
                                    @if(!empty(trim($vibe)))
                                        <span class="text-xs font-bold text-white bg-[#00336E] px-4 py-2 rounded-xl shadow-sm">#{{ $vibe }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </section>

                <section class="premium-card reveal-on-scroll bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-[#00336E]/5 mb-8">
                    <h3 class="text-3xl font-bold text-[#00336E] tracking-tight mb-6 font-title">Word Origin / First Use</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-[#F3F6F9] rounded-[24px] p-8">
                            <p class="text-[#00336E] text-sm font-medium mb-2">Submitted originally by:</p>
                            <p class="text-[#00336E] text-xl font-bold font-title">{{ empty($word->submitted_by) || $word->submitted_by == 'Anonymous' ? 'Anonymous' : (Str::startsWith($word->submitted_by, '@') ? $word->submitted_by : '@' . $word->submitted_by) }}</p>
                        </div>
                        <div class="bg-[#F3F6F9] rounded-[24px] p-8">
                            <p class="text-[#00336E] text-sm font-medium mb-2">Date first submitted:</p>
                            <p class="text-[#00336E] text-xl font-bold font-title">{{ $word->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </section>



            <!-- Domain Advertisement Section -->
            <!-- Smart Domain Advertisement -->

        </div>
    </div>
    
    <livewire:tools.share-modal /> 
    <livewire:tools.report-modal />
    <livewire:tools.receipt-modal />
    <livewire:tools.domain-modal />
</x-layouts.app>
