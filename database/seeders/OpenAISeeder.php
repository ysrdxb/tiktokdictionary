<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class OpenAISeeder extends Seeder
{
    public function run()
    {
        if (!Setting::where('key', 'openai_api_key')->exists()) {
            Setting::create([
                'key' => 'openai_api_key',
                'value' => '', // Empty by default
                'group' => 'integration', // New group for external APIs
                'type' => 'string'
            ]);
        }
    }
}
