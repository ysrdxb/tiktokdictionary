<x-layouts.app>
    <x-slot:title>
        {{ $word->term }} - TikTokDictionary
    </x-slot>

    <x-slot:headerDark>
        true
    </x-slot>

    @php
        $primaryDef = $word->definitions->first();
        $relatedWords = $word->getRelatedWords(4);
    @endphp

    <div class="max-w-[1240px] mx-auto px-6 pb-0">
        
        <!-- Word Card (Main Definition) -->
        <section class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm mb-6">
            <!-- Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-[#002B5B] tracking-tight leading-none mb-5 break-words">
                {{ $word->term }}
            </h1>

            @if($primaryDef)
                <!-- Definition -->
                <p class="text-[#002B5B] text-base md:text-lg leading-relaxed font-medium mb-4">
                    {{ $primaryDef->definition }}
                </p>

                <!-- Audio Player (Alpine + Puter.js) -->
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
                }" class="mb-6">
                    <button 
                        @click="playAudio('{{ addslashes($word->term) }}: {{ addslashes($primaryDef->definition) }}')"
                        :class="playing ? 'bg-pink-500 animate-pulse border-pink-500' : 'bg-slate-100 hover:bg-slate-200 border-slate-200'"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold text-[#002B5B] transition-all border"
                    >
                        <span x-show="!playing" class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg> 
                            Listen
                        </span>
                        <span x-show="playing" class="flex items-center gap-1.5" x-cloak>
                            <svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                            Playing...
                        </span>
                    </button>
                </div>

                @if($primaryDef->example)
                    <!-- Example -->
                    <p class="text-[#002B5B]/70 text-base mb-6 font-medium">Example: "{{ $primaryDef->example }}"</p>
                @endif

                <!-- Voting (Interactive Livewire Component) -->
                <div class="flex items-center">
                    @livewire('voting-counter', [
                        'definitionId' => $primaryDef->id,
                        'agrees' => $primaryDef->agrees,
                        'disagrees' => $primaryDef->disagrees
                    ], key('primary-vote-'.$primaryDef->id))
                </div>
            @endif

             <!-- AI Combined Summary -->
             @livewire('tools.ai-summary', ['word' => $word])
        </section>

        <!-- Investor Dashboard (TikTok Market Section) -->
        <section class="mb-6">
            @livewire('tools.investor-dashboard', ['word' => $word])
        </section>

        <!-- Alternate Definitions Section -->
        @if($word->definitions->count() > 1)
            <section class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm mb-6">
                <h2 class="text-3xl md:text-4xl font-bold text-[#002B5B] tracking-tight mb-8">Alternate Definitions</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-12">
                    @foreach($word->definitions->skip(1)->take(3) as $definition)
                        <div class="bg-[#F0F6FB] rounded-[16px] p-5 flex flex-col h-full">
                            <p class="text-[#002B5B] text-sm leading-relaxed font-medium mb-4 flex-grow">
                                "{{ Str::limit($definition->definition, 80) }}"
                            </p>
                            <div class="flex items-center">
                                @livewire('voting-counter', [
                                    'definitionId' => $definition->id,
                                    'agrees' => $definition->agrees,
                                    'disagrees' => $definition->disagrees
                                ], key('alt-vote-'.$definition->id))
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Your Meaning Section -->
                <h2 class="text-2xl md:text-3xl font-bold text-[#002B5B] tracking-tight mb-5">Your meaning of this word:</h2>
                @livewire('add-definition', ['wordId' => $word->id])
            </section>
        @else
            <!-- Standalone Your Meaning Section -->
            <section id="contribute" class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-[#002B5B] tracking-tight mb-5">Your meaning of this word:</h2>
                @livewire('add-definition', ['wordId' => $word->id])
            </section>
        @endif

        <!-- Related Words -->
        <section class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm mb-6">
            <h3 class="text-2xl md:text-3xl font-bold text-[#002B5B] tracking-tight mb-6">Related Words</h3>
            @if($relatedWords->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($relatedWords as $related)
                        <a href="{{ route('word.show', $related->slug) }}" wire:navigate class="px-5 py-4 bg-[#F0F6FB] hover:bg-[#E2E8F0] text-[#002B5B] font-medium rounded-[12px] transition-colors text-sm text-center">
                            {{ $related->term }}
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-sm font-medium text-[#002B5B]/50">No related words yet.</div>
            @endif
        </section>

        <!-- Word Origin / First Use -->
        <section class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm mb-6">
            <h3 class="text-2xl md:text-3xl font-bold text-[#002B5B] tracking-tight mb-6">Word Origin / First Use</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-[#F0F6FB] rounded-[16px] p-5">
                    <div class="text-sm text-[#002B5B]/70 mb-1">Submitted originally by:</div>
                    <div class="text-[#002B5B] font-bold text-lg">{{ $primaryDef->submitted_by ?? '@username' }}</div>
                </div>
                <div class="bg-[#F0F6FB] rounded-[16px] p-5">
                    <div class="text-sm text-[#002B5B]/70 mb-1">Date first submitted:</div>
                    <div class="text-[#002B5B] font-bold text-lg">{{ $word->created_at ? $word->created_at->format('d M Y') : '18 Jul 2025' }}</div>
                </div>
            </div>
        </section>

        <!-- Investor Block (Domain Check) -->
        <section class="bg-[#002B5B] rounded-[32px] p-8 md:p-10 shadow-lg mb-6 text-white relative overflow-hidden">
             <!-- Background Effect -->
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

        <!-- Lore Timeline -->
        <section class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm mb-6">
            <h3 class="text-2xl md:text-3xl font-bold text-[#002B5B] tracking-tight mb-6 flex items-center gap-3">
                Lore Timeline
                <span class="text-xs bg-[#F0F6FB] text-[#002B5B] px-3 py-1 rounded-full uppercase tracking-wider font-bold">Chronology</span>
            </h3>
            
            @if($word->lore->count() > 0)
                <div class="relative border-l-2 border-[#F0F6FB] ml-3 pl-8 py-2 space-y-8">
                    @foreach($word->lore as $entry)
                        <div class="relative">
                            <span class="absolute -left-[41px] top-1 h-5 w-5 rounded-full border-4 border-white bg-[#002B5B]"></span>
                            <div class="text-sm text-[#002B5B]/50 font-bold mb-1">{{ $entry->date_event ? $entry->date_event->format('M Y') : 'Unknown Date' }}</div>
                            <h4 class="text-lg font-bold text-[#002B5B] mb-2">{{ $entry->title }}</h4>
                            <p class="text-[#002B5B]/80 font-medium leading-relaxed">{{ $entry->description }}</p>
                            @if($entry->source_url)
                                <a href="{{ $entry->source_url }}" target="_blank" class="inline-block mt-3 text-xs font-bold text-brand-primary uppercase tracking-wide hover:underline">View Source ↗</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-[#F0F6FB] rounded-xl p-8 text-center">
                    <p class="text-[#002B5B]/60 font-medium mb-4">No lore history documented yet.</p>
                </div>
            @endif
        </section>

        <!-- Sticker Generator & Report -->
        <div class="mb-12 flex flex-col items-center gap-4">
            <x-tools.sticker-generator :word="$word" :definition="$primaryDef->definition ?? ''" />

            <button onclick="Livewire.dispatch('openReportModal', { type: 'word', id: {{ $word->id }} })" class="text-xs font-bold text-slate-300 hover:text-red-400 flex items-center justify-center gap-1 mx-auto transition-colors">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h10a2 2 0 012 2v8m2-2a2 2 0 00-2-2H5a2 2 0 00-2 2m0-10V5a2 2 0 012-2h6.19a2 2 0 011.85.93l.3.38a2 2 0 001.7 1.07h2.9A2 2 0 0121 7v6a2 2 0 01-2 2h-6.19a2 2 0 01-1.85-.93l-.3-.38a2 2 0 00-1.7-1.07H5a2 2 0 01-2-2"></path></svg>
                 Report this Word
            </button>
        </div>
    </div>
    
    <!-- Report Modal (Global) -->
    @livewire('tools.report-modal')

    <!-- Submit a Word Section (Dark Navy) -->
    <section class="bg-[#002B5B] py-16 text-center">
        <div class="max-w-2xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-4" style="">Submit a Word</h2>
            <p class="text-white/70 mb-8 text-base font-medium">Saw a new TikTok word? Add it before it blows up.</p>
            
            <a href="{{ route('word.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#002B5B] font-bold rounded-full hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Submit a New Word
            </a>
            
            <p class="text-white/50 text-sm mt-6 font-medium">It only takes a minute to add a definition</p>
        </div>
    </section>
</x-layouts.app>
