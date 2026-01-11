<div x-data="{ open: false, searchTriggered: false }" {{ $attributes }}>
    @props(['theme' => 'light'])

    <!-- Hamburger Button -->
    <button 
        @click="open = true" 
        class="lg:hidden p-2 rounded-lg transition-colors {{ $theme === 'dark' ? 'text-white hover:bg-white/10' : 'text-[#002B5B] dark:text-white hover:bg-slate-100 dark:hover:bg-white/10' }}"
        aria-label="Open Menu"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Overlay -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 lg:hidden"
        style="display: none;"
    ></div>

    <!-- Slide-over Menu -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 w-4/5 max-w-sm bg-white dark:bg-[#002B5B] shadow-2xl z-50 lg:hidden flex flex-col border-l border-slate-200 dark:border-white/10"
        style="display: none;"
    >
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-white/10">
            <span class="text-xl font-black text-[#002B5B] dark:text-white tracking-tight">
                TikTok<span class="text-brand-primary dark:text-brand-accent">Dictionary</span>
            </span>
            <button 
                @click="open = false" 
                class="p-2 text-slate-400 hover:text-slate-600 dark:text-white/40 dark:hover:text-white transition-colors"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto p-6 space-y-8">
            <!-- Search -->
            <form action="{{ route('word.browse') }}" method="GET" class="relative">
                <input 
                    type="search" 
                    name="q"
                    placeholder="Search slang..." 
                    class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-[#002B5B] dark:text-white focus:ring-2 focus:ring-brand-primary outline-none transition-all placeholder:text-slate-400"
                >
                <svg class="absolute left-3.5 top-3.5 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>

            <!-- Navigation Links -->
            <nav class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg font-bold text-[#002B5B] dark:text-white hover:text-brand-primary dark:hover:text-brand-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/10 flex items-center justify-center">🏠</span>
                    Home
                </a>
                <a href="{{ route('explore.feed') }}" class="flex items-center gap-3 text-lg font-bold text-[#002B5B] dark:text-white hover:text-brand-primary dark:hover:text-brand-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/10 flex items-center justify-center">🔥</span>
                    Live Feed
                </a>
                <a href="{{ route('word.browse') }}" class="flex items-center gap-3 text-lg font-bold text-[#002B5B] dark:text-white hover:text-brand-primary dark:hover:text-brand-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/10 flex items-center justify-center">📚</span>
                    Browse Dictionary
                </a>
                <a href="{{ route('word.create') }}" class="flex items-center gap-3 text-lg font-bold text-[#002B5B] dark:text-white hover:text-brand-primary dark:hover:text-brand-accent transition-colors">
                    <span class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/10 flex items-center justify-center">➕</span>
                    Submit Word
                </a>
            </nav>

            <!-- User Section -->
            <div class="pt-6 border-t border-slate-100 dark:border-white/10">
                @auth
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-brand-primary text-white flex items-center justify-center font-bold text-lg">
                            {{ substr(Auth::user()->username, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-[#002B5B] dark:text-white">{{ Auth::user()->username }}</div>
                            <div class="text-xs text-slate-500 dark:text-white/60">Logged In</div>
                        </div>
                    </div>
                    
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block w-full py-3 mb-3 text-center rounded-xl bg-slate-100 dark:bg-white/10 text-[#002B5B] dark:text-white font-bold hover:bg-slate-200 transition-colors">
                            Admin Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] font-bold rounded-xl hover:bg-brand-primary transition-colors shadow-lg">
                            Sign Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full py-3 bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] text-center font-bold rounded-xl hover:bg-brand-primary transition-colors shadow-lg mb-3">
                        Login / Register
                    </a>
                @endauth
            </div>
        </div>

        <!-- Footer / Dark Mode -->
        <div class="p-6 border-t border-slate-100 dark:border-white/10 bg-slate-50 dark:bg-black/20">
            <div class="flex items-center justify-between">
                <span class="text-sm font-bold text-slate-500 dark:text-white/60">Appearance</span>
                
                <!-- Dark Mode Toggle (Mobile) -->
                <button 
                    x-data="{ 
                        isDark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
                    }"
                    @click="
                        isDark = !isDark; 
                        if (isDark) { 
                            document.documentElement.classList.add('dark'); 
                            localStorage.theme = 'dark'; 
                        } else { 
                            document.documentElement.classList.remove('dark'); 
                            localStorage.theme = 'light'; 
                        }
                    " 
                    class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors duration-300 focus:outline-none"
                    :class="isDark ? 'bg-brand-primary' : 'bg-slate-300'"
                >
                    <span 
                        class="inline-flex h-6 w-6 transform items-center justify-center rounded-full bg-white transition-transform duration-300 shadow-sm"
                        :class="isDark ? 'translate-x-7' : 'translate-x-1'"
                    >
                        <svg x-show="!isDark" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg x-show="isDark" class="h-3.5 w-3.5 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
