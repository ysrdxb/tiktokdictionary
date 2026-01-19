<x-layouts.app>
    <section class="bg-slate-50 dark:bg-[#00336E] min-h-screen py-20 relative overflow-hidden transition-colors duration-300">
        <!-- Background Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-violet-500/10 dark:bg-violet-500/20 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-[1240px] mx-auto px-6 relative z-10">
            <!-- Header -->
            <div class="mb-12 text-center">
                <span class="inline-block py-1 px-4 rounded-full bg-[#00336E]/10 dark:bg-white/10 text-[#00336E] dark:text-white/80 text-sm font-bold tracking-widest uppercase mb-4 border border-[#00336E]/10 dark:border-white/20">
                    Vibe Check Search
                </span>
                <h1 class="text-5xl md:text-7xl font-bold text-[#00336E] dark:text-white tracking-tight mb-4">
                    #{{ $vibe }}
                </h1>
                <p class="text-[#00336E]/60 dark:text-white/60 text-xl font-medium max-w-2xl mx-auto">
                    Words matching this specific energy.
                </p>
            </div>

            <!-- Grid -->
            @if($words->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($words as $word)
                         <a href="{{ route('word.show', $word->slug) }}" class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 hover:border-brand-accent/50 hover:shadow-lg dark:hover:bg-white/10 transition-all rounded-[24px] p-8 group relative overflow-hidden">
                            <!-- Card Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#FFB703]/0 to-[#FFB703]/0 group-hover:to-[#FFB703]/5 dark:group-hover:to-[#FFB703]/10 transition-all duration-500"></div>
                            
                            <!-- Badges -->
                            <div class="flex items-center gap-2 mb-4 relative z-10">
                                <span class="px-3 py-1 bg-slate-100 dark:bg-white/10 text-[#00336E] dark:text-white text-[11px] font-bold rounded-full border border-slate-200 dark:border-transparent">{{ $word->category }}</span>
                                <span class="px-2 py-1 bg-brand-accent/10 dark:bg-brand-accent/20 text-[#00336E] dark:text-brand-accent text-[10px] font-bold rounded-md border border-brand-accent/20 dark:border-brand-accent/30">#{{ $vibe }}</span>
                            </div>

                            <h3 class="text-3xl font-bold text-[#00336E] dark:text-white mb-3 tracking-tight group-hover:text-brand-accent dark:group-hover:text-brand-accent transition-colors relative z-10">{{ $word->term }}</h3>
                            
                            <p class="text-[#00336E]/70 dark:text-white/70 text-[15px] leading-relaxed mb-6 font-medium line-clamp-3 relative z-10">
                                {{ optional($word->primaryDefinition)->definition ?? 'No definition available.' }}
                            </p>
                            
                            <div class="flex items-center justify-between text-[#00336E]/50 dark:text-white/50 text-xs font-bold relative z-10">
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
                    <h3 class="text-2xl font-bold text-[#00336E] dark:text-white mb-2">No words found for this vibe.</h3>
                    <p class="text-[#00336E]/50 dark:text-white/50">Maybe you should submit one?</p>
                    <a href="{{ route('word.create') }}" class="inline-block mt-6 px-6 py-3 bg-[#00336E] hover:bg-brand-accent hover:text-[#00336E] text-white font-bold rounded-full transition-colors">Submit a Word</a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
