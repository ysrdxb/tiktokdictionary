<?php

namespace App\Livewire\Admin\Definitions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Definition;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all'; // all, high-disagree, pending

    // Mock "Pending" status (since we don't have is_approved col yet, we'll use logic)
    // For now we just list all.

    public function deleteDefinition($id)
    {
        Definition::destroy($id);
        $this->dispatch('notify', 'Definition deleted.');
    }

    public function render()
    {
        $query = Definition::with('word');

        if ($this->search) {
             $query->where('definition', 'like', '%' . $this->search . '%')
                   ->orWhereHas('word', function($q) {
                       $q->where('term', 'like', '%' . $this->search . '%');
                   });
        }

        if ($this->filterStatus === 'controversial') {
             $query->whereRaw('disagrees > agrees');
        }

        $definitions = $query->latest()->paginate(20);

        return view('livewire.admin.definitions.index', [
            'definitions' => $definitions
        ])->layout('components.layouts.admin');
    }
}
