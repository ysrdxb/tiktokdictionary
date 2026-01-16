@props(['term', 'definition' => null])

<div x-data="{ 
    playing: false,
    async playAudio() {
        if(this.playing) return;
        this.playing = true;
        // Construct text to speak: Term + (optional) Definition
        const text = '{{ addslashes($term) }}' + ('{{ $definition ? ': ' . addslashes($definition) : '' }}');
        
        try {
            const audio = await puter.ai.txt2speech(text, { voice: 'Kimberly', speed: 1.1 });
            audio.onended = () => { this.playing = false; };
            audio.play();
        } catch (error) {
            console.error('Audio failed:', error);
            this.playing = false;
        }
    }
}" class="inline-block">
    <button 
        @click="playAudio()"
        :class="playing ? 'bg-brand-accent text-white ring-4 ring-brand-accent/30' : 'bg-[#F0F6FB] dark:bg-white/10 text-[#00336E] dark:text-white hover:bg-[#00336E]/10 dark:hover:bg-white/20'"
        class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold transition-all backdrop-blur-md border border-[#00336E]/5 dark:border-white/5"
    >
        <span x-show="!playing" class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg> 
            Listen to Pronunciation
        </span>
        <span x-show="playing" class="flex items-center gap-2" x-cloak>
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
            Playing...
        </span>
    </button>
</div>
