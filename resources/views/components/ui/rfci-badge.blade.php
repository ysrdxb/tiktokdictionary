@props(['score'])

@if($score)
    @php
        $letter = substr($score, -1);
        $number = substr($score, 0, -1);
        $colors = [
            'A' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/30',
            'B' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/30',
            'C' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/30',
            'D' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/30',
        ];
        $colorClass = $colors[$letter] ?? 'bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-white/70 border-slate-200 dark:border-white/20';
    @endphp

    <div {{ $attributes->merge(['class' => "inline-flex items-center gap-1 px-2 py-1 rounded-lg border $colorClass text-xs font-bold"]) }} title="RFCI Score">
        <span class="font-mono">{{ $number }}</span>
        <span class="opacity-75">{{ $letter }}</span>
    </div>
@endif
