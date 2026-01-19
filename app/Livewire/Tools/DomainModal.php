<?php

namespace App\Livewire\Tools;

use Livewire\Component;
use Illuminate\Support\Str;

class DomainModal extends Component
{
    public $isOpen = false;
    public $term = '';
    public $domain = '';
    public $suggestions = [];

    protected $listeners = ['openDomainModal'];

    public function openDomainModal($term = null)
    {
        // Handle if passed as array or direct value
        if (is_array($term)) {
            $this->term = $term['term'] ?? '';
        } else {
            $this->term = $term ?? '';
        }

        $this->domain = Str::slug($this->term) . '.com';
        
        // Generate variations
        $slug = Str::slug($this->term);
        $this->suggestions = [
            'get' . $slug . '.com',
            'try' . $slug . '.com',
            'the' . $slug . '.com',
            $slug . 'app.com',
            $slug . 'now.com',
            $slug . 'official.com',
        ];

        $this->isOpen = true;
    }

    public function render()
    {
        return view('livewire.tools.domain-modal');
    }
}
