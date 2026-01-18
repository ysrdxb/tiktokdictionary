<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Definition;
use App\Models\Setting;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\RateLimiter;

class VotingCounter extends Component
{
    public $definitionId;
    public $agrees;
    public $disagrees;
    public $userVote = null; // 'agree', 'disagree', or null
    public $votingEnabled = true;

    public function mount($definitionId, $agrees, $disagrees)
    {
        $this->definitionId = $definitionId;
        
        // Always refresh counts from DB to avoid stale data from parent
        $definition = Definition::find($definitionId);
        $this->agrees = $definition->agrees ?? 0;
        $this->disagrees = $definition->disagrees ?? 0;

        // Check if voting is enabled globally
        $this->votingEnabled = filter_var(Setting::get('allow_voting', true), FILTER_VALIDATE_BOOLEAN);

        // Check if user has already voted
        $cookieName = 'vote_' . $this->definitionId;
        $this->userVote = Cookie::get($cookieName);
    }

    public function vote($type)
    {
        // Check if voting is enabled
        if (!$this->votingEnabled) {
            return;
        }
        
        // Rate limiting (Admin-controlled)
        $enabled = filter_var(Setting::get('rate_limit_enabled', false), FILTER_VALIDATE_BOOLEAN);
        $max = (int) Setting::get('rate_limit_requests', 60);
        $period = (int) Setting::get('rate_limit_period', 1); // minutes
        $key = 'vote:' . request()->ip();
        if ($enabled && RateLimiter::tooManyAttempts($key, $max)) {
            $wait = RateLimiter::availableIn($key);
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "You're doing that too fast. Try again in {$wait}s."
            ]);
            return; // Ignore extra attempts, show toast
        }

        $definition = Definition::find($this->definitionId);

        if (!$definition) {
            return;
        }

        $cookieName = 'vote_' . $this->definitionId;
        $existingVote = Cookie::get($cookieName);

        // Remove previous vote if exists
        if ($existingVote === 'agree') {
            $definition->agrees = max(0, $definition->agrees - 1);
        } elseif ($existingVote === 'disagree') {
            $definition->disagrees = max(0, $definition->disagrees - 1);
        }

        // Add new vote if different from existing
        if ($type === $existingVote) {
            $this->userVote = null;
            $this->deleteVote($cookieName);
            
            \Illuminate\Support\Facades\DB::table('votes')
                ->where('definition_id', $this->definitionId)
                ->where(function($q) {
                    if (\Illuminate\Support\Facades\Auth::check()) {
                        $q->where('user_id', \Illuminate\Support\Facades\Auth::id());
                    } else {
                        $q->where('ip_address', request()->ip());
                    }
                })
                ->where('type', $type)
                ->delete();

        } else {
            if ($type === 'agree') {
                $definition->agrees++;
            } elseif ($type === 'disagree') {
                $definition->disagrees++;
            }
            $this->userVote = $type;
            $this->persistVote($cookieName, $type);
            
            // Record to DB using updateOrInsert to prevent duplicates
            \Illuminate\Support\Facades\DB::table('votes')->updateOrInsert(
                [
                    'definition_id' => $this->definitionId,
                    'user_id' => \Illuminate\Support\Facades\Auth::id(),
                    'ip_address' => \Illuminate\Support\Facades\Auth::check() ? null : request()->ip(),
                ],
                [
                    'type' => $type,
                    'updated_at' => now(),
                ]
            );
        }

        $definition->save();
        $definition->updateVelocityScore();

        // Update local state for optimistic UI
        $this->refreshVotes($definition);

        // Rate limiter hit bookkeeping
        if ($enabled) {
            RateLimiter::hit($key, $period * 60);
        }

        // Send Notification
        $this->sendNotification($definition, $type);
    }

    protected function sendNotification($definition, $type)
    {
        // Find the author based on username
        $author = \App\Models\User::where('username', $definition->submitted_by)->first();

        // If author exists and acts is not the current user
        if ($author && $author->id !== auth()->id()) {
            $author->notify(new \App\Notifications\VoteReceived($definition, $type));
        }
    }

    protected function persistVote($cookieName, $type)
    {
        Cookie::queue($cookieName, $type, 60 * 24 * 7); // 7 days
    }

    protected function deleteVote($cookieName)
    {
        Cookie::queue(Cookie::forget($cookieName));
    }

    protected function refreshVotes($definition)
    {
        $this->agrees = $definition->agrees;
        $this->disagrees = $definition->disagrees;
    }

    public function render()
    {
        return view('livewire.voting-counter');
    }
}
