<?php

namespace App\Livewire\Admin\Logs;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.logs.index')->layout('components.layouts.admin');
    }
}
