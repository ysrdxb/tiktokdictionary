<?php

namespace App\Livewire\Tools;

use Livewire\Component;
use App\Models\Word;
use App\Services\OpenAIService;

class AiSummary extends Component
{
    public Word $word;
    public $summary;
    public $isGenerating = false;
    public $aiEnabled = false;

    public function mount(Word $word)
    {
        $this->word = $word;
        $this->summary = $word->ai_summary;

        $service = new OpenAIService();
        $this->aiEnabled = $service->isAvailable();
    }

    public function generate()
    {
        $service = new OpenAIService();

        if (!$service->isAvailable()) {
            return;
        }

        $this->isGenerating = true;

        $this->summary = $service->generateSummary($this->word);
        $vibes = $service->generateVibes($this->word);

        // Save to DB
        $this->word->update([
            'ai_summary' => $this->summary,
            'vibes' => $vibes
        ]);

        $this->isGenerating = false;
    }

    public function render()
    {
        return view('livewire.tools.ai-summary');
    }
}
