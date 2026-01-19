<div class="fixed inset-0 bg-[#011a3b] z-[100] overflow-y-scroll snap-y snap-mandatory scroll-smooth hide-scrollbar" 
     id="feed-container"
     x-data="{ active: 0 }"
     @scroll.throttle.10ms="active = Math.round($el.scrollTop / window.innerHeight)">
    
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .live-feed-view, .live-feed-view * {
            letter-spacing: 0 !important;
        }

        .prof-card {
            background: #002B5C;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            position: relative;
        }
    </style>

    <div class="live-feed-view">
        <div class="fixed top-0 left-0 w-full p-6 md:p-10 flex justify-between items-center z-[130] pointer-events-none">
            <div class="flex items-center gap-4 pointer-events-auto">
                <div class="px-5 py-2.5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-xl shadow-lg flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#FFB703] animate-pulse"></div>
                    <span class="text-white font-bold text-lg uppercase">Live Feed</span>
                </div>
            </div>
            
            <a href="{{ route('home') }}" class="w-12 h-12 bg-white/10 backdrop-blur-xl rounded-xl text-white flex items-center justify-center hover:bg-[#FFB703] hover:text-[#00336E] transition-all border border-white/20 pointer-events-auto shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        </div>

        <div wire:init="load">
            @if(empty($items))
                <div class="h-screen w-full flex items-center justify-center bg-[#011a3b]">
                    <div class="w-10 h-10 border-4 border-[#FFB703] border-t-transparent rounded-full animate-spin"></div>
                </div>
            @else
                @foreach($items as $index => $word)
                    <div class="h-screen w-full flex flex-col items-center justify-center snap-start relative px-4 md:px-12 bg-[#011a3b]" 
                         wire:key="feed-word-{{ $word->id }}"
                         x-data="{ visible: false }"
                         x-intersect.full="visible = true"
                         x-intersect:leave="visible = false">
                        
                        <div class="relative z-10 w-full max-w-4xl prof-card rounded-[40px] p-8 md:p-12 flex flex-col items-center transition-all duration-500"
                             :class="active === {{ $index }} ? 'opacity-100 scale-100' : 'opacity-0 scale-98'">
                            
                            <div class="absolute top-6 right-6 md:top-10 md:right-10">
                                <a href="{{ route('word.show', $word->slug) }}" 
                                   class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-white/40 hover:text-[#FFB703] transition-all group"
                                   title="View Dictionary Entry">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>

                            <div class="flex items-center gap-2 mb-6">
                                @if(isset($word->feed_label))
                                    <span class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $word->feed_label === 'HOT' ? 'bg-red-600/80 text-white' : 'bg-[#FFB703] text-[#00336E]' }}">
                                        {{ $word->feed_label }}
                                    </span>
                                @endif
                                <span class="px-4 py-1.5 rounded-lg bg-white/5 border border-white/10 text-white/30 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $word->category }}
                                </span>
                            </div>

                            <div class="w-full mb-6">
                                <h1 class="text-white font-title font-bold uppercase leading-[1] text-center break-words"
                                    style="font-size: clamp(2.2rem, 7vw, 6rem);">
                                    {{ $word->term }}
                                </h1>
                            </div>

                            @if($word->primaryDefinition)
                                <div class="w-full max-w-3xl mb-10 text-center">
                                    <p class="text-xl md:text-3xl text-white font-medium leading-snug mb-6 opacity-95 text-balance">
                                        "{{ $word->primaryDefinition->definition }}"
                                    </p>
                                    @if($word->primaryDefinition->example)
                                        <div class="py-3 px-6 rounded-xl bg-white/5 border border-white/10 text-white/30 text-xs md:text-base font-medium italic inline-block">
                                            {{ $word->primaryDefinition->example }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="w-full pt-8 border-t border-white/5 flex items-center justify-center gap-6">
                                <div x-data="{ 
                                    playing: false,
                                    async playAudio(text) {
                                        if(this.playing) return;
                                        this.playing = true;
                                        try {
                                            const audio = await puter.ai.txt2speech(text, { voice: 'Kimberly', speed: 1.1 });
                                            audio.onended = () => { this.playing = false; };
                                            audio.play();
                                        } catch (error) { this.playing = false; }
                                    }
                                }">
                                    <button @click="playAudio('{{ addslashes($word->term) }}: {{ addslashes($word->primaryDefinition->definition ?? 'No definition.') }}')"
                                            :class="playing ? 'bg-white/10 text-[#FFB703] scale-110 border-[#FFB703]/30' : 'bg-white/10 text-white/50 hover:text-white hover:bg-white/20 border-white/10'"
                                            class="w-12 h-12 flex items-center justify-center rounded-xl border transition-all active:scale-95 group">
                                        <!-- Standard Speaker Icon -->
                                        <svg x-show="!playing" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5l-5 4H2v6h4l5 4V5zM15.54 8.46a5 5 0 010 7.08M19.07 4.93a10 10 0 010 14.14"></path>
                                        </svg>
                                        
                                        <!-- Equalizer -->
                                        <div x-show="playing" class="flex items-center gap-1 h-5">
                                            <span class="w-1 h-3 bg-[#FFB703] rounded-full animate-[bounce_0.8s_infinite]"></span>
                                            <span class="w-1 h-5 bg-[#FFB703] rounded-full animate-[bounce_1.0s_infinite]"></span>
                                            <span class="w-1 h-3 bg-[#FFB703] rounded-full animate-[bounce_1.2s_infinite]"></span>
                                            <span class="w-1 h-5 bg-[#FFB703] rounded-full animate-[bounce_0.9s_infinite]"></span>
                                        </div>
                                    </button>
                                </div>

                                @if($word->primaryDefinition)
                                    <div class="flex items-center bg-white/5 rounded-2xl px-3 py-1.5 border border-white/10">
                                        @livewire('voting-counter', [
                                            'definitionId' => $word->primaryDefinition->id,
                                            'agrees' => $word->primaryDefinition->agrees,
                                            'disagrees' => $word->primaryDefinition->disagrees
                                        ], key('feed-vote-'.$word->id))
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-12 transition-all duration-700"
                             :class="active === {{ $index }} ? 'opacity-100' : 'opacity-0 translate-y-4'">
                            <button 
                                @click="document.getElementById('feed-container').scrollBy({top: window.innerHeight, behavior: 'smooth'})"
                                class="w-14 h-14 rounded-full bg-[#FFB703] text-[#00336E] flex items-center justify-center hover:bg-white transition-all shadow-2xl active:scale-90 group">
                                <svg class="w-6 h-6 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                            </button>
                        </div>
                    </div>
                @endforeach

                @if($this->hasMore)
                    <div x-intersect.margin.100%="$wire.loadMore()" class="h-40 w-full flex items-center justify-center bg-[#011a3b] opacity-10">
                         <div class="w-6 h-6 border-2 border-white/40 border-t-white rounded-full animate-spin"></div>
                    </div>
                @else
                    <div class="h-screen w-full flex flex-col items-center justify-center bg-[#011a3b] text-white text-center">
                        <div class="max-w-xl px-10">
                            <h2 class="text-4xl md:text-5xl font-title font-bold mb-8 uppercase tracking-tighter">You're All Caught Up</h2>
                            <a href="{{ route('home') }}" class="px-12 py-4 rounded-xl bg-[#FFB703] text-[#00336E] font-bold text-sm uppercase transition-all shadow-lg active:scale-95">
                                Home
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
