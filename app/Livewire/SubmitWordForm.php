<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Word;
use App\Models\Definition;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

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

    // Settings-based flags
    public $submissionsEnabled = true;
    public $requireLogin = false;
    public $disabledReason = '';

    // Duplicate check
    public $showExactDuplicateModal = false;
    public $showSimilarModal = false; // "Looks like this word already exists" modal (Image 3)

    public function mount()
    {
        // Load settings (tolerate boolean/string values)
        $this->submissionsEnabled = filter_var(Setting::get('allow_submissions', true), FILTER_VALIDATE_BOOLEAN);
        $this->requireLogin = filter_var(Setting::get('require_login_to_submit', false), FILTER_VALIDATE_BOOLEAN);

        // Set disabled reason if applicable
        if (!$this->submissionsEnabled) {
            $this->disabledReason = 'Word submissions are currently disabled.';
        } elseif ($this->requireLogin && !Auth::check()) {
            $this->disabledReason = 'Please log in to submit new words.';
        }

        if (Auth::check()) {
            $this->submittedBy = Auth::user()->username;
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
        // Check if submissions are enabled
        if (!$this->submissionsEnabled) {
            $this->addError('term', 'Word submissions are currently disabled.');
            return;
        }

        // Rate limiting (Admin-controlled)
        $enabled = filter_var(Setting::get('rate_limit_enabled', false), FILTER_VALIDATE_BOOLEAN);
        $max = (int) Setting::get('rate_limit_requests', 60);
        $period = (int) Setting::get('rate_limit_period', 1); // minutes
        $key = 'submit_word:' . request()->ip();
        if ($enabled && RateLimiter::tooManyAttempts($key, $max)) {
            $wait = RateLimiter::availableIn($key);
            $this->addError('term', 'Too many attempts. Please try again later.');
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "Too many attempts. Try again in {$wait}s."
            ]);
            return;
        }

        // Check if login is required
        if ($this->requireLogin && !Auth::check()) {
            $this->addError('term', 'Please log in to submit new words.');
            return;
        }

        $this->validate();

        // Bottleneck A: Content Quality & Spam (Basic implementation)
        if ($this->hasProfanity($this->term) || $this->hasProfanity($this->definition) || $this->hasProfanity($this->example)) {
            $this->addError('term', 'Your submission contains flagged content. Please keep it clean.');
            return;
        }

        // Create or find the word
        $word = Word::firstOrCreate(
            ['term' => $this->term],
            [
                'slug' => Str::slug($this->term),
                'category' => $this->category,
            ]
        );

        // Determine username
        $username = $this->submittedBy ?: 'Anonymous';
        if (Auth::check() && empty($this->submittedBy)) {
            $username = '@' . Auth::user()->username;
        }

        // Check if auto-approve is enabled
        $autoApprove = filter_var(Setting::get('auto_approve_definitions', false), FILTER_VALIDATE_BOOLEAN);

        // Create the definition
        Definition::create([
            'word_id' => $word->id,
            'definition' => $this->definition,
            'example' => $this->example,
            'submitted_by' => $username,
            'source_url' => $this->sourceUrl ?: null,
            'agrees' => 0,
            'disagrees' => 0,
            'is_approved' => $autoApprove,
        ]);

        $word->recalculateStats();

        // Reset form
        $this->reset(['term', 'definition', 'example', 'submittedBy', 'sourceUrl', 'alternateSpellings', 'hashtags']);

        // Show Success Modal
        $this->showSuccessModal = true;

        if ($enabled) {
            RateLimiter::hit($key, $period * 60);
        }
    }

    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
    }

    public function render()
    {
        return view('livewire.submit-word-form');
    }

    protected function hasProfanity($text)
    {
        $banned = ['badword', 'hate', 'spam', 'scam', 'violence']; // MVP Blocklist - extensible
        $normalized = strtolower($text);
        foreach ($banned as $word) {
            if (str_contains($normalized, $word)) {
                return true;
            }
        }
        return false;
    }
}
