<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Word extends Model
{
    protected $fillable = [
        'term',
        'slug',
        'category',
        'origin_source',
        'first_seen_date',
        'related_word_ids',
        'total_definitions',
        'total_agrees',
        'total_disagrees',
        'velocity_score', // (Votes / Time) * Views
        'admin_boost',    // Manual override
        'rfci_score',     // "88A" grade
        'views_buffer',   // Redis sync holding
        'is_polar_trend', // Neon pulse trigger
        'vibes',          // JSON tags
        'is_verified',
        'ai_summary',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_polar_trend' => 'boolean',
        'velocity_score' => 'decimal:4',
        'related_word_ids' => 'array',
        'vibes' => 'array',
        'first_seen_date' => 'date'
    ];
    
    /**
     * Get the lore entries (timeline) for this word
     */
    public function lore()
    {
        return $this->hasMany(LoreEntry::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get all definitions for this word
     */
    public function definitions()
    {
        return $this->hasMany(Definition::class);
    }

    /**
     * Get the primary (most agreed) definition
     */
    public function primaryDefinition()
    {
        return $this->hasOne(Definition::class)->where('is_primary', true);
    }

    /**
     * Recalculate aggregate statistics from definitions
     */
    public function recalculateStats()
    {
        $this->total_definitions = $this->definitions()->count();
        $this->total_agrees = $this->definitions()->sum('agrees');
        $this->total_disagrees = $this->definitions()->sum('disagrees');
        
        // Calculate velocity based on primary definition
        $primary = $this->primaryDefinition;
        if ($primary) {
            $this->velocity_score = $primary->velocity_score;
        }
        
        $this->save();
    }

    /**
     * Get trending words based on timeframe
     * @param int $limit
     * @param string $timeframe 'today', 'week', 'month', 'all'
     */
    public static function getTrending($limit = 10, $timeframe = 'all')
    {
        $query = static::query()->with('primaryDefinition');
        
        switch ($timeframe) {
            case 'today':
                $query->where('created_at', '>=', now()->subDay());
                break;
            case 'week':
                $query->where('created_at', '>=', now()->subWeek());
                break;
            case 'month':
                $query->where('created_at', '>=', now()->subMonth());
                break;
        }
        
        return $query->orderBy('velocity_score', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Fuzzy search for similar words using SOUNDEX
     */
    public static function fuzzySearch($term)
    {
        return static::whereRaw('SOUNDEX(term) = SOUNDEX(?)', [$term])
            ->orWhere('term', 'LIKE', '%' . $term . '%')
            ->get();
    }

    /**
     * Find similar words for duplicate detection using Levenshtein & Similar Text
     */
    public static function findSimilar($term)
    {
        // 1. Optimization: Only check words starting with same/similar letter or very short words
        // fetching all is bad for scale, but for < 10k words it's fine in memory.
        // Let's filter by first letter to be safe.
        $firstLetter = mb_substr($term, 0, 1);
        
        // potential candidates from DB
        $candidates = static::where('term', 'LIKE', $firstLetter . '%')
            ->orWhereRaw('SOUNDEX(term) = SOUNDEX(?)', [$term]) // Keep soundex as a backup
            ->get();

        $term = strtolower($term);
        $matches = collect();

        foreach ($candidates as $candidate) {
            $candidateTerm = strtolower($candidate->term);
            
            // Skip exact
            if ($candidateTerm === $term) continue;

            $lev = levenshtein($term, $candidateTerm);
            
            // Calculate percentage
            similar_text($term, $candidateTerm, $percent);

            // Logic:
            // 1. If very short word (< 4 chars) & distance is 1 -> flagging
            // 2. If longer word & percent > 75% -> flagging
            // 3. If soundex matches -> flagging
            
            if ($lev <= 2 || $percent > 80) {
                 $matches->push($candidate);
            }
        }

        return $matches->take(5);
    }

    /**
     * Get related words based on stored IDs or category
     */
    public function getRelatedWords($limit = 4)
    {
        // If related_word_ids are set, fetch those specific words
        if ($this->related_word_ids && is_array($this->related_word_ids) && count($this->related_word_ids) > 0) {
            return static::whereIn('id', $this->related_word_ids)
                ->with('primaryDefinition')
                ->limit($limit)
                ->get();
        }
        
        // Otherwise, fallback to words from same category
        return static::where('category', $this->category)
            ->where('id', '!=', $this->id)
            ->with('primaryDefinition')
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Auto-generate slug when creating
     */
    protected static function booted()
    {
        static::creating(function ($word) {
            if (empty($word->slug)) {
                $word->slug = Str::slug($word->term);
            }
        });
    }
}
