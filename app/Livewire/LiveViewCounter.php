<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Word;

class LiveViewCounter extends Component
{
    public $wordId;
    public $views;
    public $isPolarTrend = false;
    public $increment = false;
    public $type = 'detail'; // 'detail' or 'card'

    public function mount($wordId, $increment = false, $type = 'detail')
    {
        $this->wordId = $wordId;
        $this->increment = $increment;
        $this->type = $type;
        
        if ($this->increment) {
            Word::where('id', $wordId)->increment('views');
        }
        
        $this->refreshViews();
    }

    public function refreshViews()
    {
        $word = Word::find($this->wordId);
        if ($word) {
            $this->views = $word->views;
            $this->isPolarTrend = $word->is_polar_trend;
        }
    }

    public function render()
    {
        return view('livewire.live-view-counter');
    }
}
