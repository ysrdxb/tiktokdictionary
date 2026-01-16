<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Definition;
use App\Models\DefinitionReaction;
use Illuminate\Support\Facades\Request;

class ReactionBar extends Component
{
    public $definitionId;
    public $counts = [];
    public $userReaction = null;

    public function mount($definitionId)
    {
        $this->definitionId = $definitionId;
        $this->loadReactions();
    }

    public function loadReactions()
    {
        $def = Definition::find($this->definitionId);
        if ($def) {
            $this->counts = [
                'fire'  => $def->reaction_fire,
                'skull' => $def->reaction_skull,
                'melt'  => $def->reaction_melt,
                'clown' => $def->reaction_clown,
            ];
        }

        // Check for existing reaction by IP
        $ip = Request::ip();
        $reaction = DefinitionReaction::where('definition_id', $this->definitionId)
            ->where('ip_address', $ip)
            ->first();

        $this->userReaction = $reaction ? $reaction->type : null;
    }

    public function react($type)
    {
        if (!in_array($type, ['fire', 'skull', 'melt', 'clown'])) return;

        $ip = Request::ip();
        $definition = Definition::find($this->definitionId);

        if (!$definition) return;

        $existing = DefinitionReaction::where('definition_id', $this->definitionId)
            ->where('ip_address', $ip)
            ->first();

        if ($existing) {
            if ($existing->type === $type) {
                // Toggle off
                $existing->delete();
                $definition->decrement("reaction_{$type}");
                $this->userReaction = null;
            } else {
                // Change reaction
                $oldType = $existing->type;
                $definition->decrement("reaction_{$oldType}");
                
                $existing->update(['type' => $type]);
                $definition->increment("reaction_{$type}");
                $this->userReaction = $type;
            }
        } else {
            // New reaction
            DefinitionReaction::create([
                'definition_id' => $this->definitionId,
                'ip_address' => $ip,
                'type' => $type
            ]);
            $definition->increment("reaction_{$type}");
            $this->userReaction = $type;
        }

        $this->loadReactions();
    }

    public function render()
    {
        return view('livewire.reaction-bar');
    }
}
