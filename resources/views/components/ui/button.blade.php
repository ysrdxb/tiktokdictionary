@props([
    'variant' => 'primary', // primary, secondary, ghost, danger
    'size' => 'md', // sm, md, lg
    'icon' => null
])

@php
    $baseClass = "inline-flex items-center justify-center font-bold uppercase tracking-wide transition-all duration-300 ease-out border-2 select-none disabled:opacity-50 disabled:cursor-not-allowed";
    
    $variants = [
        'primary' => 'bg-brand-primary border-brand-primary text-white hover:bg-white hover:text-brand-primary hover:shadow-strong',
        'secondary' => 'bg-brand-dark border-brand-border text-white hover:border-brand-primary hover:text-brand-primary',
        'ghost' => 'bg-transparent border-transparent text-gray-400 hover:text-white',
        'danger' => 'bg-red-500 border-red-500 text-white hover:bg-black',
        'glass' => 'bg-white/10 backdrop-blur-md border-white/20 text-white hover:bg-white/20'
    ];
    
    $sizes = [
        'sm' => 'text-[10px] px-3 py-1.5 rounded-lg',
        'md' => 'text-xs px-5 py-2.5 rounded-xl',
        'lg' => 'text-sm px-8 py-3.5 rounded-2xl'
    ];
    
    $classes = $baseClass . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . $sizes[$size];
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span class="mr-2 transform group-hover:scale-110 transition-transform">{{ $icon }}</span>
    @endif
    
    <span class="relative z-10 font-[Outfit]">
        {{ $slot }}
    </span>
</button>
