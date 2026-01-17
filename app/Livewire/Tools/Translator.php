<?php

namespace App\Livewire\Tools;

use Livewire\Component;
use App\Services\OpenAIService;
use App\Models\Setting;

class Translator extends Component
{
    public $inputText = '';
    public $outputText = '';
    public $isLoading = false;

    public function translate(OpenAIService $ai)
    {
        $this->validate([
            'inputText' => 'required|string|min:3|max:500'
        ]);

        $this->isLoading = true;

        // Artificial delay for "processing" feel + rate limit mitigation
        // sleep(1);

        $this->outputText = $ai->translateToGenZ($this->inputText);

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.tools.translator')
            ->layout('components.layouts.app', [
                'title' => 'Boomer to Gen Z Translator - TikTok Dictionary'
            ]);
    }
}
