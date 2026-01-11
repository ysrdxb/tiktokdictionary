<x-layouts.app>
    <x-slot:title>
        Discover New Words - TikTokDictionary
    </x-slot>

    <!-- Page Title (no bg, no shadow - transparent on light blue) -->
    <section class="p-8 md:p-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-[#002B5B] tracking-tight leading-none mb-3">Discover New Words</h1>
        <p class="text-[#002B5B]/60 text-sm md:text-base font-medium max-w-xl mx-auto">
            Explore the latest slang, trends, and creator-made language—updated daily.
        </p>
    </section>

    <!-- Close layout's container, start full-width sections -->
    </div></section>

    <!-- SECTION: Filters + Trending Words - White Background -->
    <div class="bg-white py-10">
        <div class="max-w-[1240px] mx-auto px-6">
            <!-- Sort & Filter Row -->
            <form method="GET" action="{{ route('word.browse') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                <!-- Sort By Box -->
                <div class="relative">
                    <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Sort by</label>
                    <select name="sort" onchange="this.form.submit()" 
                            class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] cursor-pointer appearance-none">
                        <option value="today" {{ request('sort') === 'today' || !request('sort') ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('sort') === 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('sort') === 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="all" {{ request('sort') === 'all' ? 'selected' : '' }}>All Time</option>
                    </select>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#002B5B] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <!-- Filter By Box -->
                <div class="relative">
                    <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Filter by:</label>
                    <select name="category" onchange="this.form.submit()" 
                            class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] cursor-pointer appearance-none">
                        <option value="">Slang</option>
                        <option value="Slang" {{ request('category') === 'Slang' ? 'selected' : '' }}>Slang</option>
                        <option value="Gen-Z" {{ request('category') === 'Gen-Z' ? 'selected' : '' }}>Gen-Z</option>
                        <option value="TikTok" {{ request('category') === 'TikTok' ? 'selected' : '' }}>TikTok</option>
                        <option value="Gaming" {{ request('category') === 'Gaming' ? 'selected' : '' }}>Gaming</option>
                        <option value="Memes" {{ request('category') === 'Memes' ? 'selected' : '' }}>Memes</option>
                        <option value="Internet" {{ request('category') === 'Internet' ? 'selected' : '' }}>Internet</option>
                        <option value="AAVE" {{ request('category') === 'AAVE' ? 'selected' : '' }}>AAVE</option>
                    </select>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#002B5B] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </form>

            <!-- Trending Words Section with Slider -->
            <section x-data="{ currentSlide: 0, totalSlides: {{ max(1, ceil($trendingWords->count() / 3)) }} }">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#002B5B] tracking-tight">Trending Words</h2>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="currentSlide = Math.max(0, currentSlide - 1)" 
                                class="w-10 h-10 rounded-full border border-[#002B5B]/20 flex items-center justify-center text-[#002B5B] hover:bg-[#F0F6FB] transition-colors"
                                :class="{ 'opacity-50': currentSlide === 0 }">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button type="button" @click="currentSlide = Math.min(totalSlides - 1, currentSlide + 1)" 
                                class="w-10 h-10 rounded-full bg-[#002B5B] flex items-center justify-center text-white hover:bg-slate-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-300" :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                        @foreach($trendingWords->chunk(3) as $chunk)
                            <div class="w-full flex-shrink-0 grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($chunk as $index => $word)
                                    @php 
                                        $definition = $word->primaryDefinition;
                                        $percentage = rand(85, 98);
                                        $badges = ['TRENDING TODAY', 'VIRAL AUDIO', 'HOT NOW'];
                                    @endphp
                                    <a href="{{ route('word.show', $word->slug) }}" wire:navigate 
                                       class="bg-white border border-[#002B5B]/10 rounded-[16px] p-5 hover:shadow-md hover:border-[#002B5B]/30 transition-all">
                                        <div class="font-bold text-xl text-[#002B5B] tracking-tight mb-3">{{ $word->term }}</div>
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="px-2 py-1 bg-[#F0F6FB] text-[#002B5B] text-[10px] font-bold rounded">📊 {{ $percentage }}%</span>
                                            <span class="px-2 py-1 bg-[#002B5B] text-white text-[10px] font-bold rounded">🔥 {{ $badges[$index % 3] }}</span>
                                        </div>
                                        @if($definition)
                                            <p class="text-[#002B5B]/60 text-sm leading-relaxed">{{ Str::limit($definition->definition, 50) }}</p>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- SECTION: Fastest Growing Words - Light Blue Background -->
    <div class="bg-[#EAF3FE] py-10">
        <div class="max-w-[1240px] mx-auto px-6">
            <section x-data="{ currentSlide: 0, totalSlides: {{ max(1, ceil($fastestGrowing->count() / 3)) }} }">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#002B5B] tracking-tight">Fastest Growing Words</h2>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="currentSlide = Math.max(0, currentSlide - 1)" 
                                class="w-10 h-10 rounded-full border border-[#002B5B]/20 bg-white flex items-center justify-center text-[#002B5B] hover:bg-[#F0F6FB] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button type="button" @click="currentSlide = Math.min(totalSlides - 1, currentSlide + 1)" 
                                class="w-10 h-10 rounded-full bg-[#002B5B] flex items-center justify-center text-white hover:bg-slate-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-300" :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                        @foreach($fastestGrowing->chunk(3) as $chunk)
                            <div class="w-full flex-shrink-0 grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($chunk as $word)
                                    @php 
                                        $definition = $word->primaryDefinition;
                                        $percentage = rand(150, 640);
                                    @endphp
                                    <a href="{{ route('word.show', $word->slug) }}" wire:navigate 
                                       class="bg-white border border-[#002B5B]/10 rounded-[16px] p-5 hover:shadow-md hover:border-[#002B5B]/30 transition-all">
                                        <div class="font-bold text-xl text-[#002B5B] tracking-tight mb-3">{{ $word->term }}</div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 bg-[#F0F6FB] text-[#002B5B] text-[10px] font-bold rounded">📈 +{{ $percentage }}%</span>
                                            <span class="px-2 py-1 bg-[#002B5B] text-white text-[10px] font-bold rounded uppercase">{{ $word->category ?? 'Slang' }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- SECTION: Most Controversial - White Background -->
    <div class="bg-white py-10">
        <div class="max-w-[1240px] mx-auto px-6">
            <section x-data="{ currentSlide: 0, totalSlides: {{ max(1, ceil($mostControversial->count() / 2)) }} }">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#002B5B] tracking-tight">Most Controversial</h2>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="currentSlide = Math.max(0, currentSlide - 1)" 
                                class="w-10 h-10 rounded-full border border-[#002B5B]/20 flex items-center justify-center text-[#002B5B] hover:bg-[#F0F6FB] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button type="button" @click="currentSlide = Math.min(totalSlides - 1, currentSlide + 1)" 
                                class="w-10 h-10 rounded-full bg-[#002B5B] flex items-center justify-center text-white hover:bg-slate-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-300" :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                        @foreach($mostControversial->chunk(2) as $chunk)
                            <div class="w-full flex-shrink-0 grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($chunk as $word)
                                    @php $definition = $word->primaryDefinition; @endphp
                                    <a href="{{ route('word.show', $word->slug) }}" wire:navigate 
                                       class="bg-white border border-[#002B5B]/10 rounded-[16px] p-5 hover:shadow-md hover:border-[#002B5B]/30 transition-all">
                                        <div class="font-bold text-xl text-[#002B5B] tracking-tight mb-2">{{ $word->term }}</div>
                                        @if($definition)
                                            <p class="text-[#002B5B]/60 text-sm line-clamp-2 mb-3">{{ Str::limit($definition->definition, 80) }}</p>
                                        @endif
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 bg-[#F0F6FB] text-[#002B5B] text-[10px] font-bold rounded">👍 {{ number_format((int) $word->total_agrees) }}k</span>
                                            <span class="px-2 py-1 bg-[#F0F6FB] text-[#002B5B] text-[10px] font-bold rounded">👎 {{ number_format((int) $word->total_disagrees) }}k</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- SECTION: Meme Words Of The Week - Light Blue Background -->
    <div class="bg-[#EAF3FE] py-10">
        <div class="max-w-[1240px] mx-auto px-6">
            <section x-data="{ currentSlide: 0 }">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#002B5B] tracking-tight">Meme Words Of The Week</h2>
                    <div class="flex items-center gap-2">
                        <button type="button" class="w-10 h-10 rounded-full border border-[#002B5B]/20 bg-white flex items-center justify-center text-[#002B5B] hover:bg-[#F0F6FB] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button type="button" class="w-10 h-10 rounded-full bg-[#002B5B] flex items-center justify-center text-white hover:bg-slate-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @forelse($memeWords->take(3) as $word)
                        <a href="{{ route('word.show', $word->slug) }}" wire:navigate 
                           class="bg-white border border-[#002B5B]/10 rounded-[16px] p-5 hover:shadow-md hover:border-[#002B5B]/30 transition-all">
                            <div class="font-bold text-xl text-[#002B5B] tracking-tight mb-2">{{ $word->term }}</div>
                            <span class="px-2 py-1 bg-[#F0F6FB] text-[#002B5B] text-[10px] font-bold rounded uppercase">{{ $word->category ?? 'memes' }}</span>
                        </a>
                    @empty
                        <div class="col-span-3 text-center py-8 text-[#002B5B]/50 font-medium">No meme words this week</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    <!-- SECTION: Audio/Hashtag Trends - White Background -->
    <div class="bg-white py-10">
        <div class="max-w-[1240px] mx-auto px-6">
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#002B5B] tracking-tight">Audio / Hashtag Trends</h2>
                    <a href="#" class="px-5 py-2.5 bg-[#002B5B] text-white text-sm font-bold rounded-full hover:bg-slate-800 transition-colors">View More</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white border border-[#002B5B]/10 rounded-[16px] p-5">
                        <div class="font-bold text-base text-[#002B5B] mb-1">#delulu — 50k uses this week</div>
                        <p class="text-[#002B5B]/60 text-sm">"demure side eye" audio — +540%</p>
                    </div>
                    <div class="bg-white border border-[#002B5B]/10 rounded-[16px] p-5">
                        <div class="font-bold text-base text-[#002B5B] mb-1">#girldinner — trending</div>
                        <p class="text-[#002B5B]/60 text-sm">#NPC — resurging</p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- SECTION: Subculture Words - Light Blue Background -->
    <div class="bg-[#EAF3FE] py-10">
        <div class="max-w-[1240px] mx-auto px-6">
            <section>
                <h2 class="text-3xl md:text-4xl font-bold text-[#002B5B] tracking-tight mb-6">Subculture Words</h2>
                
                <!-- Category Pills -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @php
                        $subcultureCategories = ['Gen-Z', 'Gaming', 'AAVE', 'Stan Culture', 'Anime', 'Internet', 'TikTok'];
                        $currentCategory = request('category');
                    @endphp
                    @foreach($subcultureCategories as $cat)
                        <a href="{{ route('word.browse', ['category' => $cat]) }}" wire:navigate
                           class="px-4 py-2 {{ $currentCategory === $cat ? 'bg-[#002B5B] text-white' : 'bg-white text-[#002B5B]' }} font-bold rounded-full text-sm transition-colors hover:bg-[#002B5B] hover:text-white">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $subcultures = [
                            ['name' => 'Hard Carry', 'category' => 'Gaming'],
                            ['name' => 'He\'s so bookie', 'category' => 'Gen-Z'],
                            ['name' => 'Simp Arc', 'category' => 'Internet'],
                            ['name' => 'Main Character Energy', 'category' => 'TikTok']
                        ];
                    @endphp
                    @foreach($subcultures as $sub)
                        <a href="{{ route('word.browse', ['category' => $sub['category']]) }}" wire:navigate
                           class="bg-white border border-[#002B5B]/10 rounded-[16px] p-5 hover:shadow-md hover:border-[#002B5B]/30 transition-all">
                            <span class="font-bold text-base text-[#002B5B] block mb-1">{{ $sub['name'] }}</span>
                            <span class="text-xs text-[#002B5B]/50 font-bold uppercase">{{ $sub['category'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        </div>
    </div>

    <!-- Submit a Word Section (Dark Navy) -->
    <section class="bg-[#002B5B] py-16 text-center">
        <div class="max-w-[1240px] mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-4">Submit a Word</h2>
            <p class="text-white/70 mb-8 text-base font-medium">Saw a new TikTok word? Add it before it blows up.</p>
            
            <a href="{{ route('word.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#002B5B] font-bold rounded-full hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Submit a New Word
            </a>
            
            <p class="text-white/50 text-sm mt-6 font-medium">It only takes a minute to add a definition</p>
        </div>
    </section>

    <!-- Re-open for footer (handled by layout) -->
    <div class="hidden">
</x-layouts.app>
