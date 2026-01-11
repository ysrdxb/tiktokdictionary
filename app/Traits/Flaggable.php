<?php

namespace App\Traits;

use App\Models\Flag;

trait Flaggable
{
    /**
     * Get all flags for this model.
     */
    public function flags()
    {
        return $this->morphMany(Flag::class, 'flaggable');
    }

    /**
     * Flag this content for review.
     *
     * @param string $reason  One of: spam, offensive, incorrect, duplicate, other
     * @param string|null $details  Additional details about the report
     * @param int|null $userId  The reporter's user ID (null for anonymous)
     * @return Flag
     */
    public function flag($reason, $details = null, $userId = null)
    {
        return $this->flags()->create([
            'reporter_id' => $userId,
            'reporter_ip' => request()->ip(),
            'reason' => $reason,
            'details' => $details,
        ]);
    }

    /**
     * Check if this content has pending flags.
     */
    public function hasPendingFlags(): bool
    {
        return $this->flags()->pending()->exists();
    }

    /**
     * Get count of pending flags.
     */
    public function pendingFlagsCount(): int
    {
        return $this->flags()->pending()->count();
    }
}
