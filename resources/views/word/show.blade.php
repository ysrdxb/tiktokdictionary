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
