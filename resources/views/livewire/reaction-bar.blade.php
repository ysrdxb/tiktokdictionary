<div class="flex items-center gap-2 p-1.5 bg-slate-50 dark:bg-white/5 rounded-full border border-slate-200 dark:border-white/10 shadow-sm">
    
    <!-- Fire: Hot/Trending -->
    <button wire:click="react('fire')" title="It's trending"
        class="relative px-3 py-1.5 rounded-full transition-all flex items-center gap-1.5 {{ $userReaction === 'fire' ? 'bg-orange-500/10 text-orange-600 border border-orange-500/20' : 'hover:bg-white hover:shadow-sm text-slate-500' }}">
        <span class="text-lg leading-none filter {{ $userReaction === 'fire' ? '' : 'grayscale opacity-70 hover:grayscale-0 hover:opacity-100' }} transition-all">🔥</span>
        @if($counts['fire'] > 0)
            <span class="text-[10px] font-bold">{{ $counts['fire'] }}</span>
        @endif
    </button>

    <!-- Skull: Dead/Funny -->
    <button wire:click="react('skull')" title="It's hilarious"
        class="relative px-3 py-1.5 rounded-full transition-all flex items-center gap-1.5 {{ $userReaction === 'skull' ? 'bg-slate-500/10 text-slate-600 border border-slate-500/20' : 'hover:bg-white hover:shadow-sm text-slate-500' }}">
        <span class="text-lg leading-none filter {{ $userReaction === 'skull' ? '' : 'grayscale opacity-70 hover:grayscale-0 hover:opacity-100' }} transition-all">💀</span>
        @if($counts['skull'] > 0)
            <span class="text-[10px] font-bold">{{ $counts['skull'] }}</span>
        @endif
    </button>

    <!-- Melt: Cringe/Soft -->
    <button wire:click="react('melt')" title="I can't even"
        class="relative px-3 py-1.5 rounded-full transition-all flex items-center gap-1.5 {{ $userReaction === 'melt' ? 'bg-yellow-500/10 text-yellow-600 border border-yellow-500/20' : 'hover:bg-white hover:shadow-sm text-slate-500' }}">
        <span class="text-lg leading-none filter {{ $userReaction === 'melt' ? '' : 'grayscale opacity-70 hover:grayscale-0 hover:opacity-100' }} transition-all">🫠</span>
        @if($counts['melt'] > 0)
            <span class="text-[10px] font-bold">{{ $counts['melt'] }}</span>
        @endif
    </button>

    <!-- Clown: Cap/Fake -->
    <button wire:click="react('clown')" title="This is fake / cap"
        class="relative px-3 py-1.5 rounded-full transition-all flex items-center gap-1.5 {{ $userReaction === 'clown' ? 'bg-red-500/10 text-red-600 border border-red-500/20' : 'hover:bg-white hover:shadow-sm text-slate-500' }}">
        <span class="text-lg leading-none filter {{ $userReaction === 'clown' ? '' : 'grayscale opacity-70 hover:grayscale-0 hover:opacity-100' }} transition-all">🤡</span>
        @if($counts['clown'] > 0)
            <span class="text-[10px] font-bold">{{ $counts['clown'] }}</span>
        @endif
    </button>

</div>
