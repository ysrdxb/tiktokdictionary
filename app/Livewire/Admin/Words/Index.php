<?php

namespace App\Livewire\Admin\Words;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Word;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filterStatus = 'all'; // all, pending, verified, polar

    protected $queryString = ['search', 'sortField', 'sortDirection', 'filterStatus'];

    // Bulk Actions
    public $selected = [];
    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleVerified($id)
    {
        $word = Word::find($id);
        $word->is_verified = !$word->is_verified;
        $word->save();
        $this->dispatch('notify', 'Verification status updated.');
    }

    public function togglePolar($id)
    {
        $word = Word::find($id);
        $word->is_polar_trend = !$word->is_polar_trend;
        $word->save();
        $this->dispatch('notify', 'Polar Trend status updated.');
    }
    
    public function deleteSelected()
    {
        Word::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        $this->dispatch('notify', 'Words deleted successfully.');
    }
    
    public function verifySelected()
    {
         Word::whereIn('id', $this->selected)->update(['is_verified' => true]);
         $this->selected = [];
         $this->selectAll = false;
         $this->dispatch('notify', 'Selected words verified.');
    }

    public function getQuery()
    {
        $query = Word::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('term', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'pending') {
            $query->where('is_verified', false);
        } elseif ($this->filterStatus === 'verified') {
            $query->where('is_verified', true);
        } elseif ($this->filterStatus === 'polar') {
            $query->where('is_polar_trend', true);
        }

        return $query->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        return view('livewire.admin.words.index', [
            'words' => $this->getQuery()->paginate(25)
        ])->layout('components.layouts.admin');
    }
}
