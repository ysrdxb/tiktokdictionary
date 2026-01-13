<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Definition;
use App\Models\Word;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

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

    // Settings-based flags
    public $submissionsEnabled = true;
    public $requireLogin = false;
    public $maxPerDay = 10;
    public $disabledReason = '';

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

        // Load settings
        $this->submissionsEnabled = Setting::get('allow_submissions', 'true') === 'true';
        $this->requireLogin = Setting::get('require_login_to_submit', 'false') === 'true';
        $this->maxPerDay = (int) Setting::get('max_definitions_per_day', '10');

        // Set disabled reason if applicable
        if (!$this->submissionsEnabled) {
            $this->disabledReason = 'Submissions are currently disabled.';
        } elseif ($this->requireLogin && !Auth::check()) {
            $this->disabledReason = 'Please log in to submit definitions.';
        }

        // Auto-fill username if logged in
        if (Auth::check()) {
            $this->submittedBy = '@' . Auth::user()->username;
        }
    }

    public $showDuplicateModal = false;
    public $duplicateWordSlug = null;
    public $duplicateWordTerm = null;
    public $existingCount = 0;

    public function submit($force = false)
    {
        // Check if submissions are enabled
        if (!$this->submissionsEnabled) {
            $this->addError('definition', 'Submissions are currently disabled.');
            return;
        }

        // Check if login is required
        if ($this->requireLogin && !Auth::check()) {
            $this->addError('definition', 'Please log in to submit definitions.');
            return;
        }

        // Check daily limit
        if (!$this->checkDailyLimit()) {
            $this->addError('definition', "You've reached your daily limit of {$this->maxPerDay} definitions.");
            return;
        }

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
                $this->duplicateWordSlug = null;
                $this->existingCount = $existingDef;
                $this->showDuplicateModal = true;
                return;
            }
        }

        // Determine username
        $username = $this->submittedBy ?: 'Anonymous';
        if (Auth::check() && empty($this->submittedBy)) {
            $username = '@' . Auth::user()->username;
        }

        // Check if auto-approve is enabled
        $autoApprove = Setting::get('auto_approve_definitions', 'false') === 'true';

        Definition::create([
            'word_id' => $this->wordId,
            'definition' => $this->definition,
            'example' => $this->example,
            'submitted_by' => $username,
            'source_platform' => $this->sourcePlatform ?: null,
            'source_url' => $this->sourceUrl ?: null,
            'agrees' => 0,
            'disagrees' => 0,
            'is_primary' => false,
            'is_approved' => $autoApprove,
        ]);

        // Reset form
        $this->definition = '';
        $this->example = '';
        $this->sourcePlatform = '';
        $this->sourceUrl = '';
        $this->showSuccess = true;
        $this->showDuplicateModal = false;

        // Refresh the page data
        $this->dispatch('definitionAdded');

        // Reload page after short delay to show new definition
        $this->dispatch('refresh-page');
    }

    protected function checkDailyLimit(): bool
    {
        // Anonymous users tracked by IP
        if (!Auth::check()) {
            $count = Definition::where('created_at', '>=', now()->startOfDay())
                ->whereRaw("submitted_by = 'Anonymous' OR submitted_by IS NULL")
                ->count();
            // Be more lenient with anonymous - harder to track
            return $count < ($this->maxPerDay * 2);
        }

        // Logged in users tracked by username
        $username = '@' . Auth::user()->username;
        $count = Definition::where('submitted_by', $username)
            ->where('created_at', '>=', now()->startOfDay())
            ->count();

        return $count < $this->maxPerDay;
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
