<div>
    <!-- Hero Background Section -->
    <div class="w-full bg-[#E9F2FE] pt-24 md:pt-32 pb-48 px-6 text-center relative z-10">
        <h1 class="text-[#00336E] font-bold text-4xl md:text-7xl tracking-tighter mb-4 font-title leading-none">
            Join the Club
        </h1>
        <p class="text-[#00336E] text-lg md:text-xl font-medium max-w-2xl mx-auto">
            Create an account to submit words and frame the culture.
        </p>
    </div>

    <!-- Main Content Wrapper (Transparent Container) -->
    <div class="w-full min-h-[60vh] -mt-32 relative z-20 pb-20">
        <!-- Lower Page Global Background -->
        <div class="absolute top-32 bottom-0 left-0 right-0 bg-[#FFFFFF] -z-10"></div>

        <div class="max-w-[1000px] mx-auto px-6">
            <div class="max-w-[600px] mx-auto">
                <div class="premium-card bg-white rounded-[30px] p-8 md:p-12 shadow-xl border border-[#00336E]/10">
                    <form wire:submit="register" class="space-y-8">
                        
                        <!-- Username -->
                        <div class="relative group">
                            <label for="username" class="absolute -top-2.5 left-4 bg-white px-2 text-sm font-bold text-[#00336E] z-10 transition-colors">Username</label>
                            <input wire:model.blur="username" id="username" type="text" required autofocus
                                class="w-full px-6 py-4 bg-transparent border border-[#00336E]/20 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:ring-1 focus:ring-[#00336E] transition-all placeholder:text-gray-300"
                                placeholder="Choose a username">
                            <p class="mt-2 text-[11px] font-bold text-[#00336E]/40 ml-4">Only letters, numbers, and underscores.</p>
                            @error('username')
                                <p class="mt-2 text-xs font-bold text-red-500 flex items-center gap-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="relative group">
                            <label for="password" class="absolute -top-2.5 left-4 bg-white px-2 text-sm font-bold text-[#00336E] z-10 transition-colors">Password</label>
                            <input wire:model="password" id="password" type="password" required
                                class="w-full px-6 py-4 bg-transparent border border-[#00336E]/20 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:ring-1 focus:ring-[#00336E] transition-all placeholder:text-gray-300"
                                placeholder="Create a password">
                            @error('password')
                                <p class="mt-2 text-xs font-bold text-red-500 flex items-center gap-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="relative group">
                            <label for="password_confirmation" class="absolute -top-2.5 left-4 bg-white px-2 text-sm font-bold text-[#00336E] z-10 transition-colors">Confirm Password</label>
                            <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                                class="w-full px-6 py-4 bg-transparent border border-[#00336E]/20 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:ring-1 focus:ring-[#00336E] transition-all placeholder:text-gray-300"
                                placeholder="Repeat password">
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full flex justify-center items-center py-4 bg-[#00336E] text-white text-lg font-bold rounded-full hover:bg-[#002855] transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0">
                                <span wire:loading.remove wire:target="register">Create Account</span>
                                <span wire:loading wire:target="register">Creating...</span>
                            </button>
                        </div>
                    </form>

                    <p class="mt-8 text-center text-sm font-bold text-[#00336E]/60">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-[#00336E] hover:underline font-black" wire:navigate>
                            Sign in here →
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
