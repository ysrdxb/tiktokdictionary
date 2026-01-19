<div x-data="{ open: @entangle('isOpen') }">
    <div x-show="open" x-cloak
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-50 flex items-center justify-center p-4 transition-opacity"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.away="open = false"
             class="relative flex flex-col items-center gap-6 transform transition-all"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">

            <div class="text-white font-bold uppercase tracking-widest text-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                Share to Story
            </div>

            <div id="story-card" 
                 class="w-[320px] aspect-[9/16] rounded-[24px] p-8 flex flex-col items-center justify-center text-center relative overflow-hidden shadow-2xl border border-white/10 bg-[#00336E]">

                <div class="relative z-10 flex flex-col h-full justify-between py-6">
                    <div class="text-white/40 text-[10px] uppercase font-black tracking-[0.2em]">TikTok Dictionary</div>

                    <div>
                        <h1 class="text-4xl font-black text-white font-[GRIFTER] mb-4 leading-none break-words">
                            {{ $term }}
                        </h1>
                        <div class="w-12 h-1 bg-brand-accent mx-auto rounded-full mb-6"></div>
                        <p class="text-white/90 text-lg font-medium leading-relaxed italic">
                            "{{ Str::limit($definition, 150) }}"
                        </p>
                    </div>

                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 bg-[#ffffff20] px-4 py-2 rounded-full border border-white/20">
                             <span class="text-xl">🔥</span>
                             <span class="text-white text-xs font-bold uppercase tracking-wider">Trending Now</span>
                        </div>
                        <div class="text-white/30 text-[10px] font-bold mt-4">tiktokdictionary.com</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 w-full max-w-[320px]" x-data="{ downloading: false }">
                <button @click="
                            downloading = true;
                            const card = document.getElementById('story-card');
                            html2canvas(card, { scale: 2, backgroundColor: null }).then(canvas => {
                                const link = document.createElement('a');
                                link.download = 'tiktok-dictionary-{{ Str::slug($term) }}.png';
                                link.href = canvas.toDataURL();
                                link.click();
                                $dispatch('notify', 'Image downloaded successfully!');
                                downloading = false;
                                open = false;
                            });
                        " 
                        class="w-full py-4 bg-white text-[#00336E] font-bold rounded-xl hover:bg-brand-accent hover:text-[#00336E] transition-all shadow-lg active:scale-[0.98] flex items-center justify-center gap-2">
                    <span x-show="!downloading" class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download Image
                    </span>
                    <span x-show="downloading" class="flex items-center gap-2 animate-pulse">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Saving...
                    </span>
                </button>
                <button @click="open = false" class="text-white/50 text-sm font-bold hover:text-white transition-colors py-2">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
