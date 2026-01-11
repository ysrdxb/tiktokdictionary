<div>
    <!-- Success Modal -->
    @if($showSuccess)
        <div
            x-data="{ open: true }"
            x-show="open"
            x-cloak
            x-init="setTimeout(() => { open = false; $wire.set('showSuccess', false) }, 3500)"
            @keydown.escape.window="open = false; $wire.set('showSuccess', false)"
            class="fixed inset-0 z-40 flex items-center justify-center px-6 py-10">
            <div
                class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
                @click="open = false; $wire.set('showSuccess', false)">
            </div>

            <div
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-3 scale-95"
                class="relative w-full max-w-lg bg-white rounded-3xl border border-slate-200 shadow-strong p-8 md:p-10">

                <button
                    type="button"
                    class="absolute top-4 right-4 inline-flex items-center justify-center w-11 h-11 rounded-full bg-white border border-slate-200 text-slate-600 hover:bg-brand-surface hover:text-slate-900 transition-colors"
                    @click="open = false; $wire.set('showSuccess', false)"
                    aria-label="Close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="text-center">
                    <div class="mx-auto w-14 h-14 rounded-2xl bg-brand-panel border border-brand-panelBorder flex items-center justify-center text-brand-dark">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>

                    <h3 class="mt-5 text-2xl md:text-3xl font-extrabold text-brand-dark tracking-tight">Definition added</h3>
                    <p class="mt-2 text-slate-600 font-semibold">Thanks — your definition has been submitted.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Duplicate Warning Modal -->
    @if($showDuplicateModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-[24px] p-8 max-w-lg w-full shadow-2xl relative">
                <button wire:click="$set('showDuplicateModal', false)" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-2xl md:text-3xl font-bold text-[#002B5B] mb-2 text-center leading-tight">
                    @if($duplicateWordSlug)
                        "{{ $duplicateWordTerm }}" Already Exists as a Word.
                    @else
                        {{ $existingCount }} People Already Submitted This Definition.
                    @endif
                </h3>
                
                <p class="text-[#002B5B]/70 text-center font-medium mb-8">
                    @if($duplicateWordSlug)
                        Check out its page instead?
                    @else
                        It already exists above — want to continue?
                    @endif
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button wire:click="redirectToExisting" 
                       class="px-8 py-3 bg-[#002B5B] text-white font-bold rounded-full hover:bg-slate-800 transition-colors text-center shadow-lg shadow-blue-900/10">
                        View Existing ↗
                    </button>
                    <button wire:click="confirmDuplicate" 
                            class="px-8 py-3 bg-white text-[#002B5B] border border-[#002B5B]/20 font-bold rounded-full hover:bg-slate-50 transition-colors">
                        Continue Anyway ↗
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Add Definition Form -->
    <form wire:submit="submit" class="mt-4">
        
        <!-- Definition -->
        <div class="mb-6 relative">
             <div class="absolute top-1/2 -translate-y-1/2 left-5 flex items-center justify-center w-8 h-8 rounded-full bg-black text-white pointer-events-none z-10">
                 <span class="text-sm font-bold">!</span>
            </div>
            <input 
                wire:model="definition"
                type="text"
                placeholder="Text field" 
                class="w-full pl-16 pr-5 py-3 md:py-4 bg-white border border-[#002B5B]/20 rounded-[16px] text-[#002B5B] font-medium placeholder:text-[#002B5B]/30 focus:outline-none focus:border-[#002B5B] focus:ring-2 focus:ring-[#002B5B]/10 transition-all text-base md:text-lg @error('definition') border-red-500 @enderror">
            @error('definition') 
                <p class="text-red-500 text-sm mt-2 ml-1 font-medium">{{ $message }}</p> 
            @enderror
        </div>

        <div class="text-left">
             <!-- Submit Button -->
            <button 
                type="submit"
                class="px-8 py-3 bg-[#002B5B] hover:bg-slate-800 text-white font-bold rounded-full transition-colors shadow-lg shadow-blue-900/10">
                Submit
            </button>
        </div>
    </form>
</div>
