<?php

namespace App\Livewire\Explore;

use Livewire\Component;
use App\Models\Word;

class VerticalFeed extends Component
{
    public $words = [];
    public $loadedIds = [];
    public $hasMore = true;
    public $readyToLoad = false;

    public function loadMore()
    {
        if (!$this->readyToLoad || !$this->hasMore) return;

        // Pull a mix: 4 Latest, 4 Trending (Hot)
        $latest = Word::with(['primaryDefinition', 'definitions'])
            ->where('is_verified', true)
            ->whereNotIn('id', $this->loadedIds)
            ->latest()
            ->take(4)
            ->get();

        $trending = Word::with(['primaryDefinition', 'definitions'])
            ->where('is_verified', true)
            ->whereNotIn('id', $this->loadedIds)
            ->whereNotIn('id', $latest->pluck('id'))
            ->orderByDesc('velocity_score')
            ->take(4)
            ->get();

        foreach ($latest as $w) $w->feed_label = 'NEW';
        foreach ($trending as $w) $w->feed_label = 'HOT';

        $newWords = $latest->concat($trending)->shuffle();
        
        if ($newWords->isEmpty()) {
            $this->hasMore = false;
            return;
        }

        foreach ($newWords as $word) {
            $this->words[] = $word;
            $this->loadedIds[] = $word->id;
        }
    }
    
    public function load()
    {
        $this->readyToLoad = true;
        $this->loadMore(); // Load initial batch
    }

    public function render()
    {
        return view('livewire.explore.vertical-feed', [
            'items' => $this->words // passing as items to avoid confusion with collection
        ])->layout('components.layouts.app', ['headerDark' => true]); 
    }
}
