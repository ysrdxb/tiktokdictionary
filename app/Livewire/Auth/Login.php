<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $username = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return $this->redirectIntended(route('home'), navigate: true);
        }

        throw ValidationException::withMessages([
            'username' => __('The provided credentials do not match our records.'),
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.app');
    }
}
