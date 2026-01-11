<div class="mt-8">
    @if($summary)
        <!-- Display Summary -->
        <div class="p-5 bg-gradient-to-r from-violet-500/10 to-fuchsia-500/10 rounded-xl border border-violet-500/20 relative overflow-hidden group hover:border-violet-500/30 transition-colors">
            <!-- decorative blur -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-violet-500/20 blur-[50px] rounded-full pointer-events-none group-hover:bg-violet-500/30 transition-all"></div>

            <div class="flex items-center gap-2 mb-3 relative z-10">
                <span class="bg-gradient-to-r from-violet-600 to-fuchsia-600 text-transparent bg-clip-text text-xs font-black uppercase tracking-widest flex items-center gap-1">
                    <svg class="w-3 h-3 text-fuchsia-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/><path d="M12 6a1 1 0 0 0-1 1v4.32l-2.9 2.9a1 1 0 0 0 1.41 1.41l3.5-3.5a1 1 0 0 0 .29-.71V7a1 1 0 0 0-1-1z"/></svg>
                    AI Insight
                </span>
            </div>
            
            <p class="text-[#002B5B]/90 font-medium text-[15px] leading-relaxed relative z-10 mb-3">
                "{!! $summary !!}"
            </p>

            @if($word->vibes)
                <div class="flex flex-wrap gap-2 relative z-10">
                    @foreach($word->vibes as $vibe)
                        <a href="{{ route('word.browse', ['vibe' => $vibe]) }}" class="px-2.5 py-1 bg-white/40 border border-white/50 rounded-lg text-[11px] font-bold text-violet-700 hover:bg-white hover:scale-105 transition-all cursor-pointer">
                            #{{ $vibe }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- Generate Button (Admin or Demo Mode) -->
        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-center">
             <button wire:click="generate" wire:loading.attr="disabled" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-300 shadow-sm text-slate-600 text-sm font-bold rounded-full hover:bg-slate-50 hover:text-violet-600 hover:border-violet-200 transition-all">
                <span wire:loading.remove>
                    ✨ Generate AI Summary
                </span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-violet-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Thinking...
                </span>
             </button>
        </div>
    @endif
</div>
