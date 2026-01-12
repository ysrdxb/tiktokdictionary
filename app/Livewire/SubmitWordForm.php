<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Word;
use App\Models\Definition;
use Illuminate\Support\Str;

class SubmitWordForm extends Component
{
    public $term = '';
    public $definition = '';
    public $example = '';
    public $submittedBy = '';
    public $sourcePlatform = '';
    public $sourceUrl = '';
    public $category = 'Slang';
    public $alternateSpellings = '';
    public $hashtags = '';
    
    // Duplicate check
    public $showExactDuplicateModal = false;
    public $showSimilarModal = false; // "Looks like this word already exists" modal (Image 3)
    
    public function mount()
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            $this->submittedBy = \Illuminate\Support\Facades\Auth::user()->username;
        }
    }
    
    // Shared duplicate data
    public $duplicateWordSlug = null;
    public $duplicateWordTerm = null;
    public $duplicateCount = 0; // For similar modal count
    
    // Exact duplicate data (Image 4)
    public $duplicateDefinition = '';
    public $duplicateExample = '';
    public $duplicateAgrees = 0;
    public $duplicateDisagrees = 0;

    public $showSuccess = false;
    public $showForm = true; 

    protected $rules = [
        'term' => 'required|string|max:100',
        'definition' => 'required|string|max:1000',
        'example' => 'required|string|max:500',
        'category' => 'required|string|max:50',
        'sourceUrl' => 'nullable|url|max:255',
        'alternateSpellings' => 'nullable|string|max:255',
        'hashtags' => 'nullable|string|max:255',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'term') {
            $this->checkForDuplicates();
        }
    }

    public function checkForDuplicates()
    {
        if (strlen($this->term) < 2) return;

        // 1. Exact Match Check
        $existingWord = Word::whereRaw('LOWER(term) = LOWER(?)', [trim($this->term)])->first();

        if ($existingWord) {
            $this->duplicateWordSlug = $existingWord->slug;
            $this->duplicateWordTerm = $existingWord->term;
            
            // Get best definition for preview
            $def = $existingWord->definitions()->orderBy('agrees', 'desc')->first();
            $this->duplicateDefinition = $def ? $def->definition : 'No definition found.';
            $this->duplicateExample = $def ? $def->example : '';
            $this->duplicateAgrees = $def ? $def->agrees : 0;
            $this->duplicateDisagrees = $def ? $def->disagrees : 0;

            $this->showExactDuplicateModal = true;
            $this->showSimilarModal = false;
            return;
        } 
        
        // 2. Similar Match Check
        $similarWords = Word::findSimilar($this->term); // Returns collection
        
        // Filter out if any strictly matches (though step 1 covered it, findSimilar might be fuzzy)
        // We just want to know if there are "similar" words to warn about
        if ($similarWords->count() > 0) {
             // Take the best match for the "view existing" link
             $bestMatch = $similarWords->first();
             $this->duplicateWordSlug = $bestMatch->slug;
             $this->duplicateWordTerm = $bestMatch->term;
             $this->duplicateCount = $bestMatch->total_definitions ?? 1; // Used in "X People already submitted..." logic
             
             $this->showSimilarModal = true;
             $this->showExactDuplicateModal = false;
        } else {
            $this->showSimilarModal = false;
            $this->showExactDuplicateModal = false;
        }
    }
    
    public function closeDuplicateModal()
    {
        $this->showExactDuplicateModal = false;
        $this->showSimilarModal = false;
    }

    public $showSuccessModal = false;

    public function submit()
    {
        $this->validate();

        // Create or find the word
        $word = Word::firstOrCreate(
            ['term' => $this->term],
            [
                'slug' => Str::slug($this->term),
                'category' => $this->category,
            ]
        );

        // Create the definition
        Definition::create([
            'word_id' => $word->id,
            'definition' => $this->definition,
            'example' => $this->example,
            'submitted_by' => $this->submittedBy ?: 'Anonymous',
            'source_url' => $this->sourceUrl ?: null,
            'agrees' => 0,
            'disagrees' => 0,
        ]);
        
        $word->recalculateStats();

        // Reset form
        $this->reset(['term', 'definition', 'example', 'submittedBy', 'sourceUrl', 'alternateSpellings', 'hashtags']);
        
        // Show Success Modal
        $this->showSuccessModal = true;
    }

    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
    }

    public function render()
    {
        return view('livewire.submit-word-form');
    }
}
