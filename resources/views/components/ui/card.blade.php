@props([
    'size' => 'md', // sm, md, lg, xl (bento hero)
    'variant' => 'glass', // glass, solid, neon
])

@php
    $base = "relative overflow-hidden rounded-3xl transition-all duration-500 group";
    
    $variants = [
        'glass' => 'bg-brand-dark/40 backdrop-blur-xl border border-white/10 hover:border-brand-primary/50 hover:bg-brand-dark/60 hover:shadow-strong',
        'solid' => 'bg-brand-panel border border-brand-border hover:border-brand-primary',
        'neon' => 'bg-black border border-cyan-500 shadow-[0_0_15px_rgba(6,182,212,0.5)] animate-shimmer relative'
    ];
    
    $sizes = [
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
        'xl' => 'p-10 md:col-span-2 md:row-span-2' // Bento High Velocity item
    ];
    
    $classes = $base . ' ' . ($variants[$variant] ?? $variants['glass']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <!-- Gradient Glow Effect -->
    <div class="absolute -top-20 -right-20 w-40 h-40 bg-brand-primary/20 blur-[80px] rounded-full pointer-events-none group-hover:bg-brand-primary/40 transition-colors duration-500"></div>
    
    <div class="relative z-10 w-full h-full">
        {{ $slot }}
    </div>
</div>
