<?php

namespace App\Services;

use App\Models\Word;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;
    protected $model;
    protected $enabled;

    public function __construct()
    {
        $this->apiKey = Setting::get('openai_api_key', '');
        $this->model = Setting::get('openai_model', 'gpt-4o-mini');
        $this->enabled = Setting::get('ai_enabled', 'true') === 'true';
    }

    /**
     * Check if real AI is available.
     */
    public function isAvailable(): bool
    {
        return $this->enabled && !empty($this->apiKey);
    }

    /**
     * Generate a concise, witty summary for a word based on its definitions.
     *
     * @param Word $word
     * @return string|null
     */
    public function generateSummary(Word $word): ?string
    {
        $definitions = $word->definitions()->orderByDesc('agrees')->take(5)->get()->pluck('definition');

        if ($definitions->isEmpty()) {
            return null;
        }

        // Use real AI if available
        if ($this->isAvailable()) {
            return $this->generateRealSummary($word->term, $definitions);
        }

        // Fallback to mock response
        return $this->generateMockSummary($word->term, $definitions->first());
    }

    /**
     * Generate summary using OpenAI API.
     */
    protected function generateRealSummary(string $term, $definitions): ?string
    {
        $defList = $definitions->map(fn($d, $i) => ($i + 1) . ". " . $d)->join("\n");

        $prompt = "You are a Gen-Z internet culture expert. Synthesize these user-submitted definitions for the slang term '{$term}' into ONE witty, concise sentence (max 50 words) that captures its essence for someone who's never heard it. Be clever but not cringe.\n\nDefinitions:\n{$defList}";

        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(30)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a Gen-Z internet historian. Concise, witty, informative. No quotation marks around your response.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 150,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                return trim($response->json('choices.0.message.content'), '"');
            }

            Log::warning('OpenAI API error', [
                'status' => $response->status(),
                'error' => $response->json('error'),
            ]);

            return $this->generateMockSummary($term, $definitions->first());

        } catch (\Exception $e) {
            Log::error('OpenAI API exception', ['message' => $e->getMessage()]);
            return $this->generateMockSummary($term, $definitions->first());
        }
    }

    /**
     * Generate mock summary for demo/fallback.
     */
    protected function generateMockSummary(string $term, string $topDef): string
    {
        $templates = [
            "The term '{$term}' is taking over timelines right now. Basically, it means \"{$topDef}\" — but uses vary by subculture.",
            "Everyone is saying '{$term}'. It's mostly used to express \"{$topDef}\". Don't overuse it or you'll look like a boomer.",
            "'{$term}' serves as a vibe-check for \"{$topDef}\". If you see it in comments, it's usually sarcastic.",
            "Viral Alert: '{$term}' is peaking. It's the modern way of saying \"{$topDef}\". Use with caution.",
            "'{$term}' has entered the chat. Originally meaning \"{$topDef}\", it's now used ironically in most contexts.",
        ];

        return $templates[array_rand($templates)];
    }

    /**
     * Generate vibe tags for a word.
     *
     * @param Word $word
     * @return array
     */
    public function generateVibes(Word $word): array
    {
        // Use real AI if available
        if ($this->isAvailable()) {
            return $this->generateRealVibes($word);
        }

        // Fallback to mock vibes
        return $this->generateMockVibes();
    }

    /**
     * Generate vibes using OpenAI API.
     */
    protected function generateRealVibes(Word $word): array
    {
        $definitions = $word->definitions()->orderByDesc('agrees')->take(3)->get()->pluck('definition')->join('; ');

        $prompt = "Based on this slang term '{$word->term}' with definitions: \"{$definitions}\", generate 3-5 vibe/mood tags that describe its energy. Return ONLY a comma-separated list of single-word tags like: Sarcastic, Wholesome, Chaotic, Based, Cringe, Nostalgic, Unhinged, Corporate, Romantic, Toxic, Iconic, Mid, Peak, Goated";

        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(20)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 50,
                    'temperature' => 0.8,
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                $vibes = array_map('trim', explode(',', $content));
                // Clean up and limit to 5
                $vibes = array_filter($vibes, fn($v) => strlen($v) > 0 && strlen($v) < 20);
                return array_slice(array_values($vibes), 0, 5);
            }

            return $this->generateMockVibes();

        } catch (\Exception $e) {
            Log::error('OpenAI Vibes API exception', ['message' => $e->getMessage()]);
            return $this->generateMockVibes();
        }
    }

    /**
     * Generate mock vibes for demo/fallback.
     */
    protected function generateMockVibes(): array
    {
        $pool = ['Sarcastic', 'Wholesome', 'Cringe', 'Based', 'Chaotic', 'Rizz', 'Nostalgic', 'Down Bad', 'Casual', 'Corporate', 'Unserious', 'Iconic', 'Mid', 'Peak', 'Goated', 'Unhinged'];

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
