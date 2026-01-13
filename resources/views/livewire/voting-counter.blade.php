<div class="flex items-center gap-6">
    <!-- Agree Button -->
    <button
        wire:click="vote('agree')"
        @if(!$votingEnabled) disabled @endif
        class="group flex items-center gap-2 px-3 py-1.5 rounded-full transition-all border {{ !$votingEnabled ? 'opacity-50 cursor-not-allowed' : '' }} {{ $userVote === 'agree' ? 'bg-green-500/10 border-green-500/30 text-green-600 dark:text-green-400' : 'bg-slate-100 dark:bg-white/5 border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/60 hover:bg-green-50 dark:hover:bg-green-500/10 hover:border-green-300 dark:hover:border-green-500/30 hover:text-green-600 dark:hover:text-green-400' }}"
        title="{{ $votingEnabled ? 'This definition is accurate' : 'Voting is currently disabled' }}"
    >
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="{{ $userVote === 'agree' ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
        </svg>
        <span class="text-xs font-bold" x-data x-counter="{{ $agrees }}">0</span>
    </button>

    <!-- Disagree Button -->
    <button
        wire:click="vote('disagree')"
        @if(!$votingEnabled) disabled @endif
        class="group flex items-center gap-2 px-3 py-1.5 rounded-full transition-all border {{ !$votingEnabled ? 'opacity-50 cursor-not-allowed' : '' }} {{ $userVote === 'disagree' ? 'bg-red-500/10 border-red-500/30 text-red-600 dark:text-red-400' : 'bg-slate-100 dark:bg-white/5 border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/60 hover:bg-red-50 dark:hover:bg-red-500/10 hover:border-red-300 dark:hover:border-red-500/30 hover:text-red-600 dark:hover:text-red-400' }}"
        title="{{ $votingEnabled ? 'This definition is inaccurate' : 'Voting is currently disabled' }}"
    >
        <svg class="w-4 h-4" style="transform: scaleY(-1);" viewBox="0 0 24 24" fill="{{ $userVote === 'disagree' ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
        </svg>
        <span class="text-xs font-bold" x-data x-counter="{{ $disagrees }}">0</span>
    </button>
</div>
