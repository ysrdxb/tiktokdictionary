<?php

namespace App\Livewire\Tools;

use Livewire\Component;
use App\Models\Word;

class ShareModal extends Component
{
    public $isOpen = false;
    public $wordId;
    public $term;
    public $definition;

    protected $listeners = ['openShareModal'];

    public function openShareModal($wordId)
    {
        $word = Word::with('definitions')->find($wordId);
        if ($word) {
            $this->wordId = $word->id;
            $this->term = $word->term;
            $this->definition = $word->definitions->first()->definition ?? 'No definition found.';
            $this->isOpen = true;
        }
    }

    public function render()
    {
        return view('livewire.tools.share-modal');
    }
}
