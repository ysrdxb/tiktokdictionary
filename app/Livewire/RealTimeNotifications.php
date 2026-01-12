<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Word;
use Illuminate\Support\Carbon;

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
        // 1. Fetch Global Word Submissions (Last 24 hours)
        $globalNotifications = Word::where('created_at', '>=', now()->subDay())
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($word) {
                return [
                    'id' => 'word_' . $word->id, // Unique ID for Alpine key
                    'type' => 'word_submission',
                    'data' => [
                        'title' => 'New Word Submitted!',
                        'word' => $word->term,
                        'message' => "The word '{$word->term}' has just been added.",
                        'icon' => '🚀',
                    ],
                    'created_at' => $word->created_at,
                    'read_at' => null, // Global notifications are never "read" in DB
                ];
            });

        // 2. Fetch Personal Notifications (Votes, etc.) if logged in
        $personalNotifications = collect([]);
        if (Auth::check()) {
            $personalNotifications = Auth::user()
                ->unreadNotifications()
                ->where('created_at', '>=', now()->subDay())
                ->take(5)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => 'personal',
                        'data' => $notification->data,
                        'created_at' => $notification->created_at,
                        'read_at' => $notification->read_at,
                        'model' => $notification // Keep reference to mark as read
                    ];
                });
        }

        // 3. Merge and Sort
        $this->notifications = $globalNotifications->merge($personalNotifications)
            ->sortByDesc('created_at')
            ->take(5)
            ->values()
            ->toArray();
    }

    public function markAsRead($notificationId)
    {
        // Only personal notifications can be marked as read in DB
        if (str_starts_with($notificationId, 'word_')) {
            return; // It's a global notification, handled by frontend only
        }

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
