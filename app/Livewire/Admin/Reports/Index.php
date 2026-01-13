<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Flag;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.reports.index', [
            'flags' => Flag::where('status', '!=', 'resolved')->latest()->paginate(10)
        ])->layout('components.layouts.admin');
    }
}
