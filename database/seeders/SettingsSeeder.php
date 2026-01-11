<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'TikTokDictionary', 'group' => 'general', 'type' => 'string'],
            ['key' => 'site_tagline', 'value' => 'The Internet\'s Language, Decoded', 'group' => 'general', 'type' => 'string'],
            ['key' => 'site_description', 'value' => 'The definitive dictionary for TikTok slang, Gen-Z terminology, and viral internet culture.', 'group' => 'general', 'type' => 'string'],
            
            // Moderation Settings
            ['key' => 'moderation_enabled', 'value' => false, 'group' => 'moderation', 'type' => 'boolean'],
            ['key' => 'auto_approve_trusted', 'value' => true, 'group' => 'moderation', 'type' => 'boolean'],
            ['key' => 'max_flags_before_hide', 'value' => 5, 'group' => 'moderation', 'type' => 'integer'],
            
            // API Settings
            ['key' => 'godaddy_affiliate_id', 'value' => '', 'group' => 'api', 'type' => 'string'],
            ['key' => 'openai_api_key', 'value' => '', 'group' => 'api', 'type' => 'string'],
            ['key' => 'openai_model', 'value' => 'gpt-4o-mini', 'group' => 'api', 'type' => 'string'],
            
            // Appearance Settings
            ['key' => 'primary_color', 'value' => '#002B5B', 'group' => 'appearance', 'type' => 'string'],
            ['key' => 'accent_color', 'value' => '#f59e0b', 'group' => 'appearance', 'type' => 'string'],
            ['key' => 'dark_mode_default', 'value' => true, 'group' => 'appearance', 'type' => 'boolean'],
            
            // Feature Flags
            ['key' => 'feature_ai_summary', 'value' => true, 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_domain_checker', 'value' => true, 'group' => 'features', 'type' => 'boolean'],
            ['key' => 'feature_audio_player', 'value' => true, 'group' => 'features', 'type' => 'boolean'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
