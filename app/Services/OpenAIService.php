<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = Setting::get('openai_api_key');
        
        // Fallback to env if not in DB (cached config)
        if (!$this->apiKey) {
            $this->apiKey = config('services.openai.key');
        }
    }

    /**
     * Translate text to Gen Z Slang
     */
    public function translateToGenZ($text)
    {
        if (!$this->apiKey) {
            return "Error: Admin needs to set OpenAI API Key in Settings.";
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => 'gpt-3.5-turbo', // Cost-effective & fast
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a translator that converts formal, boomer-style English into pure Gen Z/TikTok slang. Use terms like 'no cap', 'fr', 'bet', 'slay', 'delulu', 'rizz', 'gyatt', 'fanum tax', etc. where appropriate. Make it sound exaggerated and funny but intelligible. Return ONLY the translated text, no quotation marks or explanations."
                    ],
                    [
                        'role' => 'user',
                        'content' => $text
                    ]
                ],
                'temperature' => 0.8,
                'max_tokens' => 200,
            ]);

            if ($response->successful()) {
                return trim($response->json('choices.0.message.content'));
            }

            Log::error('OpenAI API Error: ' . $response->body());
            return "bruh... the AI is tweaking rn (API Error) 💀";

        } catch (\Exception $e) {
            Log::error('OpenAI Connection Error: ' . $e->getMessage());
            return "wifi must be cooked... connection error 📉";
        }
    }
}
