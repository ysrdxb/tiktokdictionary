<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sign In' }} - TikTokDictionary</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#002B5B',
                            primary: '#EA0054',
                            accent: '#25F4EE',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 6s ease-in-out infinite; animation-delay: 2s; }
        .animate-pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }
        .animate-slide-up { animation: slide-up 0.6s ease-out forwards; }

        .gradient-text {
            background: linear-gradient(135deg, #EA0054 0%, #25F4EE 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    @livewireStyles
</head>
<body class="font-sans antialiased bg-[#002B5B] min-h-screen">
    <!-- Background Effects -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-[#001a3a] via-[#002B5B] to-[#00152e]"></div>
        <div class="absolute top-[10%] right-[20%] w-[500px] h-[500px] bg-brand-primary rounded-full blur-[150px] opacity-20 animate-pulse-glow"></div>
        <div class="absolute bottom-[20%] left-[10%] w-[400px] h-[400px] bg-brand-accent rounded-full blur-[120px] opacity-15 animate-pulse-glow" style="animation-delay: 2s;"></div>
        <div class="absolute top-[50%] left-[50%] w-[600px] h-[600px] bg-purple-600 rounded-full blur-[180px] opacity-10"></div>
    </div>

    <div class="relative z-10 min-h-screen flex">
        <!-- Left Side - Branding & Info (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] flex-col justify-between p-12 relative overflow-hidden">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center -rotate-6 group-hover:rotate-0 transition-transform shadow-xl shadow-white/20">
                        <span class="text-brand-dark text-2xl font-black">T</span>
                    </div>
                    <span class="text-2xl font-bold text-white tracking-tight">
                        TikTok<span class="text-brand-accent">Dictionary</span>
                    </span>
                </a>
            </div>

            <!-- Center Content -->
            <div class="flex-1 flex flex-col justify-center max-w-lg">
                <h1 class="text-5xl xl:text-6xl font-black text-white leading-tight mb-6 animate-slide-up">
                    Decode the
                    <span class="gradient-text">Internet's</span>
                    Language
                </h1>
                <p class="text-xl text-white/60 font-medium leading-relaxed animate-slide-up" style="animation-delay: 0.1s;">
                    Join thousands of users discovering and defining the latest slang, memes, and viral terms.
                </p>

                <!-- Stats -->
                <div class="flex gap-8 mt-10 animate-slide-up" style="animation-delay: 0.2s;">
                    <div>
                        <div class="text-3xl font-black text-white">10K+</div>
                        <div class="text-sm text-white/50 font-medium">Words Defined</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-brand-accent">50K+</div>
                        <div class="text-sm text-white/50 font-medium">Monthly Users</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-brand-primary">1M+</div>
                        <div class="text-sm text-white/50 font-medium">Definitions</div>
                    </div>
                </div>

                <!-- Floating Word Cards -->
                <div class="relative mt-12 h-32">
                    <div class="absolute left-0 top-0 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 animate-float">
                        <span class="text-white font-bold">skibidi</span>
                        <span class="text-white/50 text-sm ml-2">Trending</span>
                    </div>
                    <div class="absolute left-32 top-8 px-4 py-2 bg-brand-primary/20 backdrop-blur-sm rounded-xl border border-brand-primary/30 animate-float-delayed">
                        <span class="text-white font-bold">rizz</span>
                        <span class="text-brand-primary text-sm ml-2">Hot</span>
                    </div>
                    <div class="absolute left-16 top-20 px-4 py-2 bg-brand-accent/20 backdrop-blur-sm rounded-xl border border-brand-accent/30 animate-float" style="animation-delay: 1s;">
                        <span class="text-white font-bold">no cap</span>
                        <span class="text-brand-accent text-sm ml-2">Classic</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-white/40 text-sm font-medium">
                © {{ date('Y') }} TikTokDictionary. All rights reserved.
            </div>
        </div>

        <!-- Right Side - Auth Form -->
        <div class="w-full lg:w-1/2 xl:w-[45%] flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center -rotate-6 group-hover:rotate-0 transition-transform shadow-xl">
                            <span class="text-brand-dark text-2xl font-black">T</span>
                        </div>
                        <span class="text-2xl font-bold text-white tracking-tight">
                            TikTok<span class="text-brand-accent">Dictionary</span>
                        </span>
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
