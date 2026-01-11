@props([
    'variant' => 'neutral', // neutral, viral, verified, polar
    'icon' => null
])

@php
    $base = "inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider select-none";
    
    $variants = [
        'neutral' => 'bg-white/5 text-gray-400 border border-white/10',
        'viral' => 'bg-brand-primary/20 text-brand-primary border border-brand-primary/30',
        'verified' => 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30',
        'polar' => 'bg-white text-black animate-pulse shadow-[0_0_15px_rgba(255,255,255,0.5)]', // "Possible Polar Trend" style
        'vibes' => 'bg-purple-500/20 text-purple-300 border border-purple-500/30'
    ];
    
    $classes = $base . ' ' . ($variants[$variant] ?? $variants['neutral']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($variant === 'polar')
        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-ping"></span>
    @elseif($icon)
        <span>{{ $icon }}</span>
    @endif
    
    {{ $slot }}
</span>
