<div x-data="{ open: @entangle('isOpen') }">
    <!-- Backdrop -->
    <div x-show="open" x-cloak
         class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Modal Container -->
        <div @click.away="open = false; $wire.close()"
             class="relative w-full max-w-lg bg-white rounded-[30px] overflow-hidden shadow-2xl border border-white/50 flex flex-col max-h-[90vh]"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">

            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-white z-10">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🍿</span>
                    <span class="text-[#00336E] font-bold uppercase tracking-widest text-sm">Receipt: {{ $term }}</span>
                </div>
                <button @click="open = false; $wire.close()" class="text-[#00336E]/30 hover:text-[#00336E] transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Video Container -->
            <div class="flex-1 overflow-y-auto p-4 flex flex-col items-center justify-center bg-slate-50"
                 wire:ignore
                 x-data="{ scriptLoaded: false }"
                 x-init="
                    $watch('open', value => {
                        if (value) {
                             scriptLoaded = false;
                             // Wait for modal transition (300ms) + small buffer
                            setTimeout(() => {
                                let script = document.getElementById('tiktok-embed-script');
                                if (script) { script.remove(); }
                                
                                script = document.createElement('script');
                                script.id = 'tiktok-embed-script';
                                script.src = 'https://www.tiktok.com/embed.js';
                                script.async = true;
                                script.onload = () => { scriptLoaded = true; };
                                document.body.appendChild(script);
                            }, 350);
                        }
                    })
                 ">
                
                @if($sourceUrl)
                    <blockquote class="tiktok-embed" cite="{{ $sourceUrl }}" data-video-id="{{ Str::afterLast(rtrim($sourceUrl, '/'), '/') }}" style="max-width: 605px;min-width: 325px;">
                        <section> 
                            <div class="flex flex-col items-center gap-4">
                                <span class="animate-pulse text-[#00336E]/50 font-bold tracking-widest uppercase text-xs">Loading Receipt...</span>
                                <button @click="
                                    let script = document.getElementById('tiktok-embed-script');
                                    if (script) { script.remove(); }
                                    script = document.createElement('script');
                                    script.id = 'tiktok-embed-script';
                                    script.src = 'https://www.tiktok.com/embed.js';
                                    script.async = true;
                                    document.body.appendChild(script);
                                " class="text-xs text-pink-500 underline font-bold px-4 py-2 bg-white rounded-full hover:bg-slate-50 border border-slate-100 shadow-sm transition-all">Tap to Retry</button>
                            </div>
                        </section> 
                    </blockquote>
                @else
                    <div class="text-[#00336E]/30 py-10 font-bold">No receipt URL found.</div>
                @endif
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-slate-100 bg-white text-center">
                 <a href="{{ $sourceUrl }}" target="_blank" class="text-xs font-bold text-[#00336E]/30 hover:text-[#00336E] transition-colors uppercase tracking-widest">
                    Open in TikTok App
                 </a>
            </div>

        </div>
    </div>
</div>
