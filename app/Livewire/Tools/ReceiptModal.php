<?php

namespace App\Livewire\Tools;

use Livewire\Component;

class ReceiptModal extends Component
{
    public $isOpen = false;
    public $sourceUrl;
    public $term;

    protected $listeners = ['openReceiptModal'];

    public function openReceiptModal($sourceUrl, $term)
    {
        $this->sourceUrl = $sourceUrl;
        $this->term = $term;
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        // Optional: Reset url to stop video playing when closed (though removing from DOM does that)
        $this->sourceUrl = null; 
    }

    public function render()
    {
        return view('livewire.tools.receipt-modal');
    }
}
