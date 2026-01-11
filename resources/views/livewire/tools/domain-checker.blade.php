<div class="bg-[#002B5B] rounded-2xl p-6 text-white border border-[#2B5F8C] relative overflow-hidden group">
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-[#0F62FE]/20 rounded-full blur-3xl -mr-10 -mt-10"></div>
    
    <div class="relative z-10">
        <h3 class="text-lg font-bold mb-1 flex items-center gap-2">
            <span>🚀</span> Investor View
        </h3>
        <p class="text-white/60 text-sm mb-4">Because this slang might be the next big thing.</p>

        @if(!$hasChecked)
            <div class="flex flex-col gap-3">
                 <div class="p-3 bg-white/5 rounded-lg border border-white/10 font-mono text-sm text-center">
                    {{ $term }}.*
                 </div>
                 <button wire:click="check" 
                    class="w-full py-2 bg-[#0F62FE] hover:bg-[#0F62FE]/90 text-white font-bold rounded-lg transition-all flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="check">Check Availability</span>
                    <span wire:loading wire:target="check" class="flex items-center gap-2">
                         <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Scanning...
                    </span>
                 </button>
            </div>
        @else
            <div class="space-y-3 animate-fade-in-up">
                @foreach($tlds as $tld)
                    <a href="{{ $this->getAffiliateUrl($tld) }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center justify-between p-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg group/domain transition-colors cursor-pointer">
                        <span class="font-mono text-sm font-bold text-white group-hover/domain:text-[#60A5FA]">{{ $term }}.{{ $tld }}</span>
                        <div class="flex items-center gap-2 text-xs font-medium text-white/50">
                            <span>Check</span>
                            <svg class="w-3 h-3 group-hover/domain:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </div>
                    </a>
                @endforeach
                <div class="text-center pt-2">
                     <p class="text-[10px] text-white/40 uppercase tracking-widest">Powered by GoDaddy</p>
                </div>
            </div>
        @endif
    </div>
</div>
