@props([
    'items' => [] // Collection of Words
])

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4 auto-rows-[200px]">
    @foreach($items as $index => $word)
        @php
            // The first item is arguably the biggest trend
            $isHero = ($index === 0);
            $size = $isHero ? 'xl' : 'md';
            
            // Neon pulse if it's a "Polar Trend"
            $variant = $word->is_polar_trend ? 'neon' : ($index % 3 == 0 ? 'solid' : 'glass');
        @endphp
        
        <x-ui.card 
            :size="$size" 
            :variant="$variant"
            class="group cursor-pointer hover:-translate-y-1 transition-transform"
            wire:navigate
            href="{{ route('word.show', $word->slug) }}"
        >
            <div class="flex flex-col h-full justify-between relative z-20">
                <!-- Header -->
                <div class="flex justify-between items-start">
                    <x-ui.badge variant="{{ $word->is_polar_trend ? 'polar' : 'neutral' }}">
                        {{ $word->is_polar_trend ? 'POLAR TREND' : $word->category }}
                    </x-ui.badge>
                    
                    @if($word->views > 0)
                        <div class="flex items-center gap-1 text-[10px] text-gray-400 font-mono">
                            <span class="relative flex h-2 w-2">
                                @if($word->is_polar_trend)
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                @endif
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            {{ number_format($word->views) }}
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="mt-4">
                    <h3 class="font-[GRIFTER] text-white {{ $isHero ? 'text-4xl' : 'text-xl' }} leading-none mb-2">
                        {{ $word->term }}
                    </h3>
                    <p class="text-white/60 text-sm line-clamp-3 font-[Outfit]">
                        {{ $word->primaryDefinition->content ?? 'No definition yet.' }}
                    </p>
                </div>

                <!-- Footer / Micro interaction -->
                <div class="mt-4 flex justify-between items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <span class="text-brand-primary text-xs font-bold uppercase tracking-wider">View Word →</span>
                    
                     <!-- Domain Checker Mini -->
                     <button class="flex items-center gap-1 px-2 py-1 rounded bg-white/5 hover:bg-white/10 border border-white/5 transition-colors group/btn" 
                             @click.stop.prevent="window.location.href='https://godaddy.com/domain-search/results?searchterms={{ $word->term }}'">
                        <span class="text-[10px] font-mono text-white/40 group-hover/btn:text-white/80">Available?</span>
                     </button>
                </div>
            </div>
            
            <!-- Hero Overlay -->
            @if($isHero)
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-transparent to-transparent pointer-events-none"></div>
            @endif
        </x-ui.card>
    @endforeach
</div>
