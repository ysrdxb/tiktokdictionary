<div x-data="{ open: @entangle('isOpen') }">
    <div x-show="open" x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-xl"
         x-transition:enter="ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.away="open = false"
             class="relative w-full max-w-xl overflow-hidden rounded-[40px] shadow-2xl transform transition-all group"
             x-transition:enter="ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-8">
            
            <!-- Dynamic Background -->
            <div class="absolute inset-0 bg-[#00152e]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-[#00336E]/40 to-transparent"></div>
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-brand-accent/20 rounded-full blur-[100px] animate-pulse"></div>

            <div class="relative z-10 p-8 md:p-12 text-center">
                <!-- Close Button -->
                <button @click="open = false" class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/5 hover:bg-white/10 text-white/50 hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Premium Header -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-accent/10 border border-brand-accent/20 mb-8 backdrop-blur-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-accent animate-[ping_2s_infinite]"></span>
                    <span class="text-[10px] font-black text-brand-accent uppercase tracking-[0.2em]">Digital Asset detected</span>
                </div>

                <!-- Main Domain Display -->
                <div class="mb-10 relative">
                    <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-2 drop-shadow-2xl">
                        {{ strtolower($domain) }}
                    </h2>
                    <p class="text-white/60 text-sm font-medium">
                        Own the internet address for <span class="text-white border-b border-white/20">{{ $term }}</span>.
                    </p>
                </div>

                <!-- Primary Call to Action -->
                <a href="https://www.godaddy.com/domainsearch/find?checkAvail=1&domainToCheck={{ $domain }}" target="_blank" rel="noopener noreferrer" 
                   class="relative block w-full group/btn overflow-hidden rounded-2xl bg-white p-1 mb-8 hover:scale-[1.01] transition-transform duration-300 shadow-[0_0_40px_rgba(255,255,255,0.1)] hover:shadow-[0_0_60px_rgba(255,255,255,0.2)]">
                    <div class="relative bg-gradient-to-r from-[#FFB703] to-[#FFD700] rounded-xl py-5 px-8 flex items-center justify-center gap-3 overflow-hidden">
                         <!-- Shine Effect -->
                        <div class="absolute top-0 -left-[100%] w-full h-full bg-gradient-to-r from-transparent via-white/40 to-transparent skew-x-12 transition-all duration-1000 group-hover/btn:left-[100%]"></div>
                        
                        <span class="text-[#00336E] font-black uppercase tracking-widest text-sm relative z-10 flex items-center gap-2">
                            Secure This Domain
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </span>
                    </div>
                </a>

                <!-- Smart Alternatives -->
                <div class="text-left">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <span class="text-xs font-bold text-white/30 uppercase tracking-widest">Smart Alternatives</span>
                        <span class="text-[10px] font-bold text-white/20">Powered by GoDaddy</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(array_slice($suggestions, 0, 4) as $suggestion)
                            <a href="https://www.godaddy.com/domainsearch/find?checkAvail=1&domainToCheck={{ $suggestion }}" target="_blank" 
                               class="flex flex-col items-center justify-center p-4 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-brand-accent/30 transition-all group/item">
                                <span class="text-white font-bold text-sm mb-1 group-hover/item:text-brand-accent transition-colors">{{ $suggestion }}</span>
                                <span class="text-[10px] font-bold text-white/30 group-hover/item:text-white/50">Check</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Bottom Brand Bar -->
            <div class="bg-[#000d1c] p-4 text-center border-t border-white/5">
                <p class="text-[10px] text-white/20 font-medium">
                    Domains are unique assets. Prices and availability are subject to change.
                </p>
            </div>
        </div>
    </div>
</div>
