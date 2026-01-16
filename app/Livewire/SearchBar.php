<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Word;
use App\Models\Setting;
use Illuminate\Support\Facades\RateLimiter;

class SearchBar extends Component
{
    public $query = '';
    public $results;
    public $showResults = false;

    public function mount()
    {
        $this->results = collect();
        $this->showResults = false;
    }

    public function updatedQuery()
    {
        if (strlen($this->query) >= 2) {
            // Rate limiting (Admin-controlled)
            $enabled = filter_var(Setting::get('rate_limit_enabled', false), FILTER_VALIDATE_BOOLEAN);
            $max = (int) Setting::get('rate_limit_requests', 60);
            $period = (int) Setting::get('rate_limit_period', 1); // minutes
            $key = 'search:' . request()->ip();

            if ($enabled && RateLimiter::tooManyAttempts($key, $max)) {
                // Do not perform search when throttled
                $this->results = collect();
                $this->showResults = false;
                return;
            }

            try {
                $this->results = Word::where('is_verified', true)
                    ->where(function($q) {
                        $q->where('term', 'like', '%' . $this->query . '%')
                          ->orWhere('category', 'like', '%' . $this->query . '%')
                          ->orWhereJsonContains('vibes', $this->query);
                    })
                    ->with('primaryDefinition')
                    ->take(7)
                    ->get();
                $this->showResults = true; // Always show results to enable "Search-to-Submit" feature
            } catch (\Exception $e) {
                logger()->error('SearchBar query error: ' . $e->getMessage());
                $this->results = collect();
                $this->showResults = false;
            } finally {
                if ($enabled) {
                    RateLimiter::hit($key, $period * 60);
                }
            }
        } else {
            $this->results = collect();
            $this->showResults = false;
        }
    }

    public function selectWord($slug)
    {
        return redirect()->route('word.show', ['slug' => $slug]);
    }

    public function clear()
    {
        $this->query = '';
        $this->results = collect();
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
