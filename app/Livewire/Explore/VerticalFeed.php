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

        // Pull a mix: 3 Latest, 2 High Velocity
        $latest = Word::with(['primaryDefinition', 'definitions'])
            ->whereNotIn('id', $this->loadedIds)
            ->latest()
            ->take(3)
            ->get();

        $trending = Word::with(['primaryDefinition', 'definitions'])
            ->whereNotIn('id', $this->loadedIds)
            ->whereNotIn('id', $latest->pluck('id'))
            ->orderByDesc('velocity_score')
            ->take(2)
            ->get();

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
