<div class="animate-slide-up">
    <!-- Card -->
    <div class="bg-white/5 backdrop-blur-xl rounded-3xl border border-white/10 p-8 shadow-2xl shadow-black/20">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-white tracking-tight mb-2">
                Welcome back
            </h2>
            <p class="text-white/60 font-medium">
                Sign in to continue your journey
            </p>
        </div>

        <form wire:submit="login" class="space-y-5">
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-bold text-white/80 mb-2">
                    Username
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input wire:model="username" id="username" type="text" required autofocus
                        class="block w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-accent/50 focus:border-brand-accent/50 transition-all text-base"
                        placeholder="Enter your username">
                </div>
                @error('username')
                    <div class="mt-2 flex items-center gap-2 text-red-400 text-sm font-medium">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-bold text-white/80 mb-2">
                    Password
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input wire:model="password" id="password" type="password" required
                        class="block w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-accent/50 focus:border-brand-accent/50 transition-all text-base"
                        placeholder="Enter your password">
                </div>
                @error('password')
                    <div class="mt-2 flex items-center gap-2 text-red-400 text-sm font-medium">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input wire:model="remember" id="remember" type="checkbox"
                        class="w-4 h-4 rounded bg-white/10 border-white/20 text-brand-accent focus:ring-brand-accent/50 focus:ring-offset-0 cursor-pointer">
                    <span class="text-sm text-white/60 font-medium group-hover:text-white/80 transition-colors select-none">
                        Remember me
                    </span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-70 cursor-not-allowed"
                class="w-full flex items-center justify-center gap-2 py-4 px-6 bg-gradient-to-r from-brand-primary to-pink-600 hover:from-brand-primary/90 hover:to-pink-600/90 text-white text-base font-bold rounded-xl shadow-lg shadow-brand-primary/25 hover:shadow-xl hover:shadow-brand-primary/30 focus:outline-none focus:ring-2 focus:ring-brand-primary/50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">

                <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Sign In
                </span>

                <span wire:loading wire:target="login" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Signing in...
                </span>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/10"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-[#002B5B] text-white/40 font-medium">New here?</span>
            </div>
        </div>

        <!-- Register Link -->
        <a href="{{ route('register') }}" wire:navigate
            class="w-full flex items-center justify-center gap-2 py-3.5 px-6 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white text-base font-bold rounded-xl transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Create an account
        </a>
    </div>

    <!-- Bottom Text -->
    <p class="text-center text-white/40 text-sm mt-6 font-medium">
        By signing in, you agree to our
        <a href="#" class="text-brand-accent hover:text-white transition-colors">Terms</a>
        and
        <a href="#" class="text-brand-accent hover:text-white transition-colors">Privacy Policy</a>
    </p>
</div>
