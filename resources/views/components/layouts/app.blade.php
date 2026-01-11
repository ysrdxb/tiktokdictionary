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
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F0F6FB] text-[#002B5B]">

    @php
        $isHome = request()->routeIs('home');
        $isFullWidth = request()->routeIs('word.browse') || request()->routeIs('word.create');
    @endphp

    @if($isHome)
        {{-- HOMEPAGE: Header is rendered inside the page, not here --}}
        {{ $slot }}
    @elseif($isFullWidth)
        {{-- FULL-WIDTH PAGES (Browse, Submit): Header only, content handles its own sections --}}
        <header class="relative z-50 bg-[#EAF3FE] pt-6 pb-6">
            <div class="max-w-[1240px] w-full mx-auto px-6 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-[20px] font-semibold tracking-tight">
                    <span class="text-[#002B5B]">TikTok</span><span class="text-[#002B5B] font-bold">Dictionary</span>
                </a>
                <a href="#" class="px-6 py-2.5 bg-[#002B5B] text-white text-[13px] font-semibold rounded-full hover:bg-slate-800 transition-colors">
                    Login
                </a>
            </div>
        </header>
        
        {{-- Content handles its own full-width sections --}}
        {{ $slot }}
    @else
        {{-- OTHER PAGES: Header + Hero Background with container --}}
        <header class="relative z-50 bg-[#EAF3FE] pt-6 pb-6">
            <div class="max-w-[1240px] w-full mx-auto px-6 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-[20px] font-semibold tracking-tight">
                    <span class="text-[#002B5B]">TikTok</span><span class="text-[#002B5B] font-bold">Dictionary</span>
                </a>
                <a href="#" class="px-6 py-2.5 bg-[#002B5B] text-white text-[13px] font-semibold rounded-full hover:bg-slate-800 transition-colors">
                    Login
                </a>
            </div>
        </header>
        
        {{-- Hero Background for Inner Pages --}}
        <section class="relative w-full">
            <div class="w-full h-[200px] bg-[#EAF3FE]"></div>
            <div class="w-full flex justify-center px-6">
                <div class="-mt-32 z-20 w-full max-w-[1240px]">
                    {{ $slot }}
                </div>
            </div>
        </section>
    @endif

    <!-- Footer -->
    <footer class="bg-[#F0F6FB] text-[#002B5B] py-8">
        <div class="max-w-[1240px] mx-auto px-6">
            <!-- Logo and Description -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <span class="text-3xl">📚</span>
                    <span class="text-2xl font-black tracking-tight">TikTokDictionary</span>
                </div>
                <p class="text-[#002B5B]/70 text-base font-medium max-w-md mx-auto leading-relaxed">
                    Found a new term blowing up? Add it to the dictionary with your own definition.
                </p>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-[#002B5B]/10 my-6"></div>
            
            <!-- Copyright and Social Icons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                <p class="text-[#002B5B] text-sm font-semibold">© Copyright 2025. All Rights Reserved</p>
                
                <div class="flex items-center gap-3">
                    <!-- TikTok -->
                    <a href="#" class="w-10 h-10 rounded-full border border-[#002B5B] flex items-center justify-center text-[#002B5B] hover:bg-[#002B5B] hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                    </a>
                    <!-- Instagram -->
                    <a href="#" class="w-10 h-10 rounded-full border border-[#002B5B] flex items-center justify-center text-[#002B5B] hover:bg-[#002B5B] hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <!-- X (Twitter) -->
                    <a href="#" class="w-10 h-10 rounded-full border border-[#002B5B] flex items-center justify-center text-[#002B5B] hover:bg-[#002B5B] hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
