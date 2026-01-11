<div class="flex items-center gap-10 text-[#002B5B]">
    <!-- Agree Button -->
    <button
        wire:click="vote('agree')"
        class="group flex items-center gap-3 transition-opacity hover:opacity-70 {{ $userVote === 'agree' ? 'text-brand-primary' : '' }}"
        title="This definition is accurate"
    >
        <svg class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
        </svg>
        <span class="text-xs font-bold">{{ number_format($agrees) }}</span>
    </button>

    <!-- Disagree Button -->
    <button
        wire:click="vote('disagree')"
        class="group flex items-center gap-3 transition-opacity hover:opacity-70 {{ $userVote === 'disagree' ? 'text-red-500' : '' }}"
        title="This definition is inaccurate"
    >
        <svg class="w-5 h-5" style="transform: scaleY(-1);" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
        </svg>
        <span class="text-xs font-bold">{{ number_format($disagrees) }}</span>
    </button>
</div>
