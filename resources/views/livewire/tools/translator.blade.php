<div class="min-h-screen bg-[#EFF6FE] py-12 px-4 sm:px-6">
    <div class="max-w-[1240px] mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-16 space-y-4">
            <div class="inline-flex items-center justify-center p-3 bg-white rounded-full shadow-sm mb-4">
                <span class="text-4xl filter drop-shadow-sm">🧙‍♂️</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-[#00336E] uppercase tracking-tighter">
                The Boomer <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-600">Translator</span>
            </h1>
            <p class="text-lg text-[#00336E]/60 font-medium max-w-2xl mx-auto">
                Stop talking like an NPC. Turn your boring emails into absolute cinema.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            
            <!-- Left: Boomer Input -->
            <div class="premium-card bg-white p-8 rounded-[40px] shadow-xl border border-[#00336E]/5 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-slate-400 to-slate-200"></div>
                
                <h3 class="text-xl font-black text-[#00336E] uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="text-2xl">👔</span> Formal English
                </h3>

                <textarea 
                    wire:model="inputText"
                    placeholder="e.g. 'I am very happy to see you today, my friend.'"
                    class="w-full h-64 bg-slate-50 border-2 border-slate-200 rounded-[20px] p-6 text-lg text-slate-700 outline-none focus:border-[#00336E]/30 focus:bg-white transition-all resize-none placeholder:text-slate-400 font-serif leading-relaxed"
                ></textarea>

                <div class="mt-6 flex justify-end">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                        {{ strlen($inputText) }}/500 chars
                    </span>
                </div>
            </div>

            <!-- Arrow (Desktop) -->
            <div class="hidden lg:flex items-center justify-center h-full pt-32">
                <div class="bg-white p-4 rounded-full shadow-lg border border-[#00336E]/10 animate-pulse">
                    <svg class="w-8 h-8 text-[#00336E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </div>

            <!-- Right: Gen Z Output -->
            <div class="premium-card bg-white p-8 rounded-[40px] shadow-xl border border-purple-500/10 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 animate-gradient-x"></div>
                
                <h3 class="text-xl font-black text-[#00336E] uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="text-2xl">✨</span> Gen Z Logic
                </h3>

                <div class="relative w-full h-64 bg-[#F0F6FB] border-2 border-[#00336E]/5 rounded-[20px] p-6 flex flex-col items-center justify-center text-center">
                    
                    @if($isLoading)
                        <div class="space-y-4">
                            <div class="w-12 h-12 border-4 border-[#00336E] border-t-transparent rounded-full animate-spin"></div>
                            <p class="text-sm font-bold text-[#00336E] animate-pulse">Cooking...</p>
                        </div>
                    @elseif($outputText)
                        <p class="text-2xl md:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-br from-[#00336E] to-purple-600 leading-snug">
                            "{{ $outputText }}"
                        </p>
                        <div class="absolute bottom-4 right-4">
                             <button onclick="navigator.clipboard.writeText('{{ addslashes($outputText) }}'); alert('Copied to clipboard!')" 
                                     class="p-2 bg-white rounded-full shadow-sm hover:scale-110 transition-transform text-[#00336E]/50 hover:text-brand-accent" title="Copy">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                             </button>
                        </div>
                    @else
                        <span class="text-[#00336E]/30 font-bold text-lg">
                            Translation will appear here...<br>
                            <span class="text-sm font-normal opacity-70">No cap.</span>
                        </span>
                    @endif

                </div>

                <div class="mt-6">
                    <button wire:click="translate" 
                            wire:loading.attr="disabled"
                            class="w-full py-4 bg-[#00336E] text-white font-black text-xl rounded-2xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-3">
                        <span wire:loading.remove>✨ Translate to Brainrot</span>
                        <span wire:loading>Processing...</span>
                    </button>
                    <!-- Confetti trigger when done -->
                    <div x-data="{ show: @entangle('outputText') }" x-effect="if(show && show.length > 0) window.confetti({ particleCount: 150, spread: 100, origin: { y: 0.6 } })"></div>
                </div>
            </div>

        </div>

    </div>
</div>
