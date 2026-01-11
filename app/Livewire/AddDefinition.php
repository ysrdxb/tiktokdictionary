<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Definition;
use App\Models\Word;

class AddDefinition extends Component
{
    public $wordId;
    public $wordSlug;
    public $definition = '';
    public $example = '';
    public $submittedBy = '';
    public $sourcePlatform = '';
    public $sourceUrl = '';
    public $showSuccess = false;

    protected $rules = [
        'definition' => 'required|max:500',
        'example' => 'nullable|max:300',
        'submittedBy' => 'nullable|max:50',
        'sourcePlatform' => 'nullable|max:30',
        'sourceUrl' => 'nullable|url|max:500',
    ];

    public function mount($wordId)
    {
        $this->wordId = $wordId;
        $this->wordSlug = Word::find($wordId)->slug;
    }

    public $showDuplicateModal = false;
    public $duplicateWordSlug = null;
    public $duplicateWordTerm = null;
    public $existingCount = 0;

    public function submit($force = false)
    {
        $this->validate();

        // Check for duplicate if not forcing
        if (!$force) {
            $term = trim($this->definition);
            // Check if this text exists as a Word itself
            $existingWord = Word::where('term', $term)->first();
            
            if ($existingWord) {
                $this->duplicateWordSlug = $existingWord->slug;
                $this->duplicateWordTerm = $existingWord->term;
                $this->existingCount = $existingWord->definitions()->count();
                $this->showDuplicateModal = true;
                return;
            }

            // Also check for duplicate definition within this word
            $existingDef = Definition::where('word_id', $this->wordId)
                ->where('definition', $this->definition)
                ->count();
            
            if ($existingDef > 0) {
                $this->duplicateWordSlug = null; // Stays on current page (or we can handle differently)
                $this->existingCount = $existingDef;
                $this->showDuplicateModal = true;
                return;
            }
        }

        Definition::create([
            'word_id' => $this->wordId,
            'definition' => $this->definition,
            'example' => $this->example,
            'submitted_by' => $this->submittedBy ?: 'Anonymous',
            'source_platform' => $this->sourcePlatform ?: null,
            'source_url' => $this->sourceUrl ?: null,
            'agrees' => 0,
            'disagrees' => 0,
            'is_primary' => false,
        ]);

        // Reset form
        $this->definition = '';
        $this->example = '';
        $this->submittedBy = '';
        $this->sourcePlatform = '';
        $this->sourceUrl = '';
        $this->showSuccess = true;
        $this->showDuplicateModal = false;

        // Refresh the page data
        $this->dispatch('definitionAdded');
        
        // Reload page after short delay to show new definition
        $this->dispatch('refresh-page');
    }
    
    public function confirmDuplicate()
    {
        $this->submit(true);
    }
    
    public function redirectToExisting()
    {
        if ($this->duplicateWordSlug) {
            return redirect()->route('word.show', $this->duplicateWordSlug);
        }
        
        // If it's a duplicate definition on the same page, just reload/stay
        return redirect()->route('word.show', $this->wordSlug);
    }

    public function render()
    {
        return view('livewire.add-definition');
    }
}
