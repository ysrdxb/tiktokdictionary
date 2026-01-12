<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RealTimeNotifications extends Component
{
    public $notifications = [];

    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function poll()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (Auth::check()) {
            // Get unread notifications
            $this->notifications = Auth::user()->unreadNotifications->take(5);
        } else {
            $this->notifications = collect([]);
        }
    }

    public function markAsRead($notificationId)
    {
        if (Auth::check()) {
            $notification = Auth::user()->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                $this->loadNotifications();
            }
        }
    }

    public function render()
    {
        return view('livewire.real-time-notifications');
    }
}
