<div wire:poll.5s>
    {{-- We wrap the existing UI component in a div that polls every 5 seconds --}}
    <x-ui.bento-grid :items="$items" />
</div>
