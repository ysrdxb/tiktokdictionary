<div>
    <!-- Form Section -->
    <div class="w-full">
        @if($disabledReason)
            <!-- Disabled State -->
            <div class="premium-card bg-white border border-[#00336E]/10 rounded-[30px] p-12 text-center shadow-lg">
                <div class="w-24 h-24 mx-auto mb-8 rounded-full bg-slate-50 flex items-center justify-center">
                    <svg class="w-12 h-12 text-[#00336E]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-[#00336E] mb-4 font-title">{{ $disabledReason }}</h2>
                <p class="text-slate-500 mb-10 text-lg">Check back later or browse existing words.</p>
                <a href="{{ route('word.browse') }}" class="px-12 py-4 bg-[#00336E] text-white font-bold rounded-full hover:bg-black transition-all shadow-lg">
                    Browse Words
                </a>
            </div>
        @else
            <div class="premium-card bg-white/70 backdrop-blur-3xl rounded-[30px] p-8 md:p-12 shadow-2xl border border-white/40 relative overflow-hidden">
                <!-- Subtle Glass Shine -->
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/40 to-transparent pointer-events-none"></div>

                <form wire:submit="submit" class="space-y-8 relative z-10">
                    <!-- Row 1: Word + Definition -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Word -->
                        <div class="group">
                            <label class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">Word</label>
                            <input type="text" wire:model.live.debounce.500ms="term" required
                                   placeholder="e.g., 'Delulu', 'Rizz'"
                                   class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all duration-300 placeholder:text-[#00336E]/30">
                            @error('term') <span class="text-red-500 text-xs font-bold ml-1 mt-1 block animate-pulse">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Definition -->
                        <div class="group">
                            <label class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">Definition</label>
                            <textarea wire:model="definition" required rows="1"
                                   placeholder="What does it mean?"
                                   class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all duration-300 placeholder:text-[#00336E]/30 min-h-[64px]"></textarea>
                            @error('definition') <span class="text-red-500 text-xs font-bold ml-1 mt-1 block animate-pulse">{{ $message }}</span> @enderror
                        </div>
                    </div>
    
                    <!-- Row 2: Example Sentence -->
                    <div class="group">
                        <label class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">Example Sentence</label>
                        <input type="text" wire:model="example" required
                               placeholder="Use it in a sentence..."
                               class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all duration-300 placeholder:text-[#00336E]/30">
                        @error('example') <span class="text-red-500 text-xs font-bold ml-1 mt-1 block animate-pulse">{{ $message }}</span> @enderror
                    </div>
    
                    <!-- Row 3: Category + Source -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Category -->
                        <div class="group">
                            <label class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">Category</label>
                            <div class="relative">
                                <select wire:model="category" required
                                        class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-bold text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Select a category</option>
                                    <option value="Slang">Slang</option>
                                    <option value="Gen-Z">Gen-Z</option>
                                    <option value="TikTok">TikTok</option>
                                    <option value="Gaming">Gaming</option>
                                    <option value="Memes">Memes</option>
                                    <option value="Internet">Internet</option>
                                    <option value="AAVE">AAVE</option>
                                </select>
                                <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-[#00336E]/50 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        
                        <!-- Source URL -->
                        <div class="group">
                            <label class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">Source URL <span class="text-[#00336E]/40 font-normal ml-1 text-xs normal-case">(Optional)</span></label>
                            <input type="url" wire:model="sourceUrl"
                                   placeholder="https://tiktok.com/..."
                                   class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all duration-300 placeholder:text-[#00336E]/30">
                        </div>
                    </div>
    
                    <!-- Row 4: Alternate Spellings + RFCI -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group">
                            <label class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">Alternate Spellings</label>
                            <input type="text" wire:model="alternateSpellings"
                                   placeholder="e.g. 'rizz', 'riz', 'rizzed'"
                                   class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all duration-300 placeholder:text-[#00336E]/30">
                        </div>
                        <div class="group">
                            <label class="block text-sm font-bold text-[#00336E] mb-2 uppercase tracking-wide">RFCI Score <span class="text-[#00336E]/40 font-normal ml-1 text-xs normal-case">(Optional: e.g. "82A")</span></label>
                            <input type="text" wire:model="rfci_score" placeholder="00X"
                                   class="w-full px-6 py-4 bg-white/50 border-2 border-[#00336E]/10 rounded-[20px] text-[#00336E] font-medium text-lg outline-none focus:border-[#00336E] focus:bg-white transition-all duration-300 placeholder:text-[#00336E]/30 uppercase">
                        </div>
                    </div>
    
                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="inline-flex items-center gap-3 px-8 py-4 bg-[#00336E] text-white font-bold text-lg rounded-full hover:bg-[#002855] transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0">
                            Add Word
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                        <p class="mt-4 text-xs text-[#00336E]/40">By submitting, you agree your entry may be reviewed or edited.</p>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Modal 1: Similar Word Warning -->
    @if($showSimilarModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/80 backdrop-blur-md">
            <div class="bg-white dark:bg-[#00152e] border border-[#00336E]/10 dark:border-white/10 rounded-[32px] p-8 max-w-lg w-full shadow-2xl relative">
                <button wire:click="closeDuplicateModal" class="absolute top-6 right-6 text-[#00336E]/50 dark:text-white/50 hover:text-[#00336E] dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-2xl font-bold text-[#00336E] dark:text-white text-center mb-6 leading-tight">
                    Looks like this word already exists. <br>Want to add a new definition instead?
                </h3>
                
                <div class="flex flex-col gap-3">
                    <a href="{{ route('word.show', $duplicateWordSlug) }}" class="w-full py-4 bg-[#F0F6FB] dark:bg-white/5 hover:bg-[#00336E]/10 dark:hover:bg-white/10 border border-[#00336E]/10 dark:border-white/20 text-[#00336E] dark:text-white font-bold rounded-full text-center transition-colors">
                        View Existing Word ↗
                    </a>
                    <a href="{{ route('word.show', $duplicateWordSlug) }}#contribute" class="w-full py-4 bg-[#00336E] dark:bg-white text-white dark:text-[#00336E] font-bold rounded-full text-center hover:bg-slate-800 dark:hover:bg-brand-accent dark:hover:text-white transition-colors">
                        Add New Definition ↗
                    </a>
                    <button wire:click="closeDuplicateModal" class="w-full py-4 text-[#00336E]/50 dark:text-white/50 font-bold hover:text-[#00336E] dark:hover:text-white transition-colors">
                        Continue Anyway
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal 2: Exact Duplicate Detailed Card -->
    @if($showExactDuplicateModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/80 backdrop-blur-md">
            <div class="bg-white dark:bg-[#00152e] border border-[#00336E]/10 dark:border-white/10 rounded-[32px] p-8 max-w-lg w-full shadow-2xl relative text-center">
                <button wire:click="closeDuplicateModal" class="absolute top-6 right-6 text-[#00336E]/50 dark:text-white/50 hover:text-[#00336E] dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex items-center justify-center mb-4">
                    <div class="text-amber-500 bg-amber-500/10 p-4 rounded-full">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                           <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-[#00336E] dark:text-white mb-4">Duplicate Detected</h3>
                
                <p class="text-[#00336E] dark:text-white/80 text-lg font-medium mb-6 leading-relaxed bg-[#F0F6FB] dark:bg-white/5 p-4 rounded-xl">
                    "{{ $duplicateDefinition }}"
                </p>
                
                <div class="flex flex-row gap-4 justify-center">
                    <a href="{{ route('word.show', $duplicateWordSlug) }}" class="flex-1 py-3 bg-[#F0F6FB] dark:bg-white/5 border border-[#00336E]/10 dark:border-white/10 text-[#00336E] dark:text-white font-bold rounded-full text-center hover:bg-[#00336E]/10 dark:hover:bg-white/10 transition-colors text-sm">
                        View Word ↗
                    </a>
                    <a href="{{ route('word.show', $duplicateWordSlug) }}#contribute" class="flex-1 py-3 bg-[#00336E] dark:bg-white text-white dark:text-[#00336E] font-bold rounded-full text-center hover:bg-slate-800 dark:hover:bg-brand-accent dark:hover:text-white transition-colors text-sm">
                        Add New Definition ↗
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal 3: Success Modal -->
    @if($showSuccessModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/80 backdrop-blur-md">
            <div class="bg-white dark:bg-[#00152e] border border-[#00336E]/10 dark:border-white/10 rounded-[32px] p-10 max-w-md w-full shadow-2xl relative text-center">
                <button wire:click="closeSuccessModal" class="absolute top-6 right-6 text-[#00336E]/50 dark:text-white/50 hover:text-[#00336E] dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex items-center justify-center mb-6 text-green-500 dark:text-green-400">
                     <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                     </svg>
                </div>

                <h3 class="text-3xl font-bold text-[#00336E] dark:text-white mb-2">Word Submitted!</h3>
                <p class="text-[#00336E]/70 dark:text-white/70 text-base font-medium mb-8 leading-relaxed">
                    Your definition will appear once reviewed. Thanks for contributing!
                </p>
                
                <button wire:click="closeSuccessModal" class="px-8 py-3 bg-[#00336E] dark:bg-white text-white dark:text-[#00336E] font-bold rounded-full hover:bg-slate-800 dark:hover:bg-brand-accent dark:hover:text-white transition-colors w-full sm:w-auto shadow-lg">
                    Add Another Word ↗
                </button>
            </div>
        </div>
    @endif
</div>
