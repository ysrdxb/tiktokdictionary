<!DOCTYPE html>
<html lang="en">
@php
    $siteName = \App\Models\Setting::get('site_name', 'TikTokDictionary');
    $siteTagline = \App\Models\Setting::get('tagline', 'The Viral Vernacular');
    $metaDescription = \App\Models\Setting::get('meta_description', '');
    $metaKeywords = \App\Models\Setting::get('meta_keywords', '');
    $ogImage = \App\Models\Setting::get('og_image', '');
    $gaId = \App\Models\Setting::get('google_analytics_id', '');
    $gsc = \App\Models\Setting::get('google_search_console', '');
    $fbPixel = \App\Models\Setting::get('facebook_pixel_id', '');
    $customHead = \App\Models\Setting::get('custom_head_scripts', '');
    $customFooter = \App\Models\Setting::get('custom_footer_scripts', '');
    $primaryColor = \App\Models\Setting::get('primary_color', '#00336E');
    $accentColor = \App\Models\Setting::get('accent_color', '#F59E0B');
    $logoUrl = \App\Models\Setting::get('logo_url', '');
    $faviconUrl = \App\Models\Setting::get('favicon_url', '');
    $announceEnabled = filter_var(\App\Models\Setting::get('announcement_enabled', false), FILTER_VALIDATE_BOOLEAN);
    $announceText = \App\Models\Setting::get('announcement_text', '');
    $announceLink = \App\Models\Setting::get('announcement_link', '');
    $announceBg = \App\Models\Setting::get('announcement_bg_color', '#0F62FE');
    $footerText = \App\Models\Setting::get('footer_text', '');
    $showPoweredBy = filter_var(\App\Models\Setting::get('show_powered_by', false), FILTER_VALIDATE_BOOLEAN);
    $darkDefault = \App\Models\Setting::get('dark_mode_default', false);
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? $siteName . ' - ' . $siteTagline }}</title>
    @if(!empty($metaDescription))
        <meta name="description" content="{{ $metaDescription }}">
    @endif
    @if(!empty($metaKeywords))
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    @if(!empty($gsc))
        <meta name="google-site-verification" content="{{ $gsc }}">
    @endif
    @if(!empty($ogImage))
        <meta property="og:image" content="{{ $ogImage }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif
    @if(!empty($faviconUrl))
        <link rel="icon" href="{{ $faviconUrl }}" />
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'GRIFTER';
            src: url('{{ \Illuminate\Support\Facades\Request::root() }}/fonts/grifterbold.otf') format('opentype');
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
                        sans: ['"Outfit"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        title: ['"GRIFTER"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#00336E',
                            primary: '#00336E',
                            secondary: '#85BCF5',
                            accent: '#FFB703',
                            surface: '#F8FAFC',
                            white: '#FFFFFF',
                            text: '#00336E',
                            border: '#E2E8F0',
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
        :root { --brand-primary: {{ $primaryColor }}; --brand-accent: {{ $accentColor }}; }

        /* Global Premium Card Styles */
        .premium-card {
            background-color: white;
            border: 1px solid #00336E;
            border-radius: 15px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 51, 110, 0.08);
            border-color: rgba(0, 51, 110, 0.3);
        }

        /* Entrance Animations */
        [x-data] .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        [x-data] .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Utility: Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
    <script>
        try {
            const hasPref = 'theme' in localStorage;
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const settingDarkDefault = @json((bool)$darkDefault);
            if (!hasPref) {
                if (settingDarkDefault || prefersDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                }
            } else {
                if (localStorage.theme === 'dark') document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');
            }
        } catch(e) {}
    </script>
    @if(!empty($gaId))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '{{ $gaId }}');
        </script>
    @endif
    @if(!empty($fbPixel))
        <script>
          !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
          n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '{{ $fbPixel }}'); fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $fbPixel }}&ev=PageView&noscript=1"/></noscript>
    @endif
    @if(!empty($customHead)) {!! $customHead !!} @endif
</head>
<body x-data="{}" class="font-sans antialiased bg-slate-50 dark:bg-[#00336E] text-slate-900 dark:text-white overflow-x-hidden min-h-screen flex flex-col transition-colors duration-300">

    <!-- Global Background Mesh (Dark Mode) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-50 hidden dark:block transition-opacity duration-500">
        <div class="absolute inset-0 bg-gradient-to-br from-[#0F62FE] via-[#00336E] to-[#00152e] opacity-90"></div>
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
        {{-- ALL OTHER PAGES: Global Header --}}
        <header class="relative z-50 py-6 border-b border-[#00336E]/5 bg-white/80 backdrop-blur-xl">
            <div class="max-w-[1400px] mx-auto px-10 flex items-center">
                <!-- Logo: TikTok (Bold) Dictionary (Regular) -->
                <a href="{{ route('home') }}" class="flex items-center group overflow-hidden">
                    <span class="text-2xl tracking-tighter text-[#00336E] transition-all duration-300 group-hover:tracking-normal">
                        <span class="font-bold">Tiktok</span><span class="font-medium">Dictionary</span>
                    </span>
                </a>
                
                <!-- Desktop Nav (Right Aligned) -->
                <div class="hidden lg:flex items-center gap-10 ml-auto">
                    <div class="flex items-center gap-8">
                        <a href="{{ route('explore.feed') }}" class="text-sm font-bold text-[#00336E] hover:text-blue-600 transition-all hover:scale-105 transform active:scale-95">Live Feed</a>
                        <a href="{{ route('word.browse') }}" class="text-sm font-bold text-[#00336E] hover:text-blue-600 transition-all hover:scale-105 transform active:scale-95">Browse</a>
                        <a href="{{ route('word.create') }}" class="text-sm font-bold text-[#00336E] hover:text-blue-600 transition-all hover:scale-105 transform active:scale-95">Submit</a>
                    </div>

                    @auth
                        <div class="flex items-center gap-5 border-l border-[#00336E]/10 pl-10">
                            <div class="flex flex-col items-end">
                                <span class="text-[#00336E] text-[10px] font-bold opacity-30 uppercase tracking-widest leading-none mb-1">Authenticated</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-[#00336E] text-sm font-bold">{{ Auth::user()->username }}</span>
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}" class="text-[9px] font-bold bg-[#00336E] text-white px-1.5 py-0.5 rounded-sm hover:bg-blue-600 transition-colors uppercase tracking-tighter">Admin</a>
                                    @endif
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-8 py-2.5 bg-[#00336E] text-white text-sm font-bold rounded-full hover:bg-black transition-all hover:shadow-lg active:scale-95 transform">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-10 py-3 bg-[#00336E] text-white text-sm font-bold rounded-full hover:bg-black transition-all hover:shadow-[0_10px_30px_rgba(0,51,110,0.15)] active:scale-95 transform">
                            Login
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile Nav Component -->
                <div class="lg:hidden ml-auto">
                    <!-- Trigger Button Only - The actual menu is effectively "teleported" via fixed positioning, 
                         but for z-index safety we keep the component here or relying on its own fixed strategy. 
                         However, if clipped, we should actually move the component to root. -->
                     <x-layouts.mobile-nav /> 
                </div>
            </div>
        </header>

        {{-- Announcement Banner --}}
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

        {{-- Main Content Wrapper (Full Width) --}}
        <main class="flex-1 w-full relative z-10">
            {{ $slot }}
        </main>
    @endif

    @if(!$isFeed)
        <!-- Footer -->
        <!-- Footer -->
        <footer class="relative z-10 mt-auto bg-[#00336E1A] py-12 border-t border-[#00336E]/5">
            <div class="max-w-[1240px] mx-auto px-6">
                <!-- Top Section: Centered Brand -->
                <div class="text-center mb-10">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <span class="text-2xl">📚</span>
                        <span class="text-xl font-bold text-[#00336E]">TikTokDictionary</span>
                    </div>
                    <p class="text-[#00336E]/70 text-sm font-medium max-w-md mx-auto">
                        Found a new term blowing up? Add it to the dictionary with your own definition.
                    </p>
                </div>

                <!-- Divider -->
                <div class="h-px bg-[#00336E]/10 w-full mb-8"></div>

                <!-- Bottom Section -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <!-- Copyright -->
                    <div class="text-[#00336E] text-sm font-bold">
                        © Copyright 2025. All Rights Reserved
                    </div>

                    <!-- Social Icons -->
                    <div class="flex items-center gap-4">
                        <!-- TikTok -->
                        <a href="https://tiktok.com" target="_blank" class="w-10 h-10 rounded-full border border-[#00336E] flex items-center justify-center text-[#00336E] hover:bg-[#00336E] hover:text-white transition-all group">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                        <!-- Instagram -->
                        <a href="https://instagram.com" target="_blank" class="w-10 h-10 rounded-full border border-[#00336E] flex items-center justify-center text-[#00336E] hover:bg-[#00336E] hover:text-white transition-all group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                        <!-- X (Twitter) -->
                        <a href="https://x.com" target="_blank" class="w-10 h-10 rounded-full border border-[#00336E] flex items-center justify-center text-[#00336E] hover:bg-[#00336E] hover:text-white transition-all group">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
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
                const duration = 2000;
                const frameDuration = 1000 / 60;
                const totalFrames = Math.round(duration / frameDuration);
                let currentInterval = null;

                const easeOutExpo = (t) => t === 1 ? 1 : 1 - Math.pow(2, -10 * t);

                const animate = () => {
                    clearInterval(currentInterval);
                    let frame = 0;
                    currentInterval = setInterval(() => {
                        frame++;
                        const progress = easeOutExpo(frame / totalFrames);
                        const current = Math.round(target * progress);
                        el.textContent = current.toLocaleString();

                        if (frame === totalFrames) {
                            clearInterval(currentInterval);
                            el.textContent = target.toLocaleString();
                        }
                    }, frameDuration);
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setTimeout(() => animate(), 100);
                        } else {
                            // Reset when out of view so it can jump again
                            el.textContent = '0';
                        }
                    });
                }, { threshold: 0.1 });

                observer.observe(el);
            });

            // Global Intersection Observer for Entrance Animations
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    } else {
                        // REMOVE class when it leaves view so it can JUMP again
                        entry.target.classList.remove('is-visible');
                    }
                });
            }, { threshold: 0.1 });

            // Using a mutation observer or just a small delay to catch all elements
            const observeElements = () => {
                document.querySelectorAll('.reveal-on-scroll').forEach(el => revealObserver.observe(el));
            };

            observeElements();
            // Re-run after a short delay for any late-loading items
            setTimeout(observeElements, 500);
        });
    </script>

    <!-- Livewire Scripts -->
    <!-- Real-Time Notifications -->
    <livewire:real-time-notifications />

    <!-- Livewire Scripts -->
    @livewireScripts
    @if(!empty($customFooter)) {!! $customFooter !!} @endif
    <!-- Global Toast Notification System -->
    <div x-data="{ 
        notifications: [],
        add(e) {
            this.notifications.push({
                id: Date.now(),
                message: e.detail.message || e.detail,
                type: e.detail.type || 'success',
            });
            // Auto remove after 3s
            setTimeout(() => { this.remove(this.notifications[this.notifications.length - 1].id) }, 3000);
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }" 
    @notify.window="add($event)"
    class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none">
        <template x-for="note in notifications" :key="note.id">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-90"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="pointer-events-auto flex items-center gap-3 px-6 py-4 bg-white/90 backdrop-blur-xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.12)] rounded-2xl min-w-[300px] max-w-md"
                 :class="note.type === 'error' ? 'border-red-500/20 bg-red-50/90' : 'border-white/50 bg-white/90'">
                
                <!-- Icon -->
                <div class="shrink-0">
                    <template x-if="note.type === 'success'">
                        <div class="w-8 h-8 rounded-full bg-green-500/10 text-green-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </template>
                    <template x-if="note.type === 'error'">
                        <div class="w-8 h-8 rounded-full bg-red-500/10 text-red-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                    </template>
                </div>

                <!-- Text -->
                <div>
                    <h4 class="text-sm font-black text-[#00336E]" x-text="note.type === 'error' ? 'Error' : 'Success'"></h4>
                    <p class="text-xs font-bold text-slate-500 mt-0.5" x-text="note.message"></p>
                </div>
            </div>
        </template>
    </div>
</body>
</html>
