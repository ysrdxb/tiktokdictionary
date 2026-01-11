<div class="relative w-full">
    <!-- Search Input (Exact Figma Sizing) -->
    <div class="relative">
        <input
            wire:model.live.debounce.300ms="query"
            type="text"
            class="block w-full px-7 pr-16 py-5 text-[15px] bg-white border-0 text-[#002B5B] placeholder-slate-400 rounded-full shadow-[0_4px_30px_rgba(0,0,0,0.08)] focus:ring-2 focus:ring-[#002B5B]/10 focus:outline-none transition-all"
            placeholder="What does 'delulu' mean?"
        >

        <div class="absolute inset-y-0 right-0 pr-6 flex items-center">
            <svg class="h-5 w-5 text-[#002B5B]/40" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Results Dropdown -->
    @if($showResults && strlen($query) > 0)
    <div class="absolute z-50 mt-2 w-full bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        @if($results->isNotEmpty())
            <div class="py-2">
                <div class="px-5 py-2 text-xs font-bold text-slate-400 uppercase tracking-wide">Top Results</div>
                @foreach($results as $word)
                    <a href="{{ route('word.show', $word->slug) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition-colors">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-50 text-[#002B5B] flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr($word->term, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-[#002B5B] truncate">{{ $word->term }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ optional($word->primaryDefinition)->definition ?? 'No definition yet.' }}</p>
                        </div>
                        <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endforeach
            </div>
            <div class="bg-slate-50 px-5 py-3 text-center border-t border-slate-100">
                <a href="{{ route('word.browse') }}" class="text-sm font-bold text-[#0F62FE] hover:underline">
                    See all results for "{{ $query }}" →
                </a>
            </div>
        @else
            <div class="px-6 py-8 text-center">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-sm font-bold text-[#002B5B] mb-1">No results found</h3>
                <p class="text-xs text-slate-500">We couldn't find "{{ $query }}". Want to add it?</p>
            </div>
        @endif
    </div>
    @endif
</div>
