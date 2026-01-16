<x-layouts.app>
@php
    $siteName = \App\Models\Setting::get('site_name', 'TikTokDictionary');
    $logoUrl = \App\Models\Setting::get('logo_url', '');
    $announceEnabled = filter_var(\App\Models\Setting::get('announcement_enabled', false), FILTER_VALIDATE_BOOLEAN);
    $announceText = \App\Models\Setting::get('announcement_text', '');
    $announceLink = \App\Models\Setting::get('announcement_link', '');
    $announceBg = \App\Models\Setting::get('announcement_bg_color', '#0F62FE');
@endphp
    <!-- Hero Section (Full Height - Exact Figma Match) -->
    <section class="relative min-h-screen flex flex-col overflow-hidden bg-gradient-to-b from-[#90C0F8] to-[#62A2EC]">
        
        <!-- Header (Inside Hero) -->
        <header class="relative z-20 pt-8 pb-4">
            <div class="max-w-[1400px] mx-auto px-10 flex items-center">
                <!-- Logo: TikTok (Bold) Dictionary (Regular) -->
                <a href="{{ route('home') }}" class="flex items-center group overflow-hidden">
                    <span class="text-2xl tracking-tighter text-[#00336E] transition-all duration-300 group-hover:tracking-normal">
                        <span class="font-bold">Tiktok</span><span class="font-medium">Dictionary</span>
                    </span>
                </a>
                
                <!-- Push Everything Else to the Right -->
                <div class="hidden lg:flex items-center gap-10 ml-auto">
                    <!-- Nav Menu -->
                    <div class="flex items-center gap-8">
                        <a href="{{ route('explore.feed') }}" class="text-sm font-bold text-[#00336E] hover:text-blue-600 transition-all hover:scale-105 transform active:scale-95">Live Feed</a>
                        <a href="{{ route('word.browse') }}" class="text-sm font-bold text-[#00336E] hover:text-blue-600 transition-all hover:scale-105 transform active:scale-95">Browse</a>
                        <a href="{{ route('word.create') }}" class="text-sm font-bold text-[#00336E] hover:text-blue-600 transition-all hover:scale-105 transform active:scale-95">Submit</a>
                    </div>

                    @auth
                        <div class="flex items-center gap-5 border-l border-[#00336E]/10 pl-10">
                            <div class="flex flex-col items-end">
                                <span class="text-[#00336E] text-xs font-bold opacity-40 uppercase tracking-widest">Logged in as</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-[#00336E] text-sm font-bold">{{ Auth::user()->username }}</span>
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-bold bg-[#00336E] text-white px-2 py-0.5 rounded-sm hover:bg-blue-600 transition-colors uppercase">Admin</a>
                                    @endif
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-8 py-2.5 bg-[#00336E] text-white text-sm font-bold rounded-full hover:bg-blue-800 transition-all hover:shadow-lg active:scale-95 transform">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-10 py-3 bg-[#00336E] text-white text-sm font-bold rounded-full hover:bg-blue-800 transition-all hover:shadow-[0_10px_30px_rgba(0,51,110,0.3)] active:scale-95 transform">
                            Login
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile Nav Component -->
                <x-layouts.mobile-nav theme="light" />
            </div>
        </header>

        @if($announceEnabled && (!empty($announceText)))
            <div class="w-full" style="background: {{ $announceBg }}">
                <div class="max-w-[1240px] mx-auto px-6 py-2 text-white text-sm font-bold flex items-center justify-between">
                    <div>{{ $announceText }}</div>
                    @if(!empty($announceLink))
                        <a href="{{ $announceLink }}" class="underline decoration-white/60 hover:decoration-white">Learn more</a>
                    @endif
                </div>
            </div>
        @endif
        <!-- Hero Content Container -->
        <div class="flex-1 flex flex-col justify-center pb-32" 
             x-data="{ 
                shown: false,
                init() {
                    let observer = new IntersectionObserver((entries) => {
                        if (entries[0].isIntersecting) {
                            this.shown = true;
                            observer.unobserve(this.$el);
                        }
                    }, { threshold: 0.1 });
                    observer.observe(this.$el);
                }
             }">
            <div class="max-w-[1240px] w-full mx-auto px-6 text-center relative z-10">
                <!-- Main Headline (GRIFTER Font Applied) -->
                <h1 class="text-[#00336E] tracking-tight mb-8 select-none font-title transition-all duration-[1200ms] ease-out delay-150"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                    <span class="block text-5xl md:text-7xl font-[600] mb-4">Search Any</span>
                    <span class="block text-6xl md:text-[6rem] md:leading-[1] font-[600]">
                        Tiktok Word...
                    </span>
                </h1>
                
                <!-- Subtext -->
                <p class="text-[#00336E] text-[18px] md:text-[23px] font-[300] mb-6 opacity-90 max-w-3xl mx-auto tracking-tight transition-all duration-[1200ms] [transition-timing-function:cubic-bezier(0,0,0.2,1)] delay-300"
                   :class="shown ? 'opacity-90 translate-y-0' : 'opacity-0 translate-y-10'">
                    Type a trend, phrase, or slang you saw online.
                </p>
                
                <!-- Search Container -->
                <div class="w-full max-w-[850px] mx-auto group/search transition-all duration-[1200ms] ease-out delay-[450ms]"
                     :class="shown ? 'opacity-100 translate-y-0 scale-100' : 'opacity-0 translate-y-8 scale-95'">
                    @livewire('search-bar')
                </div>
                
                <p class="text-[#00336E] text-base md:text-lg mt-10 opacity-70 transition-all duration-1000 delay-700"
                   :class="shown ? 'opacity-70' : 'opacity-0'">
                   Press <span class="font-bold">Enter</span> to search
                </p>
            </div>
        </div>
    </section>



    <!-- Word of the Day (Figma Style - Yellow Banner) -->
    @if($wordOfTheDay)
        <section class="bg-[#FFB703] py-3 shadow-sm border-b border-black/5">
            <div class="max-w-[1240px] mx-auto px-6 flex flex-col sm:flex-row items-center justify-center gap-4 text-center sm:text-left">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-[#FFB703] text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-wider">WORD OF THE DAY</span>
                    <span class="text-black font-bold text-base h-5 leading-tight select-all tracking-tight">"{{ $wordOfTheDay->term }}"</span>
                </div>
                <div class="hidden sm:block h-3 w-px bg-black/20"></div>
                <p class="text-black/80 text-sm font-medium italic line-clamp-1">
                    {{ $wordOfTheDay->primaryDefinition->definition ?? 'A trending term you need to know.' }}
                </p>
                <a href="{{ route('word.show', $wordOfTheDay->slug) }}" class="text-black font-bold text-sm hover:underline whitespace-nowrap">
                    Read more →
                </a>
            </div>
        </section>
    @endif

    <!-- Main Content -->
    <main>
        
        <!-- Trending Right Now (Enhanced to Match Image) -->
        <section class="bg-white py-24">
            <div class="max-w-[1240px] mx-auto px-6">
                <!-- Section Header -->
                <div class="mb-12 reveal-on-scroll">
                    <h2 class="text-6xl font-bold text-[#00336E] tracking-normal font-title mb-3">Trending Right Now</h2>
                    <p class="text-[#00336E] text-lg font-medium">Choose the correct meaning and discover new words instantly.</p>
                </div>

                <!-- Tabs -->
                <div class="flex items-center gap-3 mb-10 reveal-on-scroll">
                    <button class="bg-[#00336E] text-white px-8 py-3 rounded-full text-sm font-black shadow-lg shadow-blue-900/10">Today</button>
                    <button class="bg-[#F1F5F9] text-[#00336E] px-8 py-3 rounded-full text-sm font-black hover:bg-slate-200 transition-colors">This Week</button>
                    <button class="bg-[#F1F5F9] text-[#00336E] px-8 py-3 rounded-full text-sm font-black hover:bg-slate-200 transition-colors">This Month</button>
                </div>

                <!-- Trending Card Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    @foreach($trendingWords->take(6) as $word)
                        <div class="premium-card reveal-on-scroll p-6 max-w-[400px] h-[179px] flex flex-col mx-auto w-full">
                            <div class="flex justify-between items-start mb-2">
                                <a href="{{ route('word.show', $word->slug) }}" class="block min-w-0 flex-1">
                                    <h3 class="text-xl font-bold text-[#000000] group-hover:text-[#00336E] transition-colors leading-tight tracking-tight truncate">{{ $word->term }}</h3>
                                </a>
                                <span class="text-lg font-bold text-[#000000] ml-2">#<span x-counter="{{ $loop->iteration }}">1</span></span>
                            </div>
                            
                            <div class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-bold bg-[#00336E]/[0.05] text-[#00336E] uppercase tracking-widest">
                                    {{ $word->category ?? 'Slang' }}
                                </span>
                            </div>
                            
                            <p class="text-[#00336E] text-[14px] font-medium leading-[1.3] line-clamp-2 overflow-hidden mb-auto">
                                {{ Str::limit(optional($word->primaryDefinition)->definition ?? 'No definition available.', 90) }}
                            </p>
                            
                            <div class="flex items-center gap-2 text-[#00336E] mt-3">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                <span class="text-[11px] font-bold"><span x-counter="{{ $word->total_agrees }}">0</span> agreed</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Footer Link -->
                <div class="text-left mt-8">
                    <a href="{{ route('word.browse') }}" class="inline-flex items-center text-[#00336E]/60 font-black text-xs uppercase tracking-widest hover:text-[#00336E] group transition-colors">
                        Browse all trending words
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Most Agreed Definitions (Figma Layout) -->
        <section class="bg-[#EFF6FE] py-16">
            <div class="max-w-[1240px] mx-auto px-6">
                <!-- Header -->
                <div class="mb-10">
                    <h2 class="text-4xl md:text-5xl font-bold text-[#00336E] tracking-tight mb-2 font-title">Most Agreed Definitions</h2>
                    <p class="text-[#00336E] text-base font-medium">Definitions voted accurate by the community.</p>
                </div>
                
                <div class="space-y-6">
                    @foreach($mostAgreedDefinitions as $index => $row)
                        @php
                            $def = $row['definition'];
                            $accuracy = $row['accuracy'];
                            $badges = ['Top Definition', 'Highly Agreed', 'Community Approved'];
                            $badgeLabel = $badges[$index % count($badges)];
                        @endphp
                        <div class="premium-card reveal-on-scroll p-8 flex flex-col md:flex-row items-center md:items-start justify-between gap-6 border-none shadow-sm hover:shadow-md">
                            <!-- Left Content -->
                            <div class="flex-1 min-w-0 w-full">
                                <div class="flex items-center gap-3 mb-3 flex-wrap">
                                    <h3 class="text-2xl font-bold text-[#00336E]">{{ $def->word->term }}</h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-[#4ADE80]/20 text-[#15803D] uppercase tracking-wide border border-[#4ADE80]/30">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        {{ $badgeLabel }}
                                    </span>
                                </div>
                                <p class="text-[#00336E] text-lg leading-relaxed mb-4 font-medium">{{ $def->definition }}</p>
                                <div class="flex items-center gap-2 text-[#00336E] font-bold text-xs">
                                    <svg class="w-4 h-4 text-[#00336E]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    <span x-counter="{{ $def->agrees }}">0</span> agreed
                                </div>
                            </div>
                            
                            <!-- Right Stats Box -->
                            <div class="flex flex-col items-center justify-center bg-[#F1F5F9] rounded-xl p-6 min-w-[140px] text-center mt-4 md:mt-0 w-full md:w-auto">
                                <span class="text-4xl font-black text-[#00336E] block mb-1"><span x-counter="{{ $accuracy }}">0</span>%</span>
                                <span class="text-[11px] font-bold text-[#00336E]/60 uppercase tracking-wide">accuracy</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>



        <!-- Fresh Submissions (Figma Grid Layout) -->
        <section class="bg-white py-16">
            <div class="max-w-[1240px] mx-auto px-6">
                <!-- Header -->
                <div class="mb-10 reveal-on-scroll">
                    <h2 class="text-6xl font-bold text-[#00336E] tracking-tight mb-3 font-title">Fresh Submissions</h2>
                    <p class="text-[#00336E] text-lg font-medium">Latest words discovered by users like you.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($freshWords->take(4) as $word)
                        <div class="premium-card reveal-on-scroll p-8 rounded-[30px] border border-[#00336E] flex flex-col h-full hover:shadow-lg transition-all group relative overflow-hidden bg-white">
                            <!-- Badges -->
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-slate-100 text-[#00336E]/60 uppercase tracking-wider">
                                    NEW
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-[#00336E] text-white uppercase tracking-wider">
                                    {{ $word->category ?? 'Slang' }}
                                </span>
                            </div>

                            <a href="{{ route('word.show', $word->slug) }}" class="block mb-2">
                                <h3 class="text-2xl font-bold text-[#00336E] group-hover:text-blue-600 transition-colors">{{ $word->term }}</h3>
                            </a>
                            
                            <p class="text-[#00336E]/80 text-base leading-relaxed mb-6 line-clamp-2">
                                {{ optional($word->primaryDefinition)->definition ?? 'No definition available.' }}
                            </p>
                            
                            <div class="mt-auto flex items-center gap-2 text-[11px] font-bold text-[#000000] uppercase tracking-wide">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Submitted {{ $word->created_at->diffForHumans(null, true) }} ago</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Explore Categories (Figma Cards) -->
        <section class="bg-[#EFF6FE] py-20">
            <div class="max-w-[1240px] mx-auto px-6">
                <!-- Header -->
                <div class="mb-12 text-center md:text-left reveal-on-scroll">
                    <h2 class="text-6xl font-bold text-[#00336E] tracking-tight mb-3 font-title">Explore Categories</h2>
                    <p class="text-[#00336E] text-base font-medium text-center md:text-left">Definitions voted accurate by the community.</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($categoryCards as $category)
                        <a href="{{ route('word.browse', ['category' => $category['category']]) }}" class="premium-card reveal-on-scroll p-8 text-center group bg-[#EFF6FE] border border-[#00336E] rounded-[20px] hover:bg-white hover:shadow-lg transition-all flex flex-col justify-center h-[140px]">
                            <h4 class="text-xl font-bold text-[#00336E] mb-1 group-hover:text-blue-600 transition-colors leading-tight">{{ $category['label'] }}</h4>
                            <span class="text-sm font-medium text-[#00336E]/70">{{ $category['countLabel'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Why TikTok Dictionary Exists (Figma Style) -->
        <section class="bg-white py-24">
            <div class="max-w-[1240px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left Text -->
                <div class="reveal-on-scroll">
                   <h2 class="text-6xl md:text-7xl font-bold text-[#00336E] tracking-tight mb-6 font-title leading-[1.1]">
                        Why TikTok<br>Dictionary Exists
                    </h2>
                    <p class="text-[#00336E] text-lg leading-relaxed max-w-md font-medium">
                        A community-powered dictionary tracking viral slang and new trends across TikTok and online culture. No ads. No influencers. 100% organic.
                    </p>
                </div>

                <!-- Right Stats Grid -->
                <div class="grid grid-cols-2 gap-6 reveal-on-scroll">
                    <!-- Stat Card 1 -->
                    <div class="bg-[#EFF6FE] rounded-[30px] p-8 text-center flex flex-col justify-center h-[180px] hover:shadow-lg transition-all group">
                        <span class="block text-5xl font-black text-[#00336E] mb-2"><span x-counter="{{ $stats['words'] }}">0</span>k+</span>
                        <span class="text-sm font-bold text-[#00336E]/70">Words Defined</span>
                    </div>
                    
                    <!-- Stat Card 2 -->
                    <div class="bg-[#EFF6FE] rounded-[30px] p-8 text-center flex flex-col justify-center h-[180px] hover:shadow-lg transition-all group">
                        <span class="block text-5xl font-black text-[#00336E] mb-2"><span x-counter="{{ $stats['votes'] }}">0</span>k+</span>
                        <span class="text-sm font-bold text-[#00336E]/70">Community Votes</span>
                    </div>

                    <!-- Stat Card 3 (Wide) -->
                    <div class="col-span-2 bg-[#EFF6FE] rounded-[30px] p-8 flex flex-col justify-center h-[160px] hover:shadow-lg transition-all group items-center text-center">
                        <span class="block text-5xl font-black text-[#00336E] mb-2">Live</span>
                        <span class="text-sm font-bold text-[#00336E]/70">Real-Time Updates</span>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <x-sections.submit-cta />
</x-layouts.app>
