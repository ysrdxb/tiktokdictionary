<?php

namespace App\Livewire\Tools;

use Livewire\Component;

class DomainChecker extends Component
{
    public $term;
    public $tlds = ['com', 'io', 'co', 'xyz'];
    public $hasChecked = false;
    public $isLoading = false;

    public function mount($term)
    {
        // Sanitize term: remove spaces, special chars, lowercase
        $this->term = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $term));
    }

    public function check()
    {
        $this->isLoading = true;
        
        // Simulate API delay for dramatic effect
        // In real world, we might verify availability via API
        // For MVP/Affiliate model, we just push them to GoDaddy search
        
        // using sleep in sync request freezes the browser in some contexts or feels laggy
        // Livewire handling: method finishes then updates.
        // We'll use wire:loading to show spinner.
        
        $this->hasChecked = true;
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.tools.domain-checker');
    }
}
