<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    protected $fillable = [
        'reporter_id', 'reporter_ip', 'flaggable_type', 'flaggable_id',
        'reason', 'details', 'status', 'reviewed_by', 'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the flaggable model (Word or Definition).
     */
    public function flaggable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who reported this content.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the moderator who reviewed this flag.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope for pending flags.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for reviewed flags.
     */
    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    /**
     * Mark flag as reviewed.
     */
    public function markAsReviewed($userId)
    {
        $this->update([
            'status' => 'reviewed',
            'reviewed_by' => $userId,
            'reviewed_at' => now(),
        ]);
    }

    /**
     * Dismiss the flag.
     */
    public function dismiss($userId)
    {
        $this->update([
            'status' => 'dismissed',
            'reviewed_by' => $userId,
            'reviewed_at' => now(),
        ]);
    }
}
