<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $settings = [];
    public $group = 'general';

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $rows = DB::table('settings')->where('group', $this->group)->get();
        if ($rows->isEmpty() && $this->group === 'general') {
             // Seed defaults if empty
             $defaults = [
                 'site_name' => 'TikTokDictionary',
                 'tagline' => 'The Viral Vernacular',
                 'maintenance_mode' => 'false',
                 'allow_voting' => 'true',
                 'allow_submissions' => 'true',
             ];
             foreach ($defaults as $key => $val) {
                 DB::table('settings')->insert([
                     'key' => $key, 'value' => $val, 'group' => 'general', 'created_at' => now(), 'updated_at' => now()
                 ]);
             }
             $this->settings = $defaults;
        } else {
            $this->settings = $rows->pluck('value', 'key')->toArray();
        }
    }

    public function save()
    {
        foreach ($this->settings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'group' => $this->group, 'updated_at' => now()]
            );
        }
        $this->dispatch('notify', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.index')->layout('components.layouts.admin');
    }
}
