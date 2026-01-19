<x-layouts.app>
    <div class="min-h-screen bg-[#F0F6FB] py-16 px-6">
        <div class="max-w-[1240px] mx-auto">
            
            <!-- Search Stats & Query -->
            <div class="mb-12">
                <nav class="flex items-center gap-2 text-sm font-bold text-[#00336E]/40 uppercase tracking-widest mb-4">
                    <a href="{{ route('home') }}" class="hover:text-brand-accent">Home</a>
                    <span>/</span>
                    <span class="text-[#00336E]">Search</span>
                </nav>
                <h1 class="text-4xl md:text-6xl font-black text-[#00336E] tracking-tighter uppercase">
                    Results for <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent to-[#FFB703]">"{{ $query }}"</span>
                </h1>
                <p class="mt-4 text-lg text-[#00336E]/60 font-medium">
                    Found {{ $startsWith->count() + $contains->count() }} matches across the dictionary.
                </p>
            </div>

            @if($startsWith->count() > 0 || $contains->count() > 0)
                
                <!-- Section 1: Starts With -->
                @if($startsWith->count() > 0)
                    <div class="mb-16">
                        <div class="flex items-center gap-4 mb-8">
                            <h2 class="text-xl font-black text-[#00336E] uppercase tracking-[0.2em]">Starts With</h2>
                            <div class="flex-1 h-px bg-[#00336E]/10"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($startsWith as $word)
                                <x-word-card :word="$word" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Section 2: Broad Matches (Contains) -->
                @if($contains->count() > 0)
                    <div>
                        <div class="flex items-center gap-4 mb-8">
                            <h2 class="text-xl font-black text-[#00336E]/40 uppercase tracking-[0.2em]">Also Contains "{{ $query }}"</h2>
                            <div class="flex-1 h-px bg-[#00336E]/10"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 opacity-80 hover:opacity-100 transition-opacity">
                            @foreach($contains as $word)
                                <x-word-card :word="$word" />
                            @endforeach
                        </div>
                    </div>
                @endif

            @else
                <!-- No Results State -->
                <div class="bg-white rounded-[40px] p-12 md:p-20 text-center shadow-xl border border-[#00336E]/5">
                    <div class="w-24 h-24 bg-[#F0F6FB] rounded-full flex items-center justify-center mx-auto mb-8">
                        <span class="text-5xl">🔭</span>
                    </div>
                    <h2 class="text-3xl font-black text-[#00336E] mb-4">Total ghost town...</h2>
                    <p class="text-lg text-[#00336E]/60 max-w-md mx-auto mb-10 font-medium">
                        We couldn't find any words for "{{ $query }}". Maybe it's too new or you just invented it?
                    </p>
                    <a href="{{ route('word.create', ['term' => $query]) }}" 
                       class="inline-flex items-center justify-center px-10 py-4 bg-[#00336E] text-white font-black rounded-2xl hover:bg-brand-accent hover:text-[#00336E] transition-all hover:scale-105 shadow-lg active:scale-95 transform">
                       + SUBMIT THIS WORD
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-layouts.app>
