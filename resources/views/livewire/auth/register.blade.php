<div class="animate-slide-up">
    <!-- Card -->
    <div class="bg-white/5 backdrop-blur-xl rounded-3xl border border-white/10 p-8 shadow-2xl shadow-black/20">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-white tracking-tight mb-2">
                Join the community
            </h2>
            <p class="text-white/60 font-medium">
                Start defining the internet's language
            </p>
        </div>

        <form wire:submit="register" class="space-y-5">
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-bold text-white/80 mb-2">
                    Choose a username
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-white/40 font-bold text-sm">@</span>
                    </div>
                    <input wire:model.blur="username" id="username" type="text" required autofocus
                        class="block w-full pl-10 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-accent/50 focus:border-brand-accent/50 transition-all text-base"
                        placeholder="cool_username">
                </div>
                <p class="mt-2 text-xs text-white/40 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Letters, numbers, dashes and underscores only
                </p>
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
                    Create a password
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input wire:model="password" id="password" type="password" required
                        class="block w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-accent/50 focus:border-brand-accent/50 transition-all text-base"
                        placeholder="Min 8 characters">
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

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-white/80 mb-2">
                    Confirm password
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                        class="block w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-accent/50 focus:border-brand-accent/50 transition-all text-base"
                        placeholder="Type password again">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-70 cursor-not-allowed"
                class="w-full flex items-center justify-center gap-2 py-4 px-6 bg-gradient-to-r from-brand-accent to-cyan-400 hover:from-brand-accent/90 hover:to-cyan-400/90 text-brand-dark text-base font-bold rounded-xl shadow-lg shadow-brand-accent/25 hover:shadow-xl hover:shadow-brand-accent/30 focus:outline-none focus:ring-2 focus:ring-brand-accent/50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">

                <span wire:loading.remove wire:target="register" class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Create Account
                </span>

                <span wire:loading wire:target="register" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creating...
                </span>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/10"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-[#002B5B] text-white/40 font-medium">Already a member?</span>
            </div>
        </div>

        <!-- Login Link -->
        <a href="{{ route('login') }}" wire:navigate
            class="w-full flex items-center justify-center gap-2 py-3.5 px-6 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white text-base font-bold rounded-xl transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Sign in instead
        </a>
    </div>

    <!-- Bottom Text -->
    <p class="text-center text-white/40 text-sm mt-6 font-medium">
        By creating an account, you agree to our
        <a href="#" class="text-brand-accent hover:text-white transition-colors">Terms</a>
        and
        <a href="#" class="text-brand-accent hover:text-white transition-colors">Privacy Policy</a>
    </p>
</div>
