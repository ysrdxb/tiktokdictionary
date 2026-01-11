<div class="fixed inset-0 bg-[#002B5B] z-[100] overflow-y-scroll snap-y snap-mandatory scroll-smooth">
    
    <!-- Close Button -->
    <a href="{{ route('home') }}" class="fixed top-6 right-6 z-[110] p-3 bg-white/10 backdrop-blur-md rounded-full text-white hover:bg-white/20 transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </a>

    <!-- Keyboard Nav Script -->
    <script>
        document.addEventListener('keydown', function(e) {
            const container = document.querySelector('.snap-y');
            const h = window.innerHeight;
            if (e.key === 'ArrowDown') container.scrollBy({top: h, behavior: 'smooth'});
            if (e.key === 'ArrowUp') container.scrollBy({top: -h, behavior: 'smooth'});
        });
    </script>
    
    <div wire:init="load">
        @if(empty($items))
            <!-- Initial Loading State -->
            <div class="h-screen w-full flex items-center justify-center snap-start">
               <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-brand-accent"></div>
            </div>
        @else
            @foreach($items as $word)
                <div class="h-screen w-full flex items-center justify-center snap-start relative px-4" wire:key="feed-word-{{ $word->id }}">
                    <!-- Background Elements -->
                    <div class="absolute inset-0 overflow-hidden pointer-events-none">
                        <div class="absolute top-[20%] right-[10%] w-96 h-96 bg-brand-primary/20 rounded-full blur-[100px]"></div>
                        <div class="absolute bottom-[20%] left-[10%] w-64 h-64 bg-brand-secondary/20 rounded-full blur-[80px]"></div>
                    </div>

                    <!-- Card Content -->
                    <div class="relative z-10 w-full max-w-lg bg-white/5 backdrop-blur-lg border border-white/10 rounded-[32px] p-8 md:p-12 text-center shadow-2xl">
                        
                        <!-- Category Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/10 text-white/80 text-sm font-bold mb-8">
                            <span>{{ $word->category }}</span>
                        </div>

                        <!-- Word -->
                        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 drop-shadow-lg tracking-tight break-words">
                            {{ $word->term }}
                        </h1>

                        <!-- Audio Player (Puter.js + Alpine) -->
                        <div x-data="{ 
                            playing: false,
                            async playAudio(text) {
                                if(this.playing) return;
                                this.playing = true;
                                try {
                                    const audio = await puter.ai.txt2speech(text, {
                                        voice: 'Kimberly',
                                        speed: 1.1
                                    });
                                    audio.onended = () => { this.playing = false; };
                                    audio.play();
                                } catch (error) {
                                    console.error('Audio failed:', error);
                                    this.playing = false;
                                }
                            }
                        }" class="flex justify-center mb-6">
                            <button 
                                @click="playAudio('{{ addslashes($word->term) }}: {{ addslashes($word->primaryDefinition->definition ?? 'No definition.') }}')"
                                :class="playing ? 'bg-pink-500 animate-pulse text-white' : 'bg-white/10 text-white hover:bg-white/20'"
                                class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold transition-all border border-white/10 backdrop-blur-sm"
                            >
                                <span x-show="!playing" class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg> 
                                    Listen
                                </span>
                                <span x-show="playing" class="flex items-center gap-2" x-cloak>
                                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                    Playing...
                                </span>
                            </button>
                        </div>

                        @if($word->primaryDefinition)
                            <!-- Definition -->
                            <p class="text-xl md:text-2xl text-white/90 font-medium leading-relaxed mb-4">
                                "{{ $word->primaryDefinition->definition }}"
                            </p>
                            
                            @if($word->primaryDefinition->example)
                                <p class="text-white/60 text-lg italic mb-8">
                                    Example: "{{ $word->primaryDefinition->example }}"
                                </p>
                            @endif

                            <!-- Voting -->
                            <div class="flex items-center justify-center scale-125 my-8">
                                @livewire('voting-counter', [
                                    'definitionId' => $word->primaryDefinition->id,
                                    'agrees' => $word->primaryDefinition->agrees,
                                    'disagrees' => $word->primaryDefinition->disagrees
                                ], key('feed-vote-'.$word->id))
                            </div>
                        @else
                            <p class="text-white/50 italic mb-8">No definition yet.</p>
                        @endif
                        
                        <!-- Swipe Hint -->
                        <div class="absolute bottom-6 left-0 w-full flex justify-center animate-bounce text-white/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Infinite Loading Indicator (Trigger) -->
            @if($this->hasMore)
                <div x-intersect="$wire.loadMore()" class="h-20 w-full flex items-center justify-center snap-start">
                     <div class="flex items-center gap-2 text-white/50 text-sm font-bold">
                        <div wire:loading wire:target="loadMore" class="animate-spin rounded-full h-4 w-4 border-t-2 border-b-2 border-white/50"></div>
                        <span>Loading more vibes...</span>
                     </div>
                </div>
            @else
                <div class="h-screen w-full flex flex-col items-center justify-center snap-start text-white text-center px-6">
                    <h2 class="text-3xl font-black mb-4">You've reached the end! 🎬</h2>
                    <p class="text-white/60 font-medium mb-8">You're officially caught up on all the slang.</p>
                    <a href="{{ route('word.create') }}" class="px-8 py-4 bg-white text-[#002B5B] font-bold rounded-full hover:bg-slate-200 transition-colors">
                        Submit a New Word
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>
