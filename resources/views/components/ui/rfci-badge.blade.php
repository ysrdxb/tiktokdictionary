@props(['score'])

@if($score)
    @php
        $letter = substr($score, -1);
        $number = substr($score, 0, -1);
        $colors = [
            'A' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'B' => 'bg-blue-100 text-blue-700 border-blue-200',
            'C' => 'bg-amber-100 text-amber-700 border-amber-200',
            'D' => 'bg-red-100 text-red-700 border-red-200',
        ];
        $colorClass = $colors[$letter] ?? 'bg-slate-100 text-slate-700 border-slate-200';
    @endphp

    <div {{ $attributes->merge(['class' => "inline-flex items-center gap-1 px-2 py-1 rounded-lg border $colorClass text-xs font-bold"]) }} title="RFCI Score">
        <span class="font-mono">{{ $number }}</span>
        <span class="opacity-75">{{ $letter }}</span>
    </div>
@endif
