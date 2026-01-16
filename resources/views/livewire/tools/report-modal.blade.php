<div x-data="{ open: @entangle('isOpen') }">
    <!-- Backdrop -->
    <div x-show="open" x-cloak
         class="fixed inset-0 bg-slate-900/50 dark:bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Modal -->
        <div @click.away="open = false"
             class="bg-white dark:bg-[#0a1628] rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all border border-transparent dark:border-white/10"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">

            <div class="bg-[#00336E] dark:bg-[#001a38] px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Report Content
                </h3>
                <button @click="open = false" class="text-white/50 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6">
                <p class="text-sm text-slate-500 dark:text-white/60 mb-4">Help us keep the dictionary clean. Why are you flagging this?</p>

                <div class="space-y-3 mb-6">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 dark:border-white/10 cursor-pointer hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <input type="radio" wire:model="reason" value="spam" class="text-[#0F62FE] focus:ring-[#0F62FE]">
                        <span class="text-sm font-bold text-slate-700 dark:text-white">Spam or Advertising</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 dark:border-white/10 cursor-pointer hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <input type="radio" wire:model="reason" value="offensive" class="text-[#0F62FE] focus:ring-[#0F62FE]">
                        <span class="text-sm font-bold text-slate-700 dark:text-white">Offensive / Hateful</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 dark:border-white/10 cursor-pointer hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <input type="radio" wire:model="reason" value="incorrect" class="text-[#0F62FE] focus:ring-[#0F62FE]">
                        <span class="text-sm font-bold text-slate-700 dark:text-white">Factually Incorrect</span>
                    </label>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-400 dark:text-white/40 uppercase tracking-wider mb-2">Details (Optional)</label>
                    <textarea wire:model="details" rows="2" class="w-full rounded-lg border-slate-200 dark:border-white/20 bg-white dark:bg-white/5 text-slate-900 dark:text-white text-sm focus:border-[#0F62FE] focus:ring-[#0F62FE] placeholder:text-slate-400 dark:placeholder:text-white/30" placeholder="Any extra context?"></textarea>
                </div>

                <div class="flex gap-3">
                    <button wire:click="submit" class="flex-1 bg-red-500 text-white font-bold py-2.5 rounded-xl hover:bg-red-600 transition-colors shadow-lg shadow-red-500/30">
                        Submit Report
                    </button>
                    <button @click="open = false" class="px-4 py-2.5 bg-slate-100 dark:bg-white/10 text-slate-600 dark:text-white font-bold rounded-xl hover:bg-slate-200 dark:hover:bg-white/20 transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
