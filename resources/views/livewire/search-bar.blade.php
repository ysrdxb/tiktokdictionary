<div class="relative w-full">
    <!-- Search Input -->
    <div class="relative group/input">
        <input
            wire:model.live.debounce.300ms="query"
            type="text"
            class="block w-full px-8 pr-16 py-6 text-[17px] bg-white text-[#00336E] placeholder-[#00336E]/40 rounded-full shadow-[0_10px_40px_rgba(0,51,110,0.1)] border-2 border-transparent focus:border-[#00336E]/20 focus:ring-4 focus:ring-[#00336E]/5 focus:outline-none transition-all duration-300 font-medium"
            placeholder="What does 'delulu' mean?"
        >

        <div class="absolute inset-y-0 right-0 pr-8 flex items-center">
            <svg class="h-6 w-6 text-[#00336E]/60 group-focus-within/input:text-[#00336E] transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Results Dropdown -->
    @if($showResults && strlen($query) > 0)
    <div class="absolute z-50 mt-4 w-full bg-white/80 rounded-3xl shadow-[0_20px_60px_rgba(0,51,110,0.15)] border border-[#00336E]/5 overflow-hidden backdrop-blur-3xl">
        <div class="max-h-[60vh] overflow-y-auto"> <!-- Added scroll container -->
        @if($results->isNotEmpty())
            <div class="py-4">
                <div class="px-8 py-2 text-[10px] font-black text-[#00336E]/40 uppercase tracking-[0.2em]">Top Results</div>
                @foreach($results as $word)
                    <a href="{{ route('word.show', $word->slug) }}" class="flex items-center gap-4 px-8 py-4 hover:bg-[#00336E]/5 transition-all group">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#00336E]/5 text-[#00336E] flex items-center justify-center font-black text-sm group-hover:bg-[#00336E] group-hover:text-white transition-all">
                            {{ strtoupper(substr($word->term, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[15px] font-bold text-[#00336E] truncate group-hover:translate-x-1 transition-all">{{ $word->term }}</p>
                            <p class="text-xs text-[#00336E]/50 truncate font-medium">{{ optional($word->primaryDefinition)->definition ?? 'No definition yet.' }}</p>
                        </div>
                        <svg class="h-4 w-4 text-[#00336E]/20 group-hover:text-[#00336E] transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endforeach
            </div>
            <div class="bg-[#00336E]/5 px-8 py-4 text-center border-t border-[#00336E]/5">
                <a href="{{ route('word.search', ['q' => $query]) }}" class="text-xs font-black text-[#00336E] hover:underline uppercase tracking-widest">
                    See all results for "{{ $query }}" →
                </a>
            </div>
        @else
            <div class="px-8 py-10 text-center">
                <div class="w-14 h-14 bg-[#00336E]/5 rounded-full flex items-center justify-center mx-auto mb-4 text-[#00336E]/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-sm font-black text-[#00336E] mb-4">No results found</h3>
                <a href="{{ route('word.create', ['term' => $query]) }}" class="inline-flex items-center justify-center px-8 py-3 bg-[#00336E] text-white text-xs font-black rounded-xl hover:bg-blue-800 transition-all uppercase tracking-widest shadow-lg">
                    + Submit "{{ $query }}"
                </a>
            </div>
        @endif
    </div>
    </div>
    @endif
</div>
