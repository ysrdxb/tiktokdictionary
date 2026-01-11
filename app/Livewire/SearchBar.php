<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Word;

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
            try {
                $this->results = Word::where('term', 'LIKE', '%' . $this->query . '%')
                    ->with('primaryDefinition')
                    ->limit(5)
                    ->get();
                $this->showResults = $this->results->isNotEmpty();
            } catch (\Exception $e) {
                logger()->error('SearchBar query error: ' . $e->getMessage());
                $this->results = collect();
                $this->showResults = false;
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
