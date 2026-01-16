<?php

namespace App\Models;

use App\Traits\Flaggable;
use Illuminate\Database\Eloquent\Model;

class Definition extends Model
{
    use Flaggable;

    protected $fillable = [
        'word_id',
        'definition',
        'example',
        'submitted_by',
        'source_platform',
        'source_url',
        'agrees',
        'disagrees',
        'velocity_score',
        'is_primary',
        'is_approved', // Added for moderation
        'reaction_fire',
        'reaction_skull',
        'reaction_melt',
        'reaction_clown'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_approved' => 'boolean',
        'velocity_score' => 'decimal:4'
    ];

    /**
     * Get the word this definition belongs to
     */
    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    /**
     * Get the reactions for this definition
     */
    public function reactions()
    {
        return $this->hasMany(DefinitionReaction::class);
    }

    /**
     * Calculate and update velocity score
     * Formula: (Agrees - Disagrees) / (HoursOld + 2)^1.5
     */
    public function updateVelocityScore()
    {
        $hoursOld = $this->created_at->diffInHours(now());
        $score = ($this->agrees - $this->disagrees) / pow(($hoursOld + 2), 1.5);
        
        $this->velocity_score = round($score, 4);
        $this->save();
        
        // Check if this should become the primary definition
        $this->checkIfPrimary();
        
        // Update parent word statistics
        $this->word->recalculateStats();
    }

    /**
     * Check if this definition should be marked as primary
     * (most agrees for the word)
     */
    public function checkIfPrimary()
    {
        $word = $this->word;
        
        // Get the definition with most agrees
        $topDefinition = $word->definitions()
            ->orderBy('agrees', 'desc')
            ->first();
        
        if ($topDefinition && $topDefinition->id === $this->id) {
            // This is now the primary definition
            $word->definitions()->where('is_primary', true)->update(['is_primary' => false]);
            $this->is_primary = true;
            $this->save();
        }
    }

    /**
     * Auto-update velocity when created
     */
    protected static function booted()
    {
        static::created(function ($definition) {
            $definition->updateVelocityScore();
        });
    }

    /**
     * Confidence badge derived from community voting.
     *
     * Uses a simple rule set so users can quickly judge reliability without
     * needing to interpret raw numbers.
     */
    public function confidenceMeta(): array
    {
        $agrees = (int) $this->agrees;
        $disagrees = (int) $this->disagrees;

        $votes = max(0, $agrees + $disagrees);
        $accuracy = $votes > 0 ? ($agrees / $votes) : 0.0;

        if ($votes < 10) {
            return [
                'label' => 'New',
                'detail' => 'Not enough votes yet',
                'class' => 'bg-slate-100 text-slate-700 border-slate-200',
            ];
        }

        if ($accuracy >= 0.8 && $votes >= 25) {
            return [
                'label' => 'High confidence',
                'detail' => 'Strong agreement',
                'class' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            ];
        }

        if ($accuracy >= 0.6) {
            return [
                'label' => 'Likely',
                'detail' => 'Mostly agreed',
                'class' => 'bg-green-50 text-green-800 border-green-200',
            ];
        }

        if ($accuracy >= 0.4) {
            return [
                'label' => 'Mixed',
                'detail' => 'Split opinions',
                'class' => 'bg-amber-50 text-amber-900 border-amber-200',
            ];
        }

        return [
            'label' => 'Contested',
            'detail' => 'More disagreement than agreement',
            'class' => 'bg-rose-50 text-rose-900 border-rose-200',
        ];
    }
}
