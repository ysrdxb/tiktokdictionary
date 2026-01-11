@props([
    'href',
    'navigate' => true,
])

@if($navigate)
    <a href="{{ $href }}" wire:navigate {{ $attributes }}>
        {{ $slot }}
    </a>
@else
    <a href="{{ $href }}" {{ $attributes }}>
        {{ $slot }}
    </a>
@endif
