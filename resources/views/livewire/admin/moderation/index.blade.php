<div class="px-6 py-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white mb-2">Moderation Queue</h1>
            <p class="text-slate-400">Review and approve new submissions.</p>
        </div>
        
        <!-- Tabs -->
        <div class="flex p-1 bg-[#001a3a] rounded-lg border border-white/10">
            <button 
                wire:click="setTab('words')" 
                class="px-4 py-2 text-sm font-bold rounded-md transition-colors {{ $activeTab === 'words' ? 'bg-amber-500 text-black' : 'text-slate-400 hover:text-white' }}"
            >
                New Words
            </button>
            <button 
                wire:click="setTab('definitions')" 
                class="px-4 py-2 text-sm font-bold rounded-md transition-colors {{ $activeTab === 'definitions' ? 'bg-amber-500 text-black' : 'text-slate-400 hover:text-white' }}"
            >
                New Definitions
            </button>
        </div>
    </div>

    <!-- Words Tab -->
    @if($activeTab === 'words')
        <div class="space-y-4">
            @forelse($words as $word)
                <div class="bg-[#001a3a] border border-white/10 rounded-2xl p-6 flex flex-col md:flex-row md:items-center justify-between gap-6" wire:key="word-{{ $word->id }}">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-white">{{ $word->term }}</h3>
                            <span class="px-2 py-1 bg-white/10 text-xs font-bold text-white/70 rounded">{{ $word->category ?? 'Uncategorized' }}</span>
                        </div>
                        <p class="text-slate-400 text-sm mb-1">Submitted {{ $word->created_at->diffForHumans() }}</p>
                        @if($word->definitions_count > 0)
                            <p class="text-amber-500 text-sm font-bold">Has {{ $word->definitions_count }} definition(s)</p>
                        @else
                            <p class="text-red-400 text-sm">No definitions (Stub)</p>
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <button 
                            wire:click="rejectWord({{ $word->id }})" 
                            wire:confirm="Are you sure you want to delete this word?"
                            class="px-4 py-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-500 font-bold text-sm border border-red-500/20 transition-colors"
                        >
                            Reject & Delete
                        </button>
                        <button 
                            wire:click="approveWord({{ $word->id }})" 
                            class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-bold text-sm shadow-lg shadow-green-500/20 transition-all transform hover:scale-105"
                        >
                            Approve Word
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-[#001a3a] rounded-2xl border border-white/10 border-dashed">
                    <p class="text-slate-500 font-bold">No pending words to review.</p>
                </div>
            @endforelse
            
            <div class="mt-4">
                {{ $words->links() }}
            </div>
        </div>
    @endif

    <!-- Definitions Tab -->
    @if($activeTab === 'definitions')
        <div class="space-y-4">
            @forelse($definitions as $def)
                <div class="bg-[#001a3a] border border-white/10 rounded-2xl p-6 flex flex-col md:flex-row md:items-start justify-between gap-6" wire:key="def-{{ $def->id }}">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-slate-400 text-sm">Definition for:</span>
                            <a href="{{ route('word.show', $def->word->slug) }}" target="_blank" class="text-amber-500 font-bold hover:underline">{{ $def->word->term }}</a>
                        </div>
                        
                        <div class="bg-black/20 rounded-lg p-4 mb-3 border border-white/5">
                            <p class="text-white text-lg font-medium mb-2">{{ $def->definition }}</p>
                            @if($def->example)
                                <p class="text-slate-400 italic text-sm">"{{ $def->example }}"</p>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-4 text-xs text-slate-500 font-bold">
                            <span>Author: {{ $def->submitted_by ?? 'Anonymous' }}</span>
                            <span>•</span>
                            <span>{{ $def->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-3 min-w-[140px]">
                        <button 
                            wire:click="approveDefinition({{ $def->id }})" 
                            class="w-full px-4 py-3 rounded-lg bg-green-500 hover:bg-green-600 text-white font-bold text-sm shadow-lg shadow-green-500/20 transition-all text-center"
                        >
                            Approve
                        </button>
                        <button 
                            wire:click="rejectDefinition({{ $def->id }})" 
                            wire:confirm="Delete this definition?"
                            class="w-full px-4 py-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-500 font-bold text-sm border border-red-500/20 transition-colors text-center"
                        >
                            Reject
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-[#001a3a] rounded-2xl border border-white/10 border-dashed">
                    <p class="text-slate-500 font-bold">No pending definitions to review.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $definitions->links() }}
            </div>
        </div>
    @endif
</div>
