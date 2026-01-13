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
                class="absolute inset-0 bg-slate-900/60 dark:bg-black/60 backdrop-blur-sm"
                @click="open = false; $wire.set('showSuccess', false)">
            </div>

            <div
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-3 scale-95"
                class="relative w-full max-w-lg bg-white dark:bg-[#0a1628] rounded-3xl border border-slate-200 dark:border-white/10 shadow-strong p-8 md:p-10">

                <button
                    type="button"
                    class="absolute top-4 right-4 inline-flex items-center justify-center w-11 h-11 rounded-full bg-white dark:bg-white/10 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/60 hover:bg-slate-100 dark:hover:bg-white/20 hover:text-slate-900 dark:hover:text-white transition-colors"
                    @click="open = false; $wire.set('showSuccess', false)"
                    aria-label="Close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="text-center">
                    <div class="mx-auto w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 border border-emerald-200 dark:border-emerald-500/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>

                    <h3 class="mt-5 text-2xl md:text-3xl font-extrabold text-[#002B5B] dark:text-white tracking-tight">Definition added</h3>
                    <p class="mt-2 text-slate-600 dark:text-white/60 font-semibold">Thanks — your definition has been submitted.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Duplicate Warning Modal -->
    @if($showDuplicateModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-black/40 dark:bg-black/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-[#0a1628] rounded-[24px] p-8 max-w-lg w-full shadow-2xl relative border border-transparent dark:border-white/10">
                <button wire:click="$set('showDuplicateModal', false)" class="absolute top-6 right-6 text-slate-400 dark:text-white/40 hover:text-slate-600 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <h3 class="text-2xl md:text-3xl font-bold text-[#002B5B] dark:text-white mb-2 text-center leading-tight">
                    @if($duplicateWordSlug)
                        "{{ $duplicateWordTerm }}" Already Exists as a Word.
                    @else
                        {{ $existingCount }} People Already Submitted This Definition.
                    @endif
                </h3>

                <p class="text-[#002B5B]/70 dark:text-white/60 text-center font-medium mb-8">
                    @if($duplicateWordSlug)
                        Check out its page instead?
                    @else
                        It already exists above — want to continue?
                    @endif
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button wire:click="redirectToExisting"
                       class="px-8 py-3 bg-[#002B5B] dark:bg-brand-accent text-white dark:text-[#002B5B] font-bold rounded-full hover:bg-slate-800 dark:hover:bg-brand-accent/90 transition-colors text-center shadow-lg shadow-blue-900/10 dark:shadow-brand-accent/20">
                        View Existing
                    </button>
                    <button wire:click="confirmDuplicate"
                            class="px-8 py-3 bg-white dark:bg-white/10 text-[#002B5B] dark:text-white border border-[#002B5B]/20 dark:border-white/20 font-bold rounded-full hover:bg-slate-50 dark:hover:bg-white/20 transition-colors">
                        Continue Anyway
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Add Definition Form -->
    @if($disabledReason)
        <!-- Disabled State -->
        <div class="mt-4 p-6 bg-slate-100 dark:bg-white/5 rounded-[16px] border border-slate-200 dark:border-white/10 text-center">
            <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-200 dark:bg-white/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-slate-400 dark:text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <p class="text-slate-600 dark:text-white/60 font-medium">{{ $disabledReason }}</p>
            @if($requireLogin && !auth()->check())
                <a href="{{ route('login') }}" class="inline-block mt-4 px-6 py-2 bg-[#002B5B] dark:bg-brand-accent text-white dark:text-[#002B5B] font-bold rounded-full hover:opacity-90 transition-opacity">
                    Log In
                </a>
            @endif
        </div>
    @else
        <form wire:submit="submit" class="mt-4">

            <!-- Definition -->
            <div class="mb-6 relative">
                 <div class="absolute top-1/2 -translate-y-1/2 left-5 flex items-center justify-center w-8 h-8 rounded-full bg-[#002B5B] dark:bg-white text-white dark:text-[#002B5B] pointer-events-none z-10">
                     <span class="text-sm font-bold">!</span>
                </div>
                <input
                    wire:model="definition"
                    type="text"
                    placeholder="Add your definition..."
                    class="w-full pl-16 pr-5 py-3 md:py-4 bg-white dark:bg-white/5 border border-[#002B5B]/20 dark:border-white/20 rounded-[16px] text-[#002B5B] dark:text-white font-medium placeholder:text-[#002B5B]/30 dark:placeholder:text-white/30 focus:outline-none focus:border-[#002B5B] dark:focus:border-brand-accent focus:ring-2 focus:ring-[#002B5B]/10 dark:focus:ring-brand-accent/20 transition-all text-base md:text-lg @error('definition') border-red-500 @enderror">
                @error('definition')
                    <p class="text-red-500 text-sm mt-2 ml-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-left">
                 <!-- Submit Button -->
                <button
                    type="submit"
                    class="px-8 py-3 bg-[#002B5B] dark:bg-brand-accent hover:bg-slate-800 dark:hover:bg-brand-accent/90 text-white dark:text-[#002B5B] font-bold rounded-full transition-colors shadow-lg shadow-blue-900/10 dark:shadow-brand-accent/20">
                    Submit
                </button>
            </div>
        </form>
    @endif
</div>
