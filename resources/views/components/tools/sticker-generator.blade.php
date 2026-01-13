@props(['word', 'definition'])

<div x-data="{
    generating: false,
    async generateSticker() {
        this.generating = true;
        
        // Wait for Alpine to render the hidden element if needed
        await new Promise(resolve => setTimeout(resolve, 100));
        
        const element = document.getElementById('sticker-template-{{ $word->id }}');
        
        // Temporarily reveal the element off-screen for capture
        element.style.display = 'flex';
        
        try {
            const canvas = await html2canvas(element, {
                scale: 2, // High resolution
                backgroundColor: null,
                logging: false,
                useCORS: true
            });
            
            // Create download link
            const link = document.createElement('a');
            link.download = '{{ $word->slug }}-sticker.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            
        } catch (error) {
            console.error('Sticker generation failed:', error);
            alert('Could not generate sticker. Please try again.');
        } finally {
            // Hide the element again
            element.style.display = 'none';
            this.generating = false;
        }
    }
}">
    <!-- Trigger Button -->
    <button @click="generateSticker" :disabled="generating" class="inline-flex items-center gap-2 px-4 py-2 bg-[#002B5B]/10 dark:bg-white/10 hover:bg-[#002B5B]/20 dark:hover:bg-white/20 text-[#002B5B] dark:text-white text-sm font-bold rounded-lg transition-colors disabled:opacity-50 border border-[#002B5B]/10 dark:border-white/10">
        <svg x-show="!generating" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
        <svg x-show="generating" x-cloak class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
        <span x-text="generating ? 'Creating Sticker...' : 'Share as Sticker'"></span>
    </button>

    <!-- Hidden Sticker Template (1080x1920 ratio equivalent) -->
    <!-- We render this hidden, but force display block during capture -->
    <div id="sticker-template-{{ $word->id }}" style="display: none;" class="fixed top-0 left-0 w-[400px] h-[711px] bg-gradient-to-br from-[#0F62FE] to-[#fe2c55] text-white p-8 flex-col justify-between overflow-hidden shadow-2xl z-[-100]">
        
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 blur-[60px] rounded-full -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 blur-[40px] rounded-full -ml-10 -mb-10"></div>

        <!-- Header -->
        <div class="relative z-10 pt-4">
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest border border-white/20">Viral Trend</span>
            </div>
        </div>

        <!-- Main Content (Centered) -->
        <div class="relative z-10 flex-1 flex flex-col justify-center">
            <h1 class="text-6xl font-black mb-6 leading-[0.9] tracking-tight drop-shadow-lg break-words">
                {{ $word->term }}
            </h1>
            
            <div class="w-16 h-2 bg-white/30 rounded-full mb-8"></div>
            
            <p class="text-2xl font-bold leading-relaxed opacity-95 drop-shadow-md">
                "{{ Str::limit($definition, 150) }}"
            </p>
            
            <div class="mt-8 flex items-center gap-3 opacity-80">
                <div class="px-4 py-2 bg-black/20 rounded-lg text-sm font-mono border border-white/10">
                    Verified on TikTokDictionary.com
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="relative z-10 mt-auto pt-8 border-t border-white/20 flex items-center justify-between">
            <div class="font-bold text-xl tracking-tight">TikTok<span class="opacity-80 font-normal">Dictionary</span></div>
            <div class="text-xs uppercase bg-white text-brand-dark font-black px-2 py-1 transform -rotate-2">
                #{{ str_replace(' ', '', $word->category) }}
            </div>
        </div>
    </div>
</div>
