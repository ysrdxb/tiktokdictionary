<div class="relative z-20" x-data="{ open: false }" @click.outside="open = false">
    @php
        $topReactionKey = null;
        $maxCount = 0;
        // Filter out zero counts just in case
        $activeCounts = array_filter($counts, fn($c) => $c > 0);
        if(!empty($activeCounts)) {
            $maxCount = max($activeCounts);
            // Get keys with max count
            $topKeys = array_keys($activeCounts, $maxCount);
            // Default to first usually, or preferred logic
            $topReactionKey = $topKeys[0] ?? null;
        }

        // Logic: Show User selection if exists, otherwise show Top Reaction
        $displayKey = $userReaction ?? $topReactionKey;
        $displayCount = $displayKey ? ($counts[$displayKey] ?? 0) : 0;
        
        $emojiMap = ['fire'=>'🔥', 'skull'=>'💀', 'melt'=>'🫠', 'clown'=>'🤡'];
        $displayEmoji = $displayKey ? ($emojiMap[$displayKey] ?? '') : '';
    @endphp

    <!-- Trigger Button -->
    <button @click="open = !open" 
            class="flex items-center justify-center h-12 hover:bg-slate-50 rounded-full transition-all text-[#00336E] group relative {{ $displayEmoji ? 'w-auto px-4 gap-3 bg-white border border-slate-100 shadow-sm' : 'w-12' }}"
            title="React">
        @if($displayEmoji)
            <span class="text-2xl leading-none filter drop-shadow-sm transform group-hover:scale-110 transition-transform">
                {{ $displayEmoji }}
            </span>
            <span class="text-sm font-bold text-[#00336E]">{{ number_format($displayCount) }}</span>
        @else
            <svg class="w-6 h-6 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        @endif
    </button>

    <!-- Vertical Reaction Menu -->
    <div x-show="open" 
         x-cloak
         style="display: none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="absolute bottom-full left-1/2 -translate-x-1/2 mb-4 flex flex-col-reverse gap-3 bg-white rounded-full shadow-[0_10px_40px_-5px_rgba(0,0,0,0.15)] border border-slate-100 p-2 pb-3 z-50 min-w-[3.5rem] items-center">
         
         @foreach(['fire' => '🔥', 'skull' => '💀', 'melt' => '🫠', 'clown' => '🤡'] as $key => $emoji)
            <button wire:click="react('{{ $key }}'); open = false" 
                    title="{{ ucfirst($key) }}"
                    class="w-10 h-10 flex items-center justify-center text-3xl hover:bg-slate-50 rounded-full transition-all transform hover:scale-125 focus:outline-none relative">
                {{ $emoji }}
                @if(isset($counts[$key]) && $counts[$key] > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-[#00336E] text-[9px] font-bold text-white shadow-sm ring-2 ring-white">
                        {{ $counts[$key] > 99 ? '99+' : $counts[$key] }}
                    </span>
                @endif
            </button>
         @endforeach
    </div>
</div>
