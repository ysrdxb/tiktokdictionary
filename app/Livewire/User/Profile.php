<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Word;
use App\Models\Definition;

class Profile extends Component
{
    public $user;
    public $tab = 'words'; // words, definitions

    public function mount($username)
    {
        $this->user = User::where('username', $username)->firstOrFail();
    }

    public function render()
    {
        $words = $this->user->words()->orderBy('created_at', 'desc')->get();
        // Assuming relationship exists, if not we'll query directly
        $definitions = Definition::where('user_id', $this->user->id)
            ->with('word')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.user.profile', [
            'words' => $words,
            'definitions' => $definitions
        ]);
    }
}
