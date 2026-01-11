<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Definition;
use Illuminate\Support\Facades\Cookie;

class VotingCounter extends Component
{
    public $definitionId;
    public $agrees;
    public $disagrees;
    public $userVote = null; // 'agree', 'disagree', or null

    public function mount($definitionId, $agrees, $disagrees)
    {
        $this->definitionId = $definitionId;
        $this->agrees = $agrees;
        $this->disagrees = $disagrees;
        
        // Check if user has already voted
        $cookieName = 'vote_' . $this->definitionId;
        $this->userVote = Cookie::get($cookieName);
    }

    public function vote($type)
    {
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
        } else {
            // User is voting or changing vote
            if ($type === 'agree') {
                $definition->agrees++;
            } elseif ($type === 'disagree') {
                $definition->disagrees++;
            }
            $this->userVote = $type;
            $this->persistVote($cookieName, $type);
        }

        $definition->save();
        $definition->updateVelocityScore();

        // Update local state for optimistic UI
        $this->refreshVotes($definition);
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
