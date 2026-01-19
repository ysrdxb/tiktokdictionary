<div class="flex items-center gap-6">
    <button
        wire:click="vote('agree')"
        @if(!$votingEnabled) disabled @endif
        @click="window.confetti && window.confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 }, colors: ['#00336E', '#F59E0B'] })"
        class="group flex items-center gap-2 transition-all {{ !$votingEnabled ? 'opacity-50 cursor-not-allowed' : '' }} {{ $userVote === 'agree' ? 'text-brand-accent' : 'text-slate-400 hover:text-brand-accent' }}"
        title="{{ $votingEnabled ? 'This definition is accurate' : 'Voting is currently disabled' }}"
    >
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="{{ $userVote === 'agree' ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
        </svg>
        @if($agrees > 0)
            <span class="text-sm font-bold" x-data x-counter="{{ $agrees }}">0</span>
        @endif
    </button>
    <button
        wire:click="vote('disagree')"
        @if(!$votingEnabled) disabled @endif
        class="group flex items-center gap-2 transition-all {{ !$votingEnabled ? 'opacity-50 cursor-not-allowed' : '' }} {{ $userVote === 'disagree' ? 'text-red-400' : 'text-slate-400 hover:text-red-400' }}"
        title="{{ $votingEnabled ? 'This definition is inaccurate' : 'Voting is currently disabled' }}"
    >
        <svg class="w-5 h-5" style="transform: scaleY(-1);" viewBox="0 0 24 24" fill="{{ $userVote === 'disagree' ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
        </svg>
        @if($disagrees > 0)
            <span class="text-sm font-bold" x-data x-counter="{{ $disagrees }}">0</span>
        @endif
    </button>
</div>
