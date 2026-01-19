<div x-data="{ open: @entangle('isOpen') }">
    <div x-show="open" x-cloak
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-[100] flex items-center justify-center p-4"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.away="open = false"
             class="relative w-full max-w-lg bg-white dark:bg-[#00152e] rounded-[32px] p-8 md:p-10 shadow-2xl border border-[#00336E]/10 dark:border-white/10"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <button @click="open = false" class="absolute top-6 right-6 text-[#00336E]/30 hover:text-[#00336E] transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-brand-accent/10 text-brand-accent mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#00336E] dark:text-white mb-2 font-title">Start Your Legacy</h2>
                <p class="text-[#00336E]/60 dark:text-white/60 font-medium">Claim this domain before someone else does.</p>
            </div>

            <!-- Main Domain -->
            <div class="bg-[#F3F6F9] dark:bg-white/5 rounded-2xl p-6 mb-8 text-center group transition-colors hover:bg-[#E8EEF5] dark:hover:bg-white/10">
                <h3 class="text-2xl md:text-3xl font-black text-[#00336E] dark:text-white mb-4 tracking-tight">{{ $domain }}</h3>
                <a href="https://www.godaddy.com/domainsearch/find?checkAvail=1&domainToCheck={{ $domain }}" target="_blank" rel="noopener noreferrer" 
                   class="inline-flex items-center gap-2 px-8 py-3 bg-[#00336E] text-white font-bold rounded-full hover:bg-brand-accent hover:text-[#00336E] transition-all shadow-lg active:scale-95">
                    Check Availability ↗
                </a>
            </div>

            <!-- Suggestions -->
            <div class="space-y-3">
                <p class="text-xs font-bold text-[#00336E]/40 uppercase tracking-widest text-center mb-4">Alternatives</p>
                @foreach($suggestions as $suggestion)
                    <a href="https://www.godaddy.com/domainsearch/find?checkAvail=1&domainToCheck={{ $suggestion }}" target="_blank" class="flex items-center justify-between p-4 rounded-xl border border-[#00336E]/10 hover:border-[#00336E]/30 hover:bg-slate-50 transition-all group">
                        <span class="font-bold text-[#00336E]">{{ $suggestion }}</span>
                        <span class="text-[#00336E]/40 group-hover:text-brand-accent transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
