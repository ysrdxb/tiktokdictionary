<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $username = '';
    public $password = '';
    public $password_confirmation = '';

    public function register()
    {
        $this->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_dash'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $this->username,
            'username' => $this->username,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        return $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.app');
    }
}
