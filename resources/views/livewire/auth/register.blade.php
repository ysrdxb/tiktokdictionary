<div class="w-full bg-slate-50 dark:bg-transparent min-h-screen flex items-center py-20 transition-colors duration-300">
    <div class="w-full sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <!-- Animated Icon -->
            <div class="mx-auto h-16 w-16 bg-white dark:bg-white/10 rounded-2xl flex items-center justify-center -rotate-6 mb-6 shadow-xl dark:shadow-[0_0_30px_rgba(255,255,255,0.2)]">
                <span class="text-[#002B5B] dark:text-white text-3xl font-black">T</span>
            </div>
            
            <h2 class="text-3xl font-black text-[#002B5B] dark:text-white tracking-tight drop-shadow-sm dark:drop-shadow-xl">
                Join TikTokDictionary
            </h2>
            <p class="mt-2 text-sm text-[#002B5B]/60 dark:text-white/60 font-medium">
                Already have an account?
                <a href="{{ route('login') }}" class="font-bold text-brand-primary dark:text-brand-accent hover:underline dark:hover:text-white transition-colors" wire:navigate>
                    Sign in
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Glassmorphic Card -->
            <div class="bg-white dark:bg-[#00152e]/50 backdrop-blur-xl py-8 px-4 shadow-xl dark:shadow-[0_0_40px_rgba(0,0,0,0.2)] sm:rounded-[24px] sm:px-10 border border-slate-200 dark:border-white/10">
                <form class="space-y-6" wire:submit="register">
                    
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2">
                            Username
                        </label>
                        <div class="relative rounded-[14px] shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-[#002B5B]/40 dark:text-white/40 font-bold">@</span>
                            </div>
                            <input wire:model.blur="username" id="username" type="text" required autofocus
                                class="block w-full pl-8 pr-4 py-3 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[14px] text-[#002B5B] dark:text-white placeholder-slate-400 dark:placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-brand-accent focus:border-transparent transition-all text-base"
                                placeholder="cool_user">
                        </div>
                        <p class="mt-2 text-xs text-[#002B5B]/50 dark:text-white/40 font-medium ml-1">Only letters, numbers, dashes and underscores.</p>
                        @error('username')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-bold bg-red-50 dark:bg-red-400/10 py-1 px-2 rounded-lg inline-block">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2">
                            Password
                        </label>
                        <div class="mt-1">
                            <input wire:model="password" id="password" type="password" required
                                class="block w-full px-4 py-3 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[14px] text-[#002B5B] dark:text-white placeholder-slate-400 dark:placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-brand-accent focus:border-transparent transition-all text-base">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-bold bg-red-50 dark:bg-red-400/10 py-1 px-2 rounded-lg inline-block">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2">
                            Confirm Password
                        </label>
                        <div class="mt-1">
                            <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                                class="block w-full px-4 py-3 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[14px] text-[#002B5B] dark:text-white placeholder-slate-400 dark:placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-brand-accent focus:border-transparent transition-all">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            wire:loading.attr="disabled"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white dark:text-[#002B5B] bg-[#002B5B] dark:bg-white hover:bg-slate-800 dark:hover:bg-brand-accent dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary dark:focus:ring-brand-accent transition-all transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed">
                            
                            <span wire:loading.remove>Register</span>
                            
                            <span wire:loading class="flex items-center gap-2">
                                 <svg class="animate-spin h-4 w-4 text-white dark:text-[#002B5B]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Creating account...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
