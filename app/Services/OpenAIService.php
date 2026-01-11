<?php

namespace App\Services;

use App\Models\Word;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenAIService
{
    /**
     * Generate a concise, witty summary for a word based on its definitions.
     *
     * @param Word $word
     * @return string|null
     */
    public function generateSummary(Word $word)
    {
        $definitions = $word->definitions()->orderByDesc('agrees')->take(5)->get()->pluck('definition');
        
        if ($definitions->isEmpty()) {
            return null;
        }

        // Mock response if no API key is set (for safety/demo)
        // In a real env, you would check config('services.openai.key')
        // For this demo, we can just return a "simulated" AI response to show the UI working.
        
        $term = $word->term;
        $defCount = $definitions->count();
        $topDef = $definitions->first();

        // Simulate AI intelligence by templates
        $templates = [
            "The term '$term' is taking over timelines right now. Basically, it means \"$topDef\" — but uses vary by subculture.",
            "Everyone is saying '$term'. It's mostly used to express \"$topDef\". Don't overuse it or you'll look like a boomer.",
            "'$term' serves as a vibe-check for \"$topDef\". If you see it in comments, it's usually sarcastic.",
            "Viral Alert: '$term' is peaking. It's the 2026 way of saying \"$topDef\". Use with caution."
        ];

        return $templates[array_rand($templates)];

        /* 
        // REAL IMPLEMENTATION (Uncomment when API Key is ready)
        $prompt = "Synthesize these definitions for the slang term '$term' into a concise, witty, one-sentence summary explaining it in the context of internet culture.\n\nDefinitions:\n" . $definitions->join("\n- ");
        
        $response = Http::withToken(config('services.openai.key'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a Gen-Z internet historian. Concise, witty, no cringe.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response->json('choices.0.message.content');
        */
    }
    /**
     * Generate vibe tags for a word.
     *
     * @param Word $word
     * @return array
     */
    public function generateVibes(Word $word)
    {
        // Mock Vibes
        $pool = ['Sarcastic', 'Wholesome', 'Cringe', 'Based', 'Chaotic', 'Rizz', 'Nostalgic', 'Down Bad', 'Casual', 'Corporate', 'Unserious'];
        
        // Randomly pick 3-5 unique vibes
        $count = rand(3, 5);
        $keys = array_rand($pool, $count);
        $vibes = [];
        
        if (is_array($keys)) {
            foreach ($keys as $key) {
                $vibes[] = $pool[$key];
            }
        } else {
            $vibes[] = $pool[$keys];
        }

        return $vibes;
    }
}
