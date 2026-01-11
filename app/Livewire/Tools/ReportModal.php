<?php

namespace App\Livewire\Tools;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ReportModal extends Component
{
    public $isOpen = false;
    public $type; // word, definition
    public $modelId;
    public $reason = 'spam';
    public $details;

    protected $listeners = ['openReportModal'];

    public function openReportModal($type, $id)
    {
        $this->type = $type;
        $this->modelId = $id;
        $this->isOpen = true;
    }

    public function submit()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'reason' => 'required',
            'details' => 'nullable|string|max:500'
        ]);

        DB::table('flags')->insert([
            'reporter_id' => auth()->id(),
            'flaggable_type' => $this->type,
            'flaggable_id' => $this->modelId,
            'reason' => $this->reason,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->isOpen = false;
        $this->dispatch('notify', 'Thanks for keeping the community safe! Report submitted.');
        $this->reset(['details', 'reason']);
    }

    public function render()
    {
        return view('livewire.tools.report-modal');
    }
}
