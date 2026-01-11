@props([
    'class' => '',
    'rows' => 1
])

<div class="animate-pulse space-y-3 {{ $class }}">
    @for($i = 0; $i < $rows; $i++)
        <div class="h-4 bg-white/10 rounded w-full last:w-3/4"></div>
    @endfor
</div>
