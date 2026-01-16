<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance - {{ \App\Models\Setting::get('site_name', 'TikTokDictionary') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float { animation: float 3s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#001a38] via-[#00336E] to-[#001a38] flex items-center justify-center p-6">
    <div class="text-center max-w-lg">
        <!-- Animated Icon -->
        <div class="float mb-8">
            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-amber-400 to-orange-500 rounded-3xl flex items-center justify-center shadow-2xl shadow-orange-500/30">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight">
            We'll Be Back Soon
        </h1>
        <p class="text-white/60 text-lg mb-8 font-medium">
            {{ \App\Models\Setting::get('site_name', 'TikTokDictionary') }} is currently undergoing maintenance.
            We're working hard to bring you something awesome!
        </p>

        <!-- Status Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 rounded-full text-white/80 text-sm font-bold">
            <span class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></span>
            Maintenance in Progress
        </div>

        <!-- Admin Login Link -->
        <div class="mt-12">
            <a href="{{ route('login') }}" class="text-white/40 hover:text-white/60 text-sm font-medium transition-colors">
                Admin Login
            </a>
        </div>
    </div>
</body>
</html>
