<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Flag;
use Illuminate\Support\Facades\Auth;

class ReportModal extends Component
{
    public $showModal = false;
    public $flaggableType;
    public $flaggableId;
    public $reason = '';
    public $details = '';
    
    // Listen for the open-report-modal event
    protected $listeners = ['openReportModal' => 'open'];

    public function mount()
    {
        // Initial state
    }

    public function open($type, $id)
    {
        $this->flaggableType = $type;
        $this->flaggableId = $id;
        $this->reason = '';
        $this->details = '';
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
        $this->reset(['reason', 'details']);
    }

    public function submit()
    {
        $this->validate([
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Flag::create([
            'reporter_id' => Auth::id(),
            'reporter_ip' => request()->ip(),
            'flaggable_type' => $this->flaggableType,
            'flaggable_id' => $this->flaggableId,
            'reason' => $this->reason,
            'details' => $this->details,
            'status' => 'pending',
        ]);

        $this->close();
        
        // Dispatch success notification
        $this->dispatch('notify', message: 'Report submitted successfully. Thank you for helping keep our community safe!');
    }

    public function render()
    {
        return view('livewire.report-modal');
    }
}
