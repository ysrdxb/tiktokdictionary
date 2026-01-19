<div>
    <!-- Hero Background Section -->
    <div class="w-full bg-[#E9F2FE] pt-24 md:pt-32 pb-48 px-6 text-center relative z-10">
        <h1 class="text-[#00336E] font-bold text-4xl md:text-7xl tracking-tighter mb-4 font-title leading-none">
            Welcome Back
        </h1>
        <p class="text-[#00336E] text-lg md:text-xl font-medium max-w-2xl mx-auto">
            Log in to keep track of the latest viral trends.
        </p>
    </div>

    <!-- Main Content Wrapper (Transparent Container) -->
    <div class="w-full min-h-[60vh] -mt-32 relative z-20 pb-20">
        <!-- Lower Page Global Background -->
        <div class="absolute top-32 bottom-0 left-0 right-0 bg-[#FFFFFF] -z-10"></div>

        <div class="max-w-[1000px] mx-auto px-6">
            <div class="max-w-[600px] mx-auto">
                <div class="premium-card bg-white/70 backdrop-blur-3xl rounded-[30px] p-8 md:p-12 shadow-2xl border border-white/40 relative overflow-hidden">
                    <!-- Subtle Glass Shine -->
                    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/40 to-transparent pointer-events-none"></div>

                    <form wire:submit="login" class="space-y-8 relative z-10">
                        
                        <!-- Username -->
                        <div class="group">
                            <label for="username" class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">Username</label>
                            <input wire:model="username" id="username" type="text" required autofocus
                                class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all duration-300 placeholder:text-[#00336E]/30"
                                placeholder="Enter your username">
                            @error('username')
                                <p class="mt-2 text-xs font-bold text-red-500 flex items-center gap-1 animate-pulse">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="group">
                            <label for="password" class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">Password</label>
                            <input wire:model="password" id="password" type="password" required
                                class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all duration-300 placeholder:text-[#00336E]/30"
                                placeholder="Enter your password">
                            @error('password')
                                <p class="mt-2 text-xs font-bold text-red-500 flex items-center gap-1 animate-pulse">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-2">
                            <label class="flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input wire:model="remember" type="checkbox" class="sr-only peer">
                                    <div class="w-6 h-6 border-2 border-[#00336E]/30 rounded-lg peer-checked:bg-[#00336E] peer-checked:border-[#00336E] transition-all"></div>
                                    <svg class="absolute top-1 left-1 w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="ml-3 text-sm font-bold text-[#00336E] group-hover:text-brand-accent transition-colors">Keep me logged in</span>
                            </label>
                            
                            <a href="#" class="text-sm font-black text-[#00336E] hover:text-brand-accent hover:underline uppercase tracking-tight transition-colors">
                                Forgot?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full flex justify-center items-center py-4 bg-[#00336E] text-white text-lg font-bold rounded-full hover:bg-brand-accent hover:text-[#00336E] transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0">
                                <span wire:loading.remove wire:target="login">Sign In</span>
                                <span wire:loading wire:target="login">Signing In...</span>
                            </button>
                        </div>
                    </form>

                    <p class="mt-8 text-center text-sm font-bold text-[#00336E]/60">
                        New here?
                        <a href="{{ route('register') }}" class="text-[#00336E] hover:underline font-black" wire:navigate>
                            Create a free account →
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
