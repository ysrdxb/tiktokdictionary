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
        $this->agrees = $agrees;
        $this->disagrees = $disagrees;

        // Check if voting is enabled globally (tolerate boolean/string values)
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
            $definition->agrees--;
        } elseif ($existingVote === 'disagree') {
            $definition->disagrees--;
        }

        // Add new vote if different from existing
        if ($type === $existingVote) {
            // User is removing their vote
            $this->userVote = null;
            $this->deleteVote($cookieName);
            
            // Remove from DB (Simplest logic: remove their most recent vote of this type)
            // Ideally we'd match exact user/ip, but for now this suffices or we can add strict check
            $query = \Illuminate\Support\Facades\DB::table('votes')
                ->where('definition_id', $this->definitionId)
                ->where('type', $type);
                
            if (\Illuminate\Support\Facades\Auth::check()) {
                $query->where('user_id', \Illuminate\Support\Facades\Auth::id());
            } else {
                $query->where('ip_address', request()->ip());
            }
            $query->delete();

        } else {
            // User is voting or changing vote
            if ($type === 'agree') {
                $definition->agrees++;
            } elseif ($type === 'disagree') {
                $definition->disagrees++;
            }
            $this->userVote = $type;
            $this->persistVote($cookieName, $type);
            
            // Record to DB for Analytics
            \Illuminate\Support\Facades\DB::table('votes')->insert([
                'definition_id' => $this->definitionId,
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'ip_address' => request()->ip(),
                'type' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
