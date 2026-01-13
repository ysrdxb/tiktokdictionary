<?php

namespace App\Livewire\Admin\Moderation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Flag;

use App\Models\Word;
use App\Models\Definition;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $activeTab = 'words';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function approveWord($id)
    {
        $word = Word::find($id);
        if ($word) {
            $word->update(['is_verified' => true]);
            $this->dispatch('notify', 'Word verified successfully.');
        }
    }
    
    public function rejectWord($id)
    {
        $word = Word::find($id);
        if ($word) {
            $word->definitions()->delete(); // Cascade delete definitions
            $word->delete();
            $this->dispatch('notify', 'Word rejected and deleted.');
        }
    }

    public function approveDefinition($id)
    {
        $def = Definition::find($id);
        if ($def) {
            $def->update(['is_approved' => true]);
            $this->dispatch('notify', 'Definition approved.');
        }
    }

    public function rejectDefinition($id)
    {
        $def = Definition::find($id);
        if ($def) {
            $def->delete();
            $this->dispatch('notify', 'Definition rejected and deleted.');
        }
    }

    public function render()
    {
        $words = Word::where('is_verified', false)
            ->withCount('definitions')
            ->latest()
            ->paginate(10);
            
        $definitions = Definition::where('is_approved', false)
            ->with('word')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.moderation.index', [
            'words' => $words,
            'definitions' => $definitions
        ])->layout('components.layouts.admin');
    }
}
