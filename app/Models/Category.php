<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'color',
        'sort_order', 'is_active', 'words_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get words in this category.
     */
    public function words()
    {
        return $this->hasMany(Word::class);
    }

    /**
     * Scope to only active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Auto-generate slug on creation.
     */
    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Update the cached words count.
     */
    public function updateWordsCount()
    {
        $this->update(['words_count' => $this->words()->count()]);
    }
}
