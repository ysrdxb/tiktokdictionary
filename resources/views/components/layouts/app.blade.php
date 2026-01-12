<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TikTokDictionary - The Internet Slang Dictionary' }}</title>
    
    <!-- Fonts -->
    <!-- Local Fonts Only -->
    <style>
        @font-face {
            font-family: 'GRIFTER';
            src: url('/fonts/grifterbold.otf') format('opentype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
    </style>
    
    <!-- Tailwind CDN (No Build Needed) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"GRIFTER"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#002B5B',
                            primary: '#0F62FE',
                            secondary: '#60A5FA',
                            accent: '#F59E0B',
                            surface: '#F1F6FA',
                            white: '#FFFFFF',
                            text: '#1E293B',
                            heroFrom: '#8FB8FF',
                            heroVia: '#D1E5FF',
                            heroTo: '#F1F6FA',
                            border: '#2B5F8C',
                            panel: '#F0F7FF',
                            panelBorder: '#BFDBFE',
                        }
                    },
                    boxShadow: {
                        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                        'card-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                        'strong': '0 0 20px rgba(0, 43, 91, 0.15)',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 dark:bg-[#002B5B] text-slate-900 dark:text-white overflow-x-hidden min-h-screen flex flex-col transition-colors duration-300">

    <!-- Global Background Mesh (Dark Mode) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-50 hidden dark:block transition-opacity duration-500">
        <div class="absolute inset-0 bg-gradient-to-br from-[#0F62FE] via-[#002B5B] to-[#00152e] opacity-90"></div>
        <div class="absolute top-[10%] right-[10%] w-[600px] h-[600px] bg-[#EA0054] rounded-full blur-[120px] opacity-10 mix-blend-screen animate-pulse-slow"></div>
        <div class="absolute bottom-[10%] left-[10%] w-[500px] h-[500px] bg-[#25F4EE] rounded-full blur-[100px] opacity-10 mix-blend-screen"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22 opacity=%221%22/%3E%3C/svg%3E');"></div>
    </div>

    <!-- Global Background Mesh (Light Mode - New Premium Look) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-50 block dark:hidden transition-opacity duration-500">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-white to-blue-50"></div>
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-400/5 rounded-full blur-[120px] mix-blend-multiply"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-400/5 rounded-full blur-[100px] mix-blend-multiply"></div>
        <div class="absolute inset-0 opacity-[0.4]" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
    </div>

    @php
        $isHome = request()->routeIs('home');
        $isFeed = request()->routeIs('explore.feed');
        // Define common header classes
        $headerClasses = "relative z-50 pt-6 pb-6"; 
    @endphp

    @if($isHome)
        {{-- HOMEPAGE: Content handles its own specific header inside hero --}}
        {{ $slot }}
    @elseif($isFeed)
        {{-- FEED: Immersive Fullscreen (No global header/footer) --}}
        {{ $slot }}
    @else
        {{-- ALL OTHER PAGES: Shared Glass Header --}}
        <header class="{{ $headerClasses }}">
            <div class="max-w-[1240px] w-full mx-auto px-6 flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] rounded-lg flex items-center justify-center font-black text-2xl -rotate-6 group-hover:rotate-0 transition-transform shadow-lg">
                        T
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold tracking-tight leading-none text-[#002B5B] dark:text-white">
                            TikTok<span class="text-brand-primary dark:text-brand-accent">Dictionary</span>
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden lg:flex items-center gap-6">
                     <a href="{{ route('explore.feed') }}" class="text-sm font-bold text-slate-600 dark:text-white/80 hover:text-brand-primary dark:hover:text-white transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-primary dark:text-brand-accent animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Live Feed
                    </a>
                    <a href="{{ route('word.browse') }}" class="text-sm font-bold text-slate-600 dark:text-white/80 hover:text-brand-primary dark:hover:text-white transition-colors">Browse</a>
                    <a href="{{ route('word.create') }}" class="text-sm font-bold text-slate-600 dark:text-white/80 hover:text-brand-primary dark:hover:text-white transition-colors">Submit</a>
                    
                    <!-- Dark Mode Toggle (Hidden for now) -->
                    <!-- 
                    <button x-data="{ 
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
                            class="p-2.5 rounded-full bg-white/50 dark:bg-white/10 hover:bg-white dark:hover:bg-white/20 text-slate-600 dark:text-white/80 transition-all border border-slate-200 dark:border-white/10 shadow-sm backdrop-blur-sm">
                        
                        <svg x-show="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        
                        <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button> 
                    -->
                </div>
                
                @auth
                    <div class="hidden lg:flex items-center gap-4">
                        @if(Auth::user()->is_admin)
                             <a href="{{ route('admin.dashboard') }}" class="text-[#002B5B]/70 dark:text-white/70 text-sm font-bold hover:text-[#002B5B] dark:hover:text-white transition-colors">Admin Panel</a>
                        @endif
                         <div class="flex items-center gap-3 bg-[#002B5B]/5 dark:bg-white/10 backdrop-blur-md border border-[#002B5B]/10 dark:border-white/20 pl-4 pr-1 py-1 rounded-full">
                            <span class="text-[#002B5B] dark:text-white text-sm font-bold">{{ Auth::user()->username }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-5 py-2 bg-white text-[#002B5B] text-[13px] font-bold rounded-full hover:bg-brand-accent hover:text-white transition-all shadow-lg border border-[#002B5B]/10 dark:border-transparent">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden lg:flex group relative px-6 py-2.5 bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] text-sm font-bold rounded-full transition-all hover:shadow-lg overflow-hidden">
                        <span class="relative z-10">Login</span>
                        <div class="absolute inset-0 bg-brand-accent opacity-0 group-hover:opacity-100 transition-opacity z-0"></div>
                    </a>
                @endauth
                
                <!-- Mobile Nav Component -->
                <x-layouts.mobile-nav />
            </div>
        </header>

        {{-- Main Content Wrapper (Full Width) --}}
        <main class="flex-1 w-full relative z-10">
            {{ $slot }}
        </main>
    @endif

    @if(!$isFeed)
        <!-- Footer -->
        <footer class="relative z-10 mt-auto border-t border-slate-200 dark:border-white/10 bg-white dark:bg-[#00152e]/50 backdrop-blur-sm pt-12 pb-8 transition-colors duration-300">
            <div class="max-w-[1240px] mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">📚</span>
                        <span class="text-xl font-black text-[#002B5B] dark:text-white tracking-tight">TikTokDictionary</span>
                    </div>
                    <div class="flex gap-6 text-sm font-bold text-slate-600 dark:text-white/60">
                        <a href="{{ route('word.create') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Submit Word</a>
                        <a href="#" class="hover:text-brand-primary dark:hover:text-white transition-colors">Privacy</a>
                        <a href="#" class="hover:text-brand-primary dark:hover:text-white transition-colors">Terms</a>
                    </div>
                    <div class="text-slate-400 dark:text-white/40 text-sm font-medium">
                        © 2025. All Rights Reserved.
                    </div>
                </div>
            </div>
        </footer>
    @endif

    <!-- Puter.js for Neural Audio -->
    <script src="https://js.puter.com/v2/"></script>
    
    <!-- html2canvas for Sticker Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Alpine Counter Directive for Animated Numbers -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.directive('counter', (el, { expression }, { evaluate }) => {
                const target = parseInt(evaluate(expression)) || 0;
                const duration = 1500;
                const frameDuration = 1000 / 60;
                const totalFrames = Math.round(duration / frameDuration);
                let frame = 0;
                let hasAnimated = false;

                const easeOutQuad = (t) => t * (2 - t);

                const animate = () => {
                    if (hasAnimated) return;
                    hasAnimated = true;

                    const counter = setInterval(() => {
                        frame++;
                        const progress = easeOutQuad(frame / totalFrames);
                        el.textContent = Math.round(target * progress).toLocaleString();

                        if (frame === totalFrames) {
                            clearInterval(counter);
                            el.textContent = target.toLocaleString();
                        }
                    }, frameDuration);
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animate();
                            observer.unobserve(el);
                        }
                    });
                }, { threshold: 0.5 });

                observer.observe(el);
            });
        });
    </script>

    <!-- Livewire Scripts -->
    <!-- Real-Time Notifications -->
    <livewire:real-time-notifications />

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
