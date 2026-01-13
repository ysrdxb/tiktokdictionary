<div>
    <!-- Hero Section -->
    <div class="w-full bg-[#EAF3FE] dark:bg-transparent py-16 transition-colors duration-300">
        <div class="max-w-[1240px] mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-black text-[#002B5B] dark:text-white tracking-tight leading-none mb-4 drop-shadow-2xl">
                Submit a <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-secondary to-brand-accent">New Word</span>
            </h1>
            <p class="text-[#002B5B]/70 dark:text-white/70 text-base md:text-lg font-medium max-w-xl mx-auto">
                Got a new slang, trend, or phrase? Add it to the dictionary.
            </p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="w-full bg-white dark:bg-transparent py-12 transition-colors duration-300">
        <div class="max-w-[900px] mx-auto px-6">

            @if($disabledReason)
                <!-- Disabled State -->
                <div class="bg-white dark:bg-[#00152e]/50 dark:backdrop-blur-xl border border-[#002B5B]/10 dark:border-white/10 rounded-[32px] p-8 md:p-12 shadow-[0_0_50px_rgba(0,0,0,0.05)] dark:shadow-[0_0_50px_rgba(0,0,0,0.2)] text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center">
                        <svg class="w-10 h-10 text-slate-400 dark:text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-[#002B5B] dark:text-white mb-3">{{ $disabledReason }}</h2>
                    <p class="text-[#002B5B]/60 dark:text-white/60 mb-6">Check back later or browse existing words.</p>
                    @if($requireLogin && !auth()->check())
                        <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-[#002B5B] dark:bg-brand-accent text-white dark:text-[#002B5B] font-bold rounded-full hover:opacity-90 transition-opacity">
                            Log In to Submit
                        </a>
                    @else
                        <a href="{{ route('word.browse') }}" class="inline-block px-8 py-3 bg-[#002B5B] dark:bg-brand-accent text-white dark:text-[#002B5B] font-bold rounded-full hover:opacity-90 transition-opacity">
                            Browse Words
                        </a>
                    @endif
                </div>
            @else
            <div class="bg-white dark:bg-[#00152e]/50 dark:backdrop-blur-xl border border-[#002B5B]/10 dark:border-white/10 rounded-[32px] p-8 md:p-12 shadow-[0_0_50px_rgba(0,0,0,0.05)] dark:shadow-[0_0_50px_rgba(0,0,0,0.2)]">
                <form wire:submit="submit" class="space-y-8">
                    <!-- Row 1: Word + Definition -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Word -->
                        <div class="relative group">
                            <label class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2 pl-1">Word</label>
                            <input type="text" wire:model.live.debounce.500ms="term" required
                                   placeholder="e.g. Delulu, 'NPC'"
                                   class="w-full px-5 py-3 md:px-6 md:py-4 bg-[#F0F6FB] dark:bg-white/5 text-[#002B5B] dark:text-white font-bold text-base md:text-lg rounded-[20px] border border-[#002B5B]/10 dark:border-white/10 focus:ring-4 focus:ring-[#002B5B]/10 dark:focus:ring-brand-accent/20 focus:border-[#002B5B] dark:focus:border-brand-accent placeholder:text-[#002B5B]/30 dark:placeholder:text-white/20 transition-all outline-none">
                            @error('term')
                                <p class="text-red-500 dark:text-red-400 font-bold text-xs mt-2 pl-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Definition -->
                        <div class="relative group">
                            <label class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2 pl-1">Definition <span class="text-[#002B5B]/40 dark:text-white/40 font-normal ml-1">(keep it simple)</span></label>
                            <input type="text" wire:model="definition" required
                                   placeholder="What does it mean?"
                                   class="w-full px-5 py-3 md:px-6 md:py-4 bg-[#F0F6FB] dark:bg-white/5 text-[#002B5B] dark:text-white font-medium text-base md:text-lg rounded-[20px] border border-[#002B5B]/10 dark:border-white/10 focus:ring-4 focus:ring-[#002B5B]/10 dark:focus:ring-brand-accent/20 focus:border-[#002B5B] dark:focus:border-brand-accent placeholder:text-[#002B5B]/30 dark:placeholder:text-white/20 transition-all outline-none">
                            @error('definition')
                                <p class="text-red-500 dark:text-red-400 font-bold text-xs mt-2 pl-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
    
                    <!-- Row 2: Example Sentence -->
                    <div class="relative group">
                        <label class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2 pl-1">Example Sentence</label>
                        <textarea wire:model="example" required rows="2"
                                  placeholder="Use the word in a sentence..."
                                  class="w-full px-5 py-3 md:px-6 md:py-4 bg-[#F0F6FB] dark:bg-white/5 text-[#002B5B] dark:text-white font-medium text-base md:text-lg rounded-[20px] border border-[#002B5B]/10 dark:border-white/10 focus:ring-4 focus:ring-[#002B5B]/10 dark:focus:ring-brand-accent/20 focus:border-[#002B5B] dark:focus:border-brand-accent placeholder:text-[#002B5B]/30 dark:placeholder:text-white/20 transition-all outline-none resize-none"></textarea>
                        @error('example')
                            <p class="text-red-500 dark:text-red-400 font-bold text-xs mt-2 pl-1">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <!-- Row 3: Category + Source URL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Category -->
                        <div class="relative group">
                            <label class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2 pl-1">Category</label>
                            <div class="relative">
                                <select wire:model="category" required
                                        class="w-full px-5 py-3 md:px-6 md:py-4 bg-[#F0F6FB] dark:bg-[#00152e] text-[#002B5B] dark:text-white font-bold text-base rounded-[20px] border border-[#002B5B]/10 dark:border-white/10 focus:ring-4 focus:ring-[#002B5B]/10 dark:focus:ring-brand-accent/20 focus:border-[#002B5B] dark:focus:border-brand-accent cursor-pointer appearance-none outline-none">
                                    <option value="Slang">Slang</option>
                                    <option value="Gen-Z">Gen-Z</option>
                                    <option value="TikTok">TikTok</option>
                                    <option value="Gaming">Gaming</option>
                                    <option value="Memes">Memes</option>
                                    <option value="Internet">Internet</option>
                                    <option value="AAVE">AAVE</option>
                                </select>
                                <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-[#002B5B]/50 dark:text-white/50 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        
                        <!-- Source URL -->
                        <div class="relative group">
                            <label class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2 pl-1">Where did you see it? (Optional)</label>
                            <input type="url" wire:model="sourceUrl"
                                   placeholder="Paste TikTok link..."
                                   class="w-full px-5 py-3 md:px-6 md:py-4 bg-[#F0F6FB] dark:bg-white/5 text-[#002B5B] dark:text-white font-medium text-base rounded-[20px] border border-[#002B5B]/10 dark:border-white/10 focus:ring-4 focus:ring-[#002B5B]/10 dark:focus:ring-brand-accent/20 focus:border-[#002B5B] dark:focus:border-brand-accent placeholder:text-[#002B5B]/30 dark:placeholder:text-white/20 transition-all outline-none">
                        </div>
                    </div>
    
                    <!-- Row 4: Alternate Spellings -->
                    <div class="relative group">
                        <label class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2 pl-1">Alternate Spellings (Optional)</label>
                        <input type="text" wire:model="alternateSpellings"
                               placeholder="e.g. rizz, riz, rizzard"
                               class="w-full px-5 py-3 md:px-6 md:py-4 bg-[#F0F6FB] dark:bg-white/5 text-[#002B5B] dark:text-white font-medium text-base rounded-[20px] border border-[#002B5B]/10 dark:border-white/10 focus:ring-4 focus:ring-[#002B5B]/10 dark:focus:ring-brand-accent/20 focus:border-[#002B5B] dark:focus:border-brand-accent placeholder:text-[#002B5B]/30 dark:placeholder:text-white/20 transition-all outline-none">
                    </div>
    
                    <!-- Row 5: Hashtags -->
                    <div class="relative group">
                        <label class="block text-sm font-bold text-[#002B5B]/80 dark:text-white/80 mb-2 pl-1">Hashtags (Optional)</label>
                        <input type="text" wire:model="hashtags"
                               placeholder="#TikTokSlang"
                               class="w-full px-5 py-3 md:px-6 md:py-4 bg-[#F0F6FB] dark:bg-white/5 text-[#002B5B] dark:text-white font-medium text-base rounded-[20px] border border-[#002B5B]/10 dark:border-white/10 focus:ring-4 focus:ring-[#002B5B]/10 dark:focus:ring-brand-accent/20 focus:border-[#002B5B] dark:focus:border-brand-accent placeholder:text-[#002B5B]/30 dark:placeholder:text-white/20 transition-all outline-none">
                    </div>
    
                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" 
                                class="w-full md:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] font-black text-lg rounded-full hover:scale-105 hover:bg-slate-800 dark:hover:bg-brand-accent dark:hover:text-white transition-all shadow-lg dark:shadow-[0_0_30px_rgba(255,255,255,0.2)]">
                            Add Word
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal 1: Similar Word Warning -->
    @if($showSimilarModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/80 backdrop-blur-md">
            <div class="bg-white dark:bg-[#00152e] border border-[#002B5B]/10 dark:border-white/10 rounded-[32px] p-8 max-w-lg w-full shadow-2xl relative">
                <button wire:click="closeDuplicateModal" class="absolute top-6 right-6 text-[#002B5B]/50 dark:text-white/50 hover:text-[#002B5B] dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-2xl font-bold text-[#002B5B] dark:text-white text-center mb-6 leading-tight">
                    Looks like this word already exists. <br>Want to add a new definition instead?
                </h3>
                
                <div class="flex flex-col gap-3">
                    <a href="{{ route('word.show', $duplicateWordSlug) }}" class="w-full py-4 bg-[#F0F6FB] dark:bg-white/5 hover:bg-[#002B5B]/10 dark:hover:bg-white/10 border border-[#002B5B]/10 dark:border-white/20 text-[#002B5B] dark:text-white font-bold rounded-full text-center transition-colors">
                        View Existing Word ↗
                    </a>
                    <a href="{{ route('word.show', $duplicateWordSlug) }}#contribute" class="w-full py-4 bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] font-bold rounded-full text-center hover:bg-slate-800 dark:hover:bg-brand-accent dark:hover:text-white transition-colors">
                        Add New Definition ↗
                    </a>
                    <button wire:click="closeDuplicateModal" class="w-full py-4 text-[#002B5B]/50 dark:text-white/50 font-bold hover:text-[#002B5B] dark:hover:text-white transition-colors">
                        Continue Anyway
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal 2: Exact Duplicate Detailed Card -->
    @if($showExactDuplicateModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/80 backdrop-blur-md">
            <div class="bg-white dark:bg-[#00152e] border border-[#002B5B]/10 dark:border-white/10 rounded-[32px] p-8 max-w-lg w-full shadow-2xl relative text-center">
                <button wire:click="closeDuplicateModal" class="absolute top-6 right-6 text-[#002B5B]/50 dark:text-white/50 hover:text-[#002B5B] dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex items-center justify-center mb-4">
                    <div class="text-amber-500 bg-amber-500/10 p-4 rounded-full">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                           <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-[#002B5B] dark:text-white mb-4">Duplicate Detected</h3>
                
                <p class="text-[#002B5B] dark:text-white/80 text-lg font-medium mb-6 leading-relaxed bg-[#F0F6FB] dark:bg-white/5 p-4 rounded-xl">
                    "{{ $duplicateDefinition }}"
                </p>
                
                <div class="flex flex-row gap-4 justify-center">
                    <a href="{{ route('word.show', $duplicateWordSlug) }}" class="flex-1 py-3 bg-[#F0F6FB] dark:bg-white/5 border border-[#002B5B]/10 dark:border-white/10 text-[#002B5B] dark:text-white font-bold rounded-full text-center hover:bg-[#002B5B]/10 dark:hover:bg-white/10 transition-colors text-sm">
                        View Word ↗
                    </a>
                    <a href="{{ route('word.show', $duplicateWordSlug) }}#contribute" class="flex-1 py-3 bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] font-bold rounded-full text-center hover:bg-slate-800 dark:hover:bg-brand-accent dark:hover:text-white transition-colors text-sm">
                        Add New Definition ↗
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal 3: Success Modal -->
    @if($showSuccessModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/80 backdrop-blur-md">
            <div class="bg-white dark:bg-[#00152e] border border-[#002B5B]/10 dark:border-white/10 rounded-[32px] p-10 max-w-md w-full shadow-2xl relative text-center">
                <button wire:click="closeSuccessModal" class="absolute top-6 right-6 text-[#002B5B]/50 dark:text-white/50 hover:text-[#002B5B] dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex items-center justify-center mb-6 text-green-500 dark:text-green-400">
                     <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                     </svg>
                </div>

                <h3 class="text-3xl font-bold text-[#002B5B] dark:text-white mb-2">Word Submitted!</h3>
                <p class="text-[#002B5B]/70 dark:text-white/70 text-base font-medium mb-8 leading-relaxed">
                    Your definition will appear once reviewed. Thanks for contributing!
                </p>
                
                <button wire:click="closeSuccessModal" class="px-8 py-3 bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] font-bold rounded-full hover:bg-slate-800 dark:hover:bg-brand-accent dark:hover:text-white transition-colors w-full sm:w-auto shadow-lg">
                    Add Another Word ↗
                </button>
            </div>
        </div>
    @endif
</div>
