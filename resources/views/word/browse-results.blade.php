<x-layouts.app>
    <section class="bg-[#002B5B] min-h-screen py-20 relative overflow-hidden">
        <!-- Background Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-violet-500/20 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-[1240px] mx-auto px-6 relative z-10">
            <!-- Header -->
            <div class="mb-12 text-center">
                <span class="inline-block py-1 px-4 rounded-full bg-white/10 text-white/80 text-sm font-bold tracking-widest uppercase mb-4 border border-white/20">
                    Vibe Check Search
                </span>
                <h1 class="text-5xl md:text-7xl font-bold text-white tracking-tight mb-4">
                    #{{ $vibe }}
                </h1>
                <p class="text-white/60 text-xl font-medium max-w-2xl mx-auto">
                    Words matching this specific energy.
                </p>
            </div>

            <!-- Grid -->
            @if($words->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($words as $word)
                         <a href="{{ route('word.show', $word->slug) }}" class="bg-white/5 border border-white/10 hover:border-violet-500/50 hover:bg-white/10 transition-all rounded-[24px] p-8 group relative overflow-hidden">
                            <!-- Card Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-violet-600/0 to-violet-600/0 group-hover:to-violet-600/10 transition-all duration-500"></div>
                            
                            <!-- Badges -->
                            <div class="flex items-center gap-2 mb-4 relative z-10">
                                <span class="px-3 py-1 bg-white/10 text-white text-[11px] font-bold rounded-full">{{ $word->category }}</span>
                                <span class="px-2 py-1 bg-violet-500/20 text-violet-200 text-[10px] font-bold rounded-md border border-violet-500/30">#{{ $vibe }}</span>
                            </div>

                            <h3 class="text-3xl font-bold text-white mb-3 tracking-tight group-hover:text-violet-200 transition-colors relative z-10">{{ $word->term }}</h3>
                            
                            <p class="text-white/70 text-[15px] leading-relaxed mb-6 font-medium line-clamp-3 relative z-10">
                                {{ optional($word->primaryDefinition)->definition ?? 'No definition available.' }}
                            </p>
                            
                            <div class="flex items-center justify-between text-white/50 text-xs font-bold relative z-10">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    {{ number_format($word->views) }}
                                </div>
                                <span>{{ $word->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <div class="mt-12">
                    {{ $words->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <div class="text-6xl mb-4">👻</div>
                    <h3 class="text-2xl font-bold text-white mb-2">No words found for this vibe.</h3>
                    <p class="text-white/50">Maybe you should submit one?</p>
                    <a href="{{ route('word.create') }}" class="inline-block mt-6 px-6 py-3 bg-violet-600 hover:bg-violet-500 text-white font-bold rounded-full transition-colors">Submit a Word</a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
