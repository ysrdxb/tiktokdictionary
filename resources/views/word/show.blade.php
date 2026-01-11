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

    <div class="pb-0">
        
        <!-- Word Card (Main Definition) -->
        <section class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm mb-6">
            <!-- Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-[#002B5B] tracking-tight leading-none mb-5 break-words">
                {{ $word->term }}
            </h1>

            @if($primaryDef)
                <!-- Definition -->
                <p class="text-[#002B5B] text-base md:text-lg leading-relaxed font-medium mb-2">
                    {{ $primaryDef->definition }}
                </p>

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

             <!-- AI Combined Summary (Placeholder) -->
             <div class="mt-8 p-4 bg-brand-primary/5 rounded-xl border border-brand-primary/10">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-transparent bg-clip-text text-xs font-bold uppercase tracking-wider">AI Insight</span>
                    <svg class="w-3 h-3 text-purple-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/><path d="M12 6a1 1 0 0 0-1 1v4.32l-2.9 2.9a1 1 0 0 0 1.41 1.41l3.5-3.5a1 1 0 0 0 .29-.71V7a1 1 0 0 0-1-1z"/></svg>
                </div>
                <p class="text-sm text-[#002B5B]/80 italic">
                    "This term is currently spiking in usage due to a viral sound. Most users agree it refers to `{{ Str::limit($primaryDef->definition ?? '...', 50) }}` but context varies by subculture."
                </p>
             </div>
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
             <div class="absolute top-0 right-0 w-64 h-64 bg-brand-accent/20 blur-[80px] rounded-full pointer-events-none"></div>
             
             <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                     <h3 class="text-2xl md:text-3xl font-bold font-[GRIFTER] mb-2">Investor View</h3>
                     <p class="text-white/80 font-medium">This word is trending. Is the domain available?</p>
                </div>
                
                <div x-data="{ checking: false }" class="w-full md:w-auto">
                    <button 
                        @click="checking = true; setTimeout(() => window.location.href='https://godaddy.com/domain-search/results?searchterms={{ $word->term }}', 1500)"
                        class="w-full md:w-auto px-8 py-4 bg-white text-[#002B5B] font-bold rounded-xl hover:scale-105 transition-transform flex items-center justify-center gap-3"
                    >
                        <span x-show="!checking">Check {{ $word->term }}.com</span>
                        <span x-show="checking" class="flex items-center gap-2">
                             <svg class="animate-spin h-5 w-5 text-[#002B5B]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                             </svg>
                             Checking...
                        </span>
                    </button>
                    <p class="text-xs text-center md:text-right mt-2 text-white/40">Powered by GoDaddy</p>
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

        <!-- Report Button -->
        <div class="mb-12">
            <button class="px-6 py-2.5 bg-white border border-[#002B5B] text-[#002B5B] font-medium rounded-full hover:bg-slate-50 transition-colors text-sm">
                Report
            </button>
        </div>
    </div>

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
