<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'role',
        'banned_at',
        'ban_reason',
        'avatar',
        'bio',
        'total_submissions',
        'total_votes_received',
        'reputation_score',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'banned_at' => 'datetime',
            'last_active_at' => 'datetime',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the words submitted by this user.
     */
    public function words()
    {
        return $this->hasMany(Word::class);
    }

    /**
     * Get the definitions submitted by this user.
     */
    public function definitions()
    {
        return $this->hasMany(Definition::class);
    }

    /**
     * Get activity logs for this user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Check if user is banned.
     */
    public function isBanned(): bool
    {
        return $this->role === 'banned' || $this->banned_at !== null;
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->is_admin;
    }

    /**
     * Check if user is moderator or higher.
     */
    public function isModerator(): bool
    {
        return in_array($this->role, ['admin', 'moderator']);
    }

    /**
     * Check if user is trusted.
     */
    public function isTrusted(): bool
    {
        return in_array($this->role, ['admin', 'moderator', 'trusted']);
    }

    /**
     * Ban the user.
     */
    public function ban(?string $reason = null): void
    {
        $this->update([
            'role' => 'banned',
            'banned_at' => now(),
            'ban_reason' => $reason,
        ]);
    }

    /**
     * Unban the user.
     */
    public function unban(): void
    {
        $this->update([
            'role' => 'regular',
            'banned_at' => null,
            'ban_reason' => null,
        ]);
    }

    /**
     * Update last active timestamp.
     */
    public function touchLastActive(): void
    {
        $this->update(['last_active_at' => now()]);
    }

    /**
     * Increment submission count.
     */
    public function incrementSubmissions(): void
    {
        $this->increment('total_submissions');
    }

    /**
     * Increment votes received count.
     */
    public function incrementVotesReceived(int $amount = 1): void
    {
        $this->increment('total_votes_received', $amount);
    }

    /**
     * Recalculate reputation score based on submissions and votes.
     */
    public function recalculateReputation(): void
    {
        $score = ($this->total_submissions * 5) + $this->total_votes_received;
        $this->update(['reputation_score' => $score]);
    }
}
