<div>
    <!-- Hero Section -->
    <div class="bg-[#EAF3FE] py-16">
        <div class="max-w-[1240px] mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-[#002B5B] tracking-tight leading-none mb-4">Submit a New Word</h1>
            <p class="text-[#002B5B]/60 text-base font-medium max-w-xl mx-auto">
                Got a new slang, trend, or phrase? Add it to the dictionary.
            </p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white py-12">
        <div class="max-w-[900px] mx-auto px-6">
            
            <form wire:submit="submit" class="space-y-6">
                <!-- Row 1: Word + Definition -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Word -->
                    <div class="relative">
                        <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Word</label>
                        <input type="text" wire:model.live.debounce.500ms="term" required
                               placeholder="Enter the word or phrase (e.g., Delulu, 'NPC', 'Rizz God')"
                               class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] placeholder:text-[#002B5B]/40 @error('term') border-red-500 @enderror">
                        @error('term')
                            <p class="text-red-500 text-xs mt-1 absolute -bottom-5 left-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Definition -->
                    <div class="relative">
                        <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Definition <span class="text-[#002B5B]/40">(helps us verify and track trend origin)</span></label>
                        <input type="text" wire:model="definition" required
                               placeholder="Write the clearest, simplest definition. Avoid long explanations."
                               class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] placeholder:text-[#002B5B]/40 @error('definition') border-red-500 @enderror">
                        @error('definition')
                            <p class="text-red-500 text-xs mt-1 absolute -bottom-5 left-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Row 2: Example Sentence -->
                <div class="relative">
                    <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Example Sentence</label>
                    <textarea wire:model="example" required rows="2"
                              placeholder="Use the word in a real sentence (e.g., 'He's got insane rizz.')"
                              class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] placeholder:text-[#002B5B]/40 resize-none @error('example') border-red-500 @enderror"></textarea>
                    @error('example')
                        <p class="text-red-500 text-xs mt-1 absolute -bottom-5 left-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Row 3: Category + Source URL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div class="relative">
                        <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Category</label>
                        <select wire:model="category" required
                                class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] cursor-pointer appearance-none @error('category') border-red-500 @enderror">
                            <option value="Slang">Slang</option>
                            <option value="Gen-Z">Gen-Z</option>
                            <option value="TikTok">TikTok</option>
                            <option value="Gaming">Gaming</option>
                            <option value="Memes">Memes</option>
                            <option value="Internet">Internet</option>
                            <option value="AAVE">AAVE</option>
                        </select>
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#002B5B] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1 absolute -bottom-5 left-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Source URL -->
                    <div class="relative">
                        <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Where Did You See This Word? (Optional)</label>
                        <input type="url" wire:model="sourceUrl"
                               placeholder="Paste TikTok link (optional) (helps us verify and track trend origin)"
                               class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] placeholder:text-[#002B5B]/40 @error('sourceUrl') border-red-500 @enderror">
                        @error('sourceUrl')
                            <p class="text-red-500 text-xs mt-1 absolute -bottom-5 left-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Row 4: Alternate Spellings -->
                <div class="relative">
                    <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Alternate Spellings</label>
                    <input type="text" wire:model="alternateSpellings"
                           placeholder="Add variations (e.g., 'rizz', 'riz', 'rizzard')*"
                           class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] placeholder:text-[#002B5B]/40 @error('alternateSpellings') border-red-500 @enderror">
                    @error('alternateSpellings')
                        <p class="text-red-500 text-xs mt-1 absolute -bottom-5 left-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Row 5: Hashtags -->
                <div class="relative">
                    <label class="absolute -top-2.5 left-4 px-2 bg-white text-xs font-medium text-[#002B5B]/60 z-10">Hashtags (Optional)</label>
                    <input type="text" wire:model="hashtags"
                           placeholder="Add relevant hashtags (e.g., #TikTokSlang #GenAlpha)"
                           class="w-full px-5 py-4 bg-white text-[#002B5B] font-medium text-base rounded-[16px] border border-[#002B5B]/20 focus:ring-2 focus:ring-[#002B5B]/20 focus:border-[#002B5B] placeholder:text-[#002B5B]/40">
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-[#002B5B] text-white font-bold rounded-full hover:bg-slate-800 transition-colors">
                        Add Word
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>

                <!-- Disclaimer -->
                <p class="text-[#002B5B]/50 text-sm font-medium">
                    By submitting, you agree your entry may be reviewed or edited.
                </p>
            </form>
        </div>
    </div>
    
    <!-- Modal 1: Similar Word Warning (Original Design) -->
    @if($showSimilarModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-[24px] p-8 max-w-lg w-full shadow-2xl relative">
                <button wire:click="closeDuplicateModal" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <!-- Similar Warning Content -->
                <h3 class="text-2xl font-bold text-[#002B5B] text-center mb-6 leading-tight">
                    Looks like this word already exists. <br>Want to add a new definition instead?
                </h3>
                
                <div class="flex flex-col gap-3">
                    <a href="{{ route('word.show', $duplicateWordSlug) }}" class="w-full py-3.5 border border-[#002B5B] text-[#002B5B] font-bold rounded-full text-center hover:bg-slate-50 transition-colors">
                        View Existing Word ↗
                    </a>
                    <a href="{{ route('word.show', $duplicateWordSlug) }}#contribute" class="w-full py-3.5 border border-[#002B5B] text-[#002B5B] font-bold rounded-full text-center hover:bg-slate-50 transition-colors">
                        Add New Definition ↗
                    </a>
                    <button wire:click="closeDuplicateModal" class="w-full py-3.5 border border-[#002B5B] text-[#002B5B] font-bold rounded-full text-center hover:bg-slate-50 transition-colors">
                        Continue Anyway ↗
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal 2: Exact Duplicate Detailed Card (New Design) -->
    @if($showExactDuplicateModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-[24px] p-8 max-w-lg w-full shadow-2xl relative text-center">
                <button wire:click="closeDuplicateModal" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <!-- Warning Icon -->
                <div class="flex items-center justify-center mb-2">
                    <div class="text-amber-500">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                           <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h3 class="text-2xl font-bold text-[#002B5B] mb-4">Duplicate Detected</h3>
                
                <!-- Definition -->
                <p class="text-[#002B5B] text-lg font-medium mb-6 leading-relaxed">
                    {{ $duplicateDefinition }}
                </p>
                
                <!-- Example -->
                @if($duplicateExample)
                    <div class="mb-6">
                        <h4 class="text-[#002B5B] font-bold text-lg mb-1">Example:</h4>
                        <p class="text-[#002B5B]/80 text-base">{{ $duplicateExample }}</p>
                    </div>
                @endif
                
                <!-- Votes -->
                <div class="flex items-center justify-center gap-8 mb-8 text-[#002B5B] font-bold text-lg">
                    <div class="flex items-center gap-2">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                         <span>{{ $duplicateAgrees }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                        <span>{{ $duplicateDisagrees }}</span>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="flex flex-row gap-4 justify-center">
                    <a href="{{ route('word.show', $duplicateWordSlug) }}" class="flex-1 py-3 border border-[#002B5B] text-[#002B5B] font-bold rounded-full text-center hover:bg-slate-50 transition-colors text-sm">
                        View Word ↗
                    </a>
                    <a href="{{ route('word.show', $duplicateWordSlug) }}#contribute" class="flex-1 py-3 border border-[#002B5B] text-[#002B5B] font-bold rounded-full text-center hover:bg-slate-50 transition-colors text-sm">
                        Add New Definition ↗
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal 3: Success Modal (Image 5) -->
    @if($showSuccessModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-[24px] p-10 max-w-md w-full shadow-2xl relative text-center">
                <button wire:click="closeSuccessModal" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <!-- Confetti/Success Icon -->
                <div class="flex items-center justify-center mb-6 text-[#002B5B]">
                     <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                     </svg>
                </div>

                <h3 class="text-3xl font-bold text-[#002B5B] mb-2">Word Submitted!</h3>
                <p class="text-[#002B5B]/70 text-base font-medium mb-8 leading-relaxed">
                    Your definition will appear once reviewed. Thanks for contributing!
                </p>
                
                <button wire:click="closeSuccessModal" class="px-8 py-3 border border-[#002B5B] text-[#002B5B] font-bold rounded-full hover:bg-slate-50 transition-colors w-full sm:w-auto">
                    Add Another Word ↗
                </button>
            </div>
        </div>
    @endif
</div>
