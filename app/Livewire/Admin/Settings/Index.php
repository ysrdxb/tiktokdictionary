<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class Index extends Component
{
    public $settings = [];
    public $group = 'general';

    // Default settings per group
    protected $defaults = [
        'general' => [
            'site_name' => 'TikTokDictionary',
            'tagline' => 'The Viral Vernacular',
            'maintenance_mode' => 'false',
            'allow_voting' => 'true',
            'allow_submissions' => 'true',
        ],
        'api' => [
            'openai_api_key' => '',
            'openai_model' => 'gpt-4o-mini',
            'ai_enabled' => 'true',
            'godaddy_affiliate_id' => '',
            'domain_checker_enabled' => 'true',
            'domain_tlds' => 'com,io,co,xyz',
        ],
        'moderation' => [
            'auto_approve_definitions' => 'false',
            'require_login_to_submit' => 'false',
            'spam_filter_enabled' => 'true',
            'max_definitions_per_day' => '10',
        ],
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function updatedGroup()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $rows = DB::table('settings')->where('group', $this->group)->get();

        if ($rows->isEmpty() && isset($this->defaults[$this->group])) {
            // Seed defaults if empty
            foreach ($this->defaults[$this->group] as $key => $val) {
                DB::table('settings')->insert([
                    'key' => $key,
                    'value' => json_encode($val),
                    'group' => $this->group,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            $this->settings = $this->defaults[$this->group];
        } else {
            // Decode JSON values when loading
            $this->settings = $rows->mapWithKeys(function ($row) {
                $value = $row->value;
                // Try to decode JSON, fallback to raw value
                $decoded = json_decode($value, true);
                return [$row->key => $decoded !== null ? $decoded : $value];
            })->toArray();

            // Merge with defaults for any missing keys
            if (isset($this->defaults[$this->group])) {
                foreach ($this->defaults[$this->group] as $key => $val) {
                    if (!isset($this->settings[$key])) {
                        $this->settings[$key] = $val;
                    }
                }
            }
        }
    }

    public function save()
    {
        foreach ($this->settings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => json_encode($value ?? ''), 'group' => $this->group, 'updated_at' => now()]
            );

            // Clear cache for this setting
            Cache::forget("setting.{$key}");
        }

        $this->dispatch('notify', 'Settings saved successfully.');
    }

    public function testOpenAI()
    {
        $apiKey = $this->settings['openai_api_key'] ?? '';

        if (empty($apiKey)) {
            $this->dispatch('notify', 'Please enter an API key first.');
            return;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withToken($apiKey)
                ->timeout(10)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->settings['openai_model'] ?? 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'user', 'content' => 'Say "API Connected!" in 3 words or less.'],
                    ],
                    'max_tokens' => 10,
                ]);

            if ($response->successful()) {
                $this->dispatch('notify', 'OpenAI API connection successful!');
            } else {
                $error = $response->json('error.message', 'Unknown error');
                $this->dispatch('notify', 'API Error: ' . $error);
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', 'Connection failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.index')->layout('components.layouts.admin');
    }
}
