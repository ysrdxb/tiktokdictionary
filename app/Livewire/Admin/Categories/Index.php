<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category; // We need to create this model first if mock wasn't enough
use Illuminate\Support\Str;

class Index extends Component
{
    public $categories;
    public $name, $color = '#002B5B', $icon;
    public $editingId = null;

    protected $rules = [
        'name' => 'required|min:2',
        'color' => 'required',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        // If DB table exists, fetch. Else mock or empty.
        try {
            $this->categories = \DB::table('categories')->orderBy('sort_order')->get();
        } catch (\Exception $e) {
            $this->categories = collect(); // Table might not exist in some states
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            \DB::table('categories')->where('id', $this->editingId)->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'color' => $this->color,
                'icon' => $this->icon,
                'updated_at' => now()
            ]);
            $this->dispatch('notify', 'Category updated.');
        } else {
            \DB::table('categories')->insert([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'color' => $this->color,
                'icon' => $this->icon,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $this->dispatch('notify', 'Category created.');
        }

        $this->reset(['name', 'color', 'icon', 'editingId']);
        $this->loadCategories();
    }

    public function edit($id)
    {
        $cat = $this->categories->firstWhere('id', $id);
        $this->editingId = $id;
        $this->name = $cat->name;
        $this->color = $cat->color;
        $this->icon = $cat->icon;
    }

    public function delete($id)
    {
        \DB::table('categories')->delete($id);
        $this->loadCategories();
        $this->dispatch('notify', 'Category deleted.');
    }

    public function render()
    {
        return view('livewire.admin.categories.index')->layout('components.layouts.admin');
    }
}
