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
                        </button>
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
    
    <!-- Report Modal (Global) -->
    @livewire('tools.report-modal')

    <!-- Section 9: Submit a Word (Dark Navy) -->
    <x-sections.submit-cta />
    <!-- Report Modal Component -->
    <livewire:report-modal />
</x-layouts.app>
