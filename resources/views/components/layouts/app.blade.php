<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TikTokDictionary - The Internet Slang Dictionary' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN (No Build Needed) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"GRIFTER"', 'Outfit', 'sans-serif'],
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
        @font-face {
            font-family: 'GRIFTER';
            src: url('fonts/grifterbold.otf') format('opentype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-[#002B5B] text-white overflow-x-hidden min-h-screen flex flex-col">

    <!-- Global Background Mesh (Fixed) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-50">
        <!-- Main Gradient Base -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#0F62FE] via-[#002B5B] to-[#00152e] opacity-90"></div>
        <!-- Atmospheric Glows -->
        <div class="absolute top-[10%] right-[10%] w-[600px] h-[600px] bg-[#EA0054] rounded-full blur-[120px] opacity-10 mix-blend-screen animate-pulse-slow"></div>
        <div class="absolute bottom-[10%] left-[10%] w-[500px] h-[500px] bg-[#25F4EE] rounded-full blur-[100px] opacity-10 mix-blend-screen"></div>
        <!-- Noise -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22 opacity=%221%22/%3E%3C/svg%3E');"></div>
    </div>

    @php
        $isHome = request()->routeIs('home');
        // Define common header classes
        $headerClasses = "relative z-50 pt-6 pb-6"; 
    @endphp

    @if($isHome)
        {{-- HOMEPAGE: Content handles its own specific header inside hero --}}
        {{ $slot }}
    @else
        {{-- ALL OTHER PAGES: Shared Glass Header --}}
        <header class="{{ $headerClasses }}">
            <div class="max-w-[1240px] w-full mx-auto px-6 flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-white text-[#002B5B] rounded-lg flex items-center justify-center font-black text-2xl -rotate-6 group-hover:rotate-0 transition-transform">
                        T
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold tracking-tight leading-none text-white">
                            TikTok<span class="text-brand-accent">Dictionary</span>
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-6">
                     <a href="{{ route('explore.feed') }}" class="text-sm font-bold text-white/80 hover:text-white transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-accent animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Live Feed
                    </a>
                    <a href="{{ route('word.browse') }}" class="text-sm font-bold text-white/80 hover:text-white transition-colors">Browse</a>
                </div>
                
                @auth
                    <div class="flex items-center gap-4">
                        @if(Auth::user()->is_admin)
                             <a href="{{ route('admin.dashboard') }}" class="text-white/70 text-sm font-bold hover:text-white">Admin</a>
                        @endif
                         <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 pl-4 pr-1 py-1 rounded-full">
                            <span class="text-white text-sm font-bold">{{ Auth::user()->username }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-5 py-2 bg-white text-[#002B5B] text-[13px] font-bold rounded-full hover:bg-brand-accent hover:text-white transition-all shadow-lg">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="group relative px-6 py-2.5 bg-white text-[#002B5B] text-sm font-bold rounded-full transition-all hover:shadow-[0_0_20px_rgba(255,255,255,0.4)] overflow-hidden">
                        <span class="relative z-10">Login</span>
                        <div class="absolute inset-0 bg-brand-accent opacity-0 group-hover:opacity-100 transition-opacity z-0"></div>
                    </a>
                @endauth
            </div>
        </header>

        {{-- Main Content Wrapper --}}
        <main class="flex-1 w-full max-w-[1240px] mx-auto px-6 py-8 relative z-10">
            {{ $slot }}
        </main>
    @endif

    <!-- Footer (Dark Theme) -->
    <footer class="relative z-10 mt-auto border-t border-white/10 bg-[#00152e]/50 backdrop-blur-sm pt-12 pb-8">
        <div class="max-w-[1240px] mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">📚</span>
                    <span class="text-xl font-black text-white tracking-tight">TikTokDictionary</span>
                </div>
                <div class="flex gap-6 text-sm font-bold text-white/60">
                    <a href="#" class="hover:text-white transition-colors">Submit Word</a>
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                </div>
                <div class="text-white/40 text-sm font-medium">
                    © 2025. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- Puter.js for Neural Audio -->
    <script src="https://js.puter.com/v2/"></script>
    
    <!-- html2canvas for Sticker Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Livewire Scripts -->
    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
