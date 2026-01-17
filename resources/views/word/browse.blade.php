<x-layouts.app>
    <x-slot:title>
        Discover New Words - TikTokDictionary
    </x-slot>

    <!-- Hero Background Section -->
    <div class="w-full bg-[#E9F2FE] pt-24 md:pt-32 pb-24 px-6 text-center">
        <h1 class="text-[#00336E] font-bold text-4xl md:text-7xl mb-4 font-title leading-none reveal-on-scroll">
            Discover New Words
        </h1>
        <p class="text-[#00336E] text-lg md:text-xl font-medium max-w-2xl mx-auto reveal-on-scroll">
            Explore the latest slang, trends, and creator-made language—updated daily.
        </p>
    </div>

    <!-- Section 1: Filters & Trending (White Background) -->
    <div class="w-full bg-white pt-16 pb-16">
        <div class="max-w-[1240px] mx-auto px-6 space-y-16">
            
            <!-- Filters & Sorting (Standalone) -->
            <div class="flex flex-col md:flex-row gap-6 reveal-on-scroll">
                <!-- Sort By -->
                <div class="relative group flex-1">
                    <label class="absolute -top-3 left-6 bg-white px-2 text-sm font-black text-black z-10">Sort by</label>
                    <div class="relative">
                        <select onchange="window.location.href=this.value" class="w-full px-8 py-5 bg-white border border-[#00336E]/30 rounded-[20px] text-[#00152e] font-bold text-lg outline-none focus:ring-2 focus:ring-[#00336E]/10 transition-all appearance-none cursor-pointer">
                            <option value="{{ route('word.browse', ['sort' => 'today']) }}" {{ request('sort') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="{{ route('word.browse', ['sort' => 'week']) }}" {{ request('sort') == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="{{ route('word.browse', ['sort' => 'month']) }}" {{ request('sort') == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="{{ route('word.browse', ['sort' => 'all']) }}" {{ request('sort') == 'all' ? 'selected' : '' }}>All Time</option>
                        </select>
                        <svg class="absolute right-8 top-1/2 -translate-y-1/2 w-5 h-5 text-[#00336E] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Filter By -->
                <div class="relative group flex-1">
                    <label class="absolute -top-3 left-6 bg-white px-2 text-sm font-black text-black z-10">Filter by:</label>
                    <div class="relative">
                        <select onchange="window.location.href=this.value" class="w-full px-8 py-5 bg-white border border-[#00336E]/30 rounded-[20px] text-[#00152e] font-bold text-lg outline-none focus:ring-2 focus:ring-[#00336E]/10 transition-all appearance-none cursor-pointer">
                            <option value="{{ route('word.browse') }}">All Categories</option>
                            @foreach(['Slang', 'Gen-Z', 'TikTok', 'Gaming', 'Memes', 'Internet', 'AAVE'] as $cat)
                                <option value="{{ route('word.browse', ['category' => $cat]) }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        <svg class="absolute right-8 top-1/2 -translate-y-1/2 w-5 h-5 text-[#00336E] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Trending Words -->
            <section x-data="{ checkScroll() { 
                    // Optional: You could add logic here to disable buttons at ends 
                } 
            }">
                <div class="flex items-center justify-between mb-8 reveal-on-scroll">
                    <h2 class="text-4xl md:text-5xl font-black text-[#00336E] font-title">Trending Words</h2>
                    <div class="flex gap-3">
                        <button @click="$refs.trendingScroll.scrollBy({ left: -400, behavior: 'smooth' })" class="w-12 h-12 rounded-full border border-[#00336E]/30 flex items-center justify-center text-[#00336E] hover:bg-slate-50 transition-colors active:scale-90">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button @click="$refs.trendingScroll.scrollBy({ left: 400, behavior: 'smooth' })" class="w-12 h-12 rounded-full bg-[#00336E] text-white flex items-center justify-center hover:bg-[#002855] transition-colors shadow-lg active:scale-90">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
                <!-- Carousel Container -->
                <div x-ref="trendingScroll" class="flex overflow-x-auto gap-6 snap-x snap-mandatory scroll-smooth py-10 -mx-6 px-6 no-scrollbar reveal-on-scroll">
                    @forelse($trendingWords->take(9) as $word)
                        <div class="min-w-[300px] md:min-w-[400px] snap-center">
                            <a href="{{ route('word.show', $word->slug) }}" class="group block h-full">
                                <div class="premium-card h-full bg-white/70 backdrop-blur-xl rounded-[30px] p-8 border border-white/40 shadow-lg group-hover:shadow-2xl group-hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                                     <!-- Glass Shine -->
                                    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/40 to-transparent pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    
                                    <h3 class="text-3xl font-black text-[#00336E] mb-4 tracking-tight group-hover:text-[#F59E0B] transition-colors">{{ $word->term }}</h3>
                                    
                                    <!-- Badges -->
                                    <div class="flex flex-wrap gap-3 mb-6 relative z-10">
                                        <span class="bg-white/50 border border-[#00336E]/10 text-[#00336E] text-xs font-black px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                            {{ $word->total_agrees > 0 ? round(($word->total_agrees / max(($word->total_agrees + $word->total_disagrees), 1)) * 100) : 0 }}%
                                        </span>
                                        <span class="bg-white/50 border border-[#00336E]/10 text-[#00336E] text-xs font-black px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.45-.412-1.725a1 1 0 00-1.422-.865c-.247.114-.491.29-.718.538a5.2 5.2 0 00-1.069 2.235c-.15.68-.078 1.436.326 2.088.35.565.88.89 1.401 1.15.26.13.527.266.79.408l.004.002c.87.458 1.83.96 2.87 1.043a6.793 6.793 0 004.145-1.077 6.436 6.436 0 002.502-3.832 6.55 6.55 0 00-.236-4.223c-.32-.888-.788-1.58-1.352-2.144z" clip-rule="evenodd" /></svg>
                                            {{ $word->category == 'TikTok' ? 'Viral Audio' : 'Trending Today' }}
                                        </span>
                                    </div>
                                    <p class="text-[#00336E]/80 text-sm font-medium leading-relaxed">
                                        {{ Str::limit(optional($word->primaryDefinition)->definition, 60) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="w-full text-center py-10 text-[#00336E]/50">No trending words yet.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    <!-- Section 2: Fastest Growing Words (Blue Background #EFF6FE) -->
    <div class="w-full bg-[#EFF6FE] py-20">
        <div class="max-w-[1240px] mx-auto px-6">
            <div x-data class="flex items-center justify-between mb-8 reveal-on-scroll">
                <h2 class="text-4xl md:text-5xl font-black text-[#00336E] font-title">Fastest Growing Words</h2>
                <div class="flex gap-3">
                    <button @click="$refs.growingScroll.scrollBy({ left: -400, behavior: 'smooth' })" class="w-12 h-12 rounded-full border border-[#00336E]/30 flex items-center justify-center text-[#00336E] hover:bg-white/50 transition-colors active:scale-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="$refs.growingScroll.scrollBy({ left: 400, behavior: 'smooth' })" class="w-12 h-12 rounded-full bg-[#00336E] text-white flex items-center justify-center hover:bg-[#002855] transition-colors shadow-lg active:scale-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
            <div x-ref="growingScroll" class="flex overflow-x-auto gap-6 snap-x snap-mandatory scroll-smooth py-10 -mx-6 px-6 no-scrollbar reveal-on-scroll">
                @forelse($fastestGrowing->take(9) as $word)
                    <div class="min-w-[300px] md:min-w-[400px] snap-center">
                        <a href="{{ route('word.show', $word->slug) }}" class="group bg-[#EFF6FE] rounded-[20px] p-8 border border-[#00336E] hover:shadow-xl transition-all flex flex-col h-full active:scale-[0.98]">
                            <h3 class="text-2xl font-black text-[#00152e] mb-4">{{ $word->term }}</h3>
                            <div class="flex gap-3">
                                <span class="bg-[#DCE5F2] text-[#00152e] text-[11px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    +{{ $word->velocity_score > 0 ? $word->velocity_score : rand(120, 800) }}%
                                </span>
                                <span class="bg-[#DCE5F2] text-[#00152e] text-[11px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider">
                                    {{ $word->category }}
                                </span>
                            </div>
                        </a>
                    </div>
                @empty
                        <div class="w-full text-center py-10 text-[#00336E]/50">No growing words yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Section 3: Rest of Content (White Background) -->
    <div class="w-full bg-white py-20">
        <div class="max-w-[1240px] mx-auto px-6 space-y-24">
            
            <!-- Most Controversial Section -->
            <section>
                <h2 class="text-4xl md:text-5xl font-black text-[#00336E] font-title mb-8 reveal-on-scroll">Most Controversial</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 reveal-on-scroll">
                    @forelse($mostControversial->take(2) as $word)
                        <a href="{{ route('word.show', $word->slug) }}" class="block bg-white rounded-[20px] p-8 border border-[#00336E] hover:shadow-lg transition-all group">
                            <h3 class="text-2xl font-black text-[#00152e] mb-2">{{ $word->term }}</h3>
                            <p class="text-[#00152e] font-medium mb-4">Reason: Highly debated meaning</p>
                            
                            @php
                                $total = $word->total_agrees + $word->total_disagrees;
                                $agreePct = $total > 0 ? round(($word->total_agrees / $total) * 100) : 0;
                                $disagreePct = $total > 0 ? round(($word->total_disagrees / $total) * 100) : 0;
                            @endphp
                            
                            <div class="flex items-center gap-6 text-sm font-black text-[#00152e]">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    {{ $agreePct }}%
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-5 h-5 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    {{ $disagreePct }}%
                                </div>
                            </div>
                        </a>
                    @empty
                         <div class="col-span-2 text-center text-[#00336E]/50">No controversial data.</div>
                    @endforelse
                </div>
            </section>

            </section>
        </div>
    </div>

    <!-- Section 4: Meme Words Of The Week (Blue Background #EFF6FE) -->
    <div class="w-full bg-[#EFF6FE] py-20">
        <div class="max-w-[1240px] mx-auto px-6">
            <div x-data class="flex items-center justify-between mb-8 reveal-on-scroll">
                 <h2 class="text-4xl md:text-5xl font-black text-[#00336E] font-title">Meme Words Of The Week</h2>
                 <div class="flex gap-3">
                    <button @click="$refs.memeScroll.scrollBy({ left: -400, behavior: 'smooth' })" class="w-12 h-12 rounded-full border border-[#00336E]/30 flex items-center justify-center text-[#00336E] hover:bg-white/50 transition-colors active:scale-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="$refs.memeScroll.scrollBy({ left: 400, behavior: 'smooth' })" class="w-12 h-12 rounded-full bg-[#00336E] text-white flex items-center justify-center hover:bg-[#002855] transition-colors shadow-lg active:scale-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
            <div x-ref="memeScroll" class="flex overflow-x-auto gap-6 snap-x snap-mandatory scroll-smooth py-10 -mx-6 px-6 no-scrollbar reveal-on-scroll">
                 @forelse($memeWords->take(9) as $word)
                    <div class="min-w-[300px] md:min-w-[400px] snap-center">
                        <a href="{{ route('word.show', $word->slug) }}" class="group bg-[#EFF6FE] rounded-[20px] p-8 border border-[#00336E] hover:shadow-xl transition-all flex flex-col justify-between h-full active:scale-[0.98]">
                            <h3 class="text-2xl font-black text-[#00152e] mb-4">{{ $word->term }}</h3>
                            <div>
                                <span class="bg-[#DCE5F2] text-[#00152e] text-[11px] font-black px-4 py-2 rounded-full uppercase tracking-wider inline-block">
                                    {{ $word->category == 'TikTok' ? 'Audio Trend' : ($word->category == 'Memes' ? 'Meme Audio' : 'Reaction') }}
                                </span>
                            </div>
                        </a>
                    </div>
                 @empty
                    <div class="w-full text-center py-10 text-[#00336E]/50">No memes this week.</div>
                 @endforelse
            </div>
        </div>
    </div>

    <!-- Section 5: Audio & Subculture (White Background) -->
    <div class="w-full bg-white py-20">
        <div class="max-w-[1240px] mx-auto px-6 space-y-24">

            <!-- Audio / Hashtag Trends -->
            <section class="reveal-on-scroll">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-4xl md:text-5xl font-black text-[#00336E] font-title">Audio / Hashtag Trends</h2>
                    <a href="#" class="px-8 py-3 bg-[#00336E] text-white text-sm font-bold rounded-full hover:bg-black transition-colors flex items-center gap-2">
                        View More 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($audioTrendWords->take(2) as $word)
                        <a href="{{ route('word.show', $word->slug) }}" class="bg-white rounded-[20px] p-8 hover:shadow-lg transition-all border border-[#00336E] group">
                           <h3 class="text-2xl font-black text-[#00336E] mb-2">#{{ str_replace(' ', '', $word->term) }} — trending</h3>
                           <p class="text-[#00152e] font-black">"{{ Str::limit(optional($word->primaryDefinition)->definition, 50) }}" — +540%</p>
                        </a>
                    @empty
                         <div class="text-[#00336E]/50">No audio trends.</div>
                    @endforelse
                </div>
            </section>
            
            <!-- Subculture Words -->
            <section id="subculture-section" class="reveal-on-scroll">
                 <div class="mb-10">
                    <h2 class="text-4xl md:text-5xl font-black text-[#00336E] font-title mb-6">Subculture Words</h2>
                    
                    <!-- Subculture Pills -->
                    <div class="flex flex-wrap gap-3">
                        @foreach(['Gen Z', 'Gaming', 'AAVE', 'Stan Culture', 'Anime', 'Fitness', 'NSFW'] as $sc)
                            <a href="{{ route('word.browse', ['subculture' => $sc]) }}#subculture-section" 
                               class="px-6 py-2.5 rounded-full text-sm font-bold transition-all {{ $activeSubculture === $sc ? 'bg-[#00336E] text-white shadow-lg shadow-blue-900/10' : 'bg-[#F1F5F9] text-[#00336E] hover:bg-slate-200' }}">
                                {{ $sc }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                     @forelse($subcultureWords as $word)
                        <a href="{{ route('word.show', $word->slug) }}" class="bg-white rounded-[20px] p-8 hover:shadow-lg transition-all group border border-[#00336E]/10 flex flex-col justify-between h-50 relative overflow-hidden">
                            <!-- Subtle Gradient Glow on Hover -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#00336E]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <h3 class="text-xl font-black text-[#00336E] mb-4 relative z-10">{{ $word->term }}</h3>
                            <div class="relative z-10">
                                <span class="text-[10px] font-bold text-[#00336E]/60 bg-slate-100 px-3 py-1.5 rounded-full uppercase tracking-widest">{{ $word->category }}</span>
                            </div>
                        </a>
                     @empty
                        <div class="col-span-4 text-center py-12 bg-slate-50 rounded-[20px] border-2 border-dashed border-slate-200">
                            <span class="text-4xl mb-4 block">🏝️</span>
                            <h3 class="text-xl font-bold text-[#00336E] mb-1">No words in this subculture yet.</h3>
                            <p class="text-[#00336E]/50">Be the first to <a href="{{ route('word.create') }}" class="font-bold underline">submit one</a>!</p>
                        </div>
                     @endforelse
                </div>
            </section>
        </div>
    </div>

    <!-- Submit CTA Bottom -->
    <x-sections.submit-cta />
</x-layouts.app>
