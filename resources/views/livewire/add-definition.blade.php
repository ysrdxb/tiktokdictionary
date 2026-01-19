<div x-data="{ 
    showSuccess: @entangle('showSuccess'),
    showDuplicate: @entangle('showDuplicateModal')
}">
    <!-- Success Modal Teleported to Body -->
    <template x-teleport="body">
        <div x-show="showSuccess" 
             x-cloak 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-init="window.confetti && window.confetti({ particleCount: 200, spread: 150, origin: { y: 0.6 }, drift: 0.5, ticks: 200 })">
            
            <div class="relative w-full max-w-md bg-white dark:bg-[#00152e] border border-[#00336E]/10 dark:border-white/10 rounded-[32px] p-10 text-center shadow-2xl"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 @click.outside="showSuccess = false">

                 <button @click="showSuccess = false" class="absolute top-6 right-6 text-[#00336E]/50 dark:text-white/50 hover:text-[#00336E] dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </button>
                 
                 <div class="flex items-center justify-center mb-6 text-green-500 dark:text-green-400">
                     <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                     </svg>
                 </div>
                 
                 <h3 class="text-3xl font-bold text-[#00336E] dark:text-white mb-2 font-title">Success!</h3>
                 <p class="text-[#00336E]/70 dark:text-white/70 text-base font-medium mb-8 leading-relaxed">Your definition will appear once reviewed. Thanks for contributing!</p>
                 
                 <button @click="showSuccess = false" 
                         class="px-8 py-3 bg-[#00336E] dark:bg-white text-white dark:text-[#00336E] font-bold rounded-full hover:bg-brand-accent dark:hover:bg-brand-accent dark:hover:text-[#00336E] transition-colors w-full sm:w-auto shadow-lg">
                    Add Another Definition ↗
                 </button>
            </div>
        </div>
    </template>

    <!-- Duplicate Modal Teleported to Body -->
    <template x-teleport="body">
        <div x-show="showDuplicate" 
             x-cloak 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            
            <div class="relative w-full max-w-lg bg-white dark:bg-[#00152e] border border-[#00336E]/10 dark:border-white/10 rounded-[32px] p-8 text-center shadow-2xl"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 @click.outside="showDuplicate = false">
                
                <button @click="showDuplicate = false" class="absolute top-6 right-6 text-[#00336E]/50 dark:text-white/50 hover:text-[#00336E] dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex items-center justify-center mb-4">
                    <div class="text-amber-500 bg-amber-500/10 p-4 rounded-full">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                           <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-[#00336E] dark:text-white mb-4 font-title">Duplicate Detected</h3>
                <p class="text-[#00336E] dark:text-white/80 text-lg font-medium mb-6 leading-relaxed bg-[#F0F6FB] dark:bg-white/5 p-4 rounded-xl">
                    This definition might essentially already exist.
                </p>

                <div class="flex flex-row gap-4 justify-center">
                    <button wire:click="redirectToExisting" class="flex-1 py-3 bg-[#F0F6FB] dark:bg-white/5 border border-[#00336E]/10 dark:border-white/10 text-[#00336E] dark:text-white font-bold rounded-full text-center hover:bg-[#00336E]/10 dark:hover:bg-white/10 transition-colors text-sm">
                        View Existing ↗
                    </button>
                    <button wire:click="confirmDuplicate" class="flex-1 py-3 bg-[#00336E] dark:bg-white text-white dark:text-[#00336E] font-bold rounded-full text-center hover:bg-brand-accent dark:hover:bg-brand-accent dark:hover:text-[#00336E] transition-colors text-sm">
                        Add Anyway ↗
                    </button>
                </div>
            </div>
        </div>
    </template>

    <!-- Form Section -->
    @if($disabledReason)
        <div class="mt-4 p-8 bg-slate-50 rounded-[24px] border border-slate-200 text-center">
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">{{ $disabledReason }}</p>
        </div>
    @else
        <form wire:submit.prevent="submit" class="mt-4">
            <div class="space-y-4">
                 <div class="relative group">
                      <div class="absolute top-1/2 -translate-y-1/2 left-4 w-6 h-6 rounded-full bg-black text-white flex items-center justify-center z-10">
                          <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                      </div>
                      <input wire:model="definition" 
                             type="text" 
                             placeholder="Text field" 
                             class="w-full pl-14 pr-4 py-4 bg-white border border-[#00336E]/20 rounded-lg text-[#00336E] font-medium text-sm focus:outline-none focus:border-[#00336E] transition-all placeholder:text-[#00336E]/40">
                 </div>

                 <button type="submit" class="px-8 py-3 bg-[#00336E] text-white font-medium text-sm rounded-full hover:bg-brand-accent hover:text-[#00336E] transition-all shadow-sm">
                    Submit
                </button>
            </div>
            @error('definition')
                <p class="text-red-500 text-[10px] font-bold mt-2 ml-1">{{ $message }}</p>
            @enderror
        </form>
    @endif
</div>
