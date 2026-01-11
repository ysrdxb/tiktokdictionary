<x-layouts.app>
    <!-- Hero Section with Header Inside -->
    <section class="relative min-h-[620px] overflow-hidden flex flex-col">
        <!-- Blue Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#8FB8FF] to-[#A6C9FF]"></div>
        
        <!-- Header (Inside Hero) -->
        <header class="relative z-20 pt-6 pb-4">
            <div class="max-w-[1240px] mx-auto px-6 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-[20px] font-semibold tracking-tight">
                    <span class="text-white drop-shadow-sm">TikTok</span><span class="text-[#002B5B] font-bold">Dictionary</span>
                </a>
                
                @auth
                    <div class="flex items-center gap-4">
                        <span class="text-[#002B5B] text-sm font-bold bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm">{{ Auth::user()->username }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-white/90 text-[#002B5B] text-[13px] font-semibold rounded-full hover:bg-white transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 bg-[#002B5B] text-white text-[13px] font-semibold rounded-full hover:bg-slate-800 transition-colors">
                        Login
                    </a>
                @endauth
            </div>
        </header>
        
        <!-- Hero Content Container -->
        <div class="flex-1 flex flex-col justify-center py-16">
            <div class="max-w-[1240px] w-full mx-auto px-6 text-center relative z-10">
            <!-- Main Headline -->
            <h1 class="text-[#002B5B] leading-[0.95] tracking-tight mb-14 drop-shadow-sm select-none">
                <span class="block text-[42px] md:text-[56px] font-bold -mb-3">Search Any</span>
                <span class="relative inline-block text-[58px] md:text-[76px] font-bold pb-2">
                    <span class="relative z-10">Tiktok Word...</span>
                    <!-- Dashed Line: Pushed down with explicit pixels -->
                    <div class="absolute top-[85px] left-[-15%] right-[-15%] h-[1px] border-t-2 border-dashed border-[#002B5B]/30 z-0"></div>
                    <div class="absolute top-[85px] left-1/2 -translate-x-1/2 -translate-y-1/2 text-[#002B5B]/40 text-[10px] bg-[#97BFFF] px-1 blur-[0.5px]">✕</div>
                </span>
            </h1>
            
            <!-- Subtext: Added more margin-bottom -->
            <p class="text-[#002B5B] text-[16px] font-medium mb-12 tracking-wide opacity-80">
                Type a trend, phrase, slang you saw online.
            </p>
            
            <!-- Search Container: Explicit wide width -->
            <div class="w-full max-w-[700px] mx-auto mb-6">
                @livewire('search-bar')
            </div>
            
            <p class="text-[#002B5B]/60 text-[13px] font-medium mt-6">Press <span class="font-bold text-[#002B5B]">Enter</span> to search</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main>
        
        <!-- Viral / Trending Section (Kinetic Dark Mode) -->
        <section class="bg-[#002B5B] py-20 relative overflow-hidden">
            <!-- Background Glow Attributes -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-brand-secondary/20 blur-[120px] rounded-full pointer-events-none"></div>

            <div class="max-w-[1240px] mx-auto px-6 relative z-10">
                <!-- Header -->
                <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        <h2 class="text-6xl md:text-[80px] font-bold text-white tracking-tight leading-none mb-4">
                            Viral <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-secondary to-brand-accent">Velocity</span>
                        </h2>
                        <p class="text-white/80 font-medium text-xl tracking-wide max-w-2xl">
                            The fastest growing words on the internet, ranked by our Kinetic Algorithm™.
                        </p>
                    </div>
                    
                    <!-- Pulsing 'Live' Indicator -->
                    <div class="flex items-center gap-2 bg-white/5 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-accent opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-brand-accent"></span>
                        </span>
                        <span class="text-white text-sm font-bold tracking-wide">LIVE UPDATES</span>
                    </div>
                </div>

                <!-- Kinetic Bento Grid -->
                <x-ui.bento-grid :items="$trendingWords" />
                
            </div>
        </section>

        <!-- Most Agreed Definitions (Light Blue BG) -->
        <section class="bg-[#F0F6FB] py-20">
            <div class="max-w-[1240px] mx-auto px-6">
                <!-- Header -->
                <div class="mb-14">
                    <h2 class="text-6xl md:text-[80px] font-bold text-[#002B5B] tracking-tight mb-4 leading-none">Most Agreed Definitions</h2>
                    <p class="text-[#002B5B] font-medium text-xl tracking-wide">Definitions voted accurate by the community.</p>
                </div>
                
                <div class="space-y-6">
                    @foreach($mostAgreedDefinitions as $index => $row)
                        @php
                            $def = $row['definition'];
                            $accuracy = $row['accuracy'];
                            $badges = [
                                ['label' => 'Top Definition', 'class' => 'bg-[#DCFCE7] text-[#166534] border border-[#166534]/10'],
                                ['label' => 'Highly Agreed', 'class' => 'bg-[#DCFCE7] text-[#166534] border border-[#166534]/10'],
                                ['label' => 'Community Approved', 'class' => 'bg-[#DCFCE7] text-[#166534] border border-[#166534]/10'],
                            ];
                            $badge = $badges[$index] ?? $badges[2];
                        @endphp
                        <div class="bg-white rounded-[32px] p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-10 hover:shadow-sm transition-shadow">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-5 mb-4 flex-wrap">
                                    <h3 class="text-[32px] font-bold text-[#002B5B] tracking-tight">{{ $def->word->term }}</h3>
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[13px] font-bold tracking-wide {{ $badge['class'] }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        {{ $badge['label'] }}
                                    </span>
                                </div>
                                <p class="text-[#002B5B] text-[18px] leading-relaxed mb-5 font-medium">
                                    {{ $def->definition }}
                                </p>
                                <div class="flex items-center gap-2 text-[#002B5B] text-[15px] font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    {{ number_format((int)$def->agrees + rand(1000, 3000)) }} agreed
                                </div>
                            </div>
                            
                            <div class="bg-[#F1F5F9] rounded-[24px] w-[140px] h-[110px] flex flex-col items-center justify-center flex-shrink-0">
                                <span class="block text-[42px] font-bold text-[#002B5B] tracking-tight leading-none mb-1">{{ $accuracy }}%</span>
                                <span class="text-[#002B5B]/60 text-[13px] font-medium lowercase">accuracy</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- Fresh Submissions (White BG) -->
        <section class="bg-white py-20">
            <div class="max-w-[1240px] mx-auto px-6">
                <!-- Header -->
                <div class="mb-14">
                    <h2 class="text-6xl md:text-[80px] font-bold text-[#002B5B] tracking-tight mb-4 leading-none">Fresh Submissions</h2>
                    <p class="text-[#002B5B] font-medium text-xl tracking-wide">Latest words discovered by users like you.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($freshWords->take(4) as $word)
                        <a href="{{ route('word.show', $word->slug) }}" class="bg-white rounded-[20px] p-8 border border-[#002B5B] hover:shadow-xl transition-all group flex flex-col h-full relative">
                            <!-- Badges -->
                            <div class="flex items-center gap-2 mb-4">
                                <span class="px-3 py-1 bg-[#F1F5F9] text-[#475569] text-[11px] font-bold uppercase tracking-wide rounded-md">New</span>
                                <span class="px-4 py-1 bg-[#002B5B] text-white text-[11px] font-bold rounded-full">{{ $word->category ?? 'Slang' }}</span>
                            </div>

                            <h3 class="text-3xl font-bold text-[#002B5B] mb-3 tracking-tight">{{ $word->term }}</h3>
                            
                            <p class="text-[#002B5B] text-[16px] leading-relaxed mb-8 flex-grow font-medium line-clamp-3">
                                {{ optional($word->primaryDefinition)->definition ?? 'No definition available.' }}
                            </p>
                            
                            <div class="flex items-center gap-1.5 text-[#002B5B] text-[12px] font-bold mt-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Submitted {{ $word->created_at->diffForHumans() }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Explore Categories (Light Blue BG) -->
        <section class="bg-[#F0F6FB] py-20">
            <div class="max-w-[1240px] mx-auto px-6">
                <!-- Header -->
                <div class="mb-14">
                    <h2 class="text-6xl md:text-[80px] font-bold text-[#002B5B] tracking-tight mb-4 leading-none">Explore Categories</h2>
                    <p class="text-[#002B5B] font-medium text-xl tracking-wide">Definitions voted accurate by the community.</p>
                </div>
                
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($categoryCards as $category)
                        <a href="{{ route('word.browse', ['category' => $category['category']]) }}" class="bg-white border border-[#002B5B] rounded-[24px] p-6 flex flex-col items-center justify-center text-center hover:shadow-xl transition-all group h-40">
                            <h4 class="text-[20px] font-bold text-[#002B5B] mb-2 group-hover:text-[#1E40AF] transition-colors tracking-tight">{{ $category['label'] }}</h4>
                            <span class="text-[#002B5B]/70 text-[14px] font-bold">{{ $category['countLabel'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Why TikTok Dictionary Exists (White BG) -->
        <section class="bg-white py-24">
            <div class="max-w-[1240px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <!-- Left Text -->
                <div>
                   <h2 class="text-6xl md:text-[80px] font-bold text-[#002B5B] leading-[0.95] tracking-tight mb-8">
                        Why TikTok<br>
                        Dictionary Exists
                    </h2>
                    <p class="text-[#002B5B]/80 text-[18px] leading-relaxed font-medium max-w-lg">
                        A community-powered dictionary tracking viral slang and new trends across TikTok and online culture. No ads. No influencers. 100% organic.
                    </p>
                </div>

                <!-- Right Stats Grid (Blue Cards) -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-[#F0F6FB] rounded-[24px] p-10 text-center flex flex-col justify-center h-48">
                        <span class="block text-[42px] font-bold text-[#002B5B] mb-1 tracking-tight">{{ $stats['wordsLabel'] }}</span>
                        <span class="text-[#002B5B]/70 text-[14px] font-bold">Words Defined</span>
                    </div>
                    <div class="bg-[#F0F6FB] rounded-[24px] p-10 text-center flex flex-col justify-center h-48">
                        <span class="block text-[42px] font-bold text-[#002B5B] mb-1 tracking-tight">{{ $stats['definitionsLabel'] }}</span>
                        <span class="text-[#002B5B]/70 text-[14px] font-bold">Community Votes</span>
                    </div>
                    <div class="col-span-2 bg-[#F0F6FB] rounded-[24px] p-10 text-center flex flex-col justify-center h-48">
                        <span class="block text-[42px] font-bold text-[#002B5B] mb-1 tracking-tight">Live</span>
                        <span class="text-[#002B5B]/70 text-[14px] font-bold">Real-Time Updates</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Submit Section -->
    <section id="submit" class="bg-[#002B5B] py-24 text-center">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="text-6xl md:text-[80px] font-bold text-white tracking-tight mb-6 leading-none">Submit a Word</h2>
            <p class="text-white/80 mb-10 text-xl font-medium">Saw a new TikTok word? Add it before it blows up.</p>

            <a href="{{ route('word.create') }}"
               class="inline-flex items-center gap-3 px-8 py-4 bg-white text-[#002B5B] text-[18px] font-bold rounded-full hover:bg-slate-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Submit a New Word
            </a>

            <p class="text-white/60 text-base mt-8 font-semibold">It only takes a minute to add a definition</p>
    </section>
</x-layouts.app>
