<?php

namespace App\Livewire\Admin\Words;

use Livewire\Component;
use App\Models\Word;
use App\Models\LoreEntry;

class Edit extends Component
{
    public Word $word;

    // Word fields
    public $term;
    public $category;
    public $admin_boost;
    public $rfci_score;
    public $is_verified;
    public $is_polar_trend;

    // Lore fields (matching actual DB columns)
    public $lore_platform = 'tiktok';
    public $lore_description;
    public $lore_source_url;
    public $lore_creator_handle;

    protected $rules = [
        'term' => 'required|string|max:100',
        'category' => 'required|string',
        'admin_boost' => 'required|integer|min:0|max:10000',
        'rfci_score' => 'nullable|string|max:10',
        'is_verified' => 'boolean',
        'is_polar_trend' => 'boolean',
    ];

    public function mount(Word $word)
    {
        $this->word = $word;
        $this->term = $word->term;
        $this->category = $word->category;
        $this->admin_boost = $word->admin_boost ?? 0;
        $this->rfci_score = $word->rfci_score;
        $this->is_verified = $word->is_verified ?? false;
        $this->is_polar_trend = $word->is_polar_trend ?? false;
    }

    public function save()
    {
        $this->validate();

        $this->word->update([
            'term' => $this->term,
            'category' => $this->category,
            'admin_boost' => $this->admin_boost,
            'rfci_score' => $this->rfci_score,
            'is_verified' => $this->is_verified,
            'is_polar_trend' => $this->is_polar_trend,
        ]);

        // Recalculate viral score if method exists
        if (method_exists($this->word, 'recalculateStats')) {
            $this->word->recalculateStats();
        }

        $this->word->refresh();

        $this->dispatch('notify', 'Word updated successfully!');
    }

    public function addLore()
    {
        $this->validate([
            'lore_platform' => 'required|string|in:tiktok,twitter,instagram,youtube,other',
            'lore_description' => 'required|string',
            'lore_source_url' => 'required|url',
            'lore_creator_handle' => 'nullable|string|max:100',
        ]);

        LoreEntry::create([
            'word_id' => $this->word->id,
            'platform' => $this->lore_platform,
            'description' => $this->lore_description,
            'source_url' => $this->lore_source_url,
            'creator_handle' => $this->lore_creator_handle,
        ]);

        $this->reset(['lore_platform', 'lore_description', 'lore_source_url', 'lore_creator_handle']);
        $this->lore_platform = 'tiktok';
        $this->word->refresh();

        $this->dispatch('notify', 'Lore entry added!');
    }

    public function deleteLore($loreId)
    {
        LoreEntry::where('id', $loreId)->where('word_id', $this->word->id)->delete();
        $this->word->refresh();

        $this->dispatch('notify', 'Lore entry deleted.');
    }

    public function delete()
    {
        $this->word->delete();

        return redirect()->route('admin.words')->with('success', 'Word deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.words.edit', [
            'loreEntries' => $this->word->lore()->orderBy('created_at', 'desc')->get(),
        ])->layout('components.layouts.admin');
    }
}
