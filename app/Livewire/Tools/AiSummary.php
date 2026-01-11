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

    public function mount(Word $word)
    {
        $this->word = $word;
        $this->summary = $word->ai_summary;
    }

    public function generate()
    {
        $this->isGenerating = true;
        
        $service = new OpenAIService();
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
