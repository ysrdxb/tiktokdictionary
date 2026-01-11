<div wire:poll.5s.visible="refreshViews" class="flex items-center gap-2">
    @if($type === 'card')
        <div class="flex items-center gap-1 text-[10px] text-gray-400 font-mono">
            <span class="relative flex h-2 w-2">
                @if($isPolarTrend)
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                @endif
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
            <span>{{ number_format($views) }}</span>
        </div>
    @else
        <!-- Pulsing green dot -->
        <span class="relative flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
        </span>

        <span class="text-sm font-bold text-slate-600 dark:text-white/70 font-mono">
            {{ number_format($views) }} views
        </span>

        @if($isPolarTrend)
            <span class="ml-2 px-2 py-0.5 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-500/30 text-[10px] font-bold uppercase tracking-wider rounded-full animate-pulse shadow-[0_0_10px_rgba(34,211,238,0.2)]">
                Polar Trend
            </span>
        @endif
    @endif
</div>
