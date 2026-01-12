<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Word;
use App\Notifications\WordSubmitted;

class BackfillNotificationsForNewUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        // When a new user registers...
        $user = $event->user;

        // Find all words submitted in the last 24 hours
        $recentWords = Word::where('created_at', '>=', now()->subDay())->get();

        // Send a notification for each word to populate their "feed"
        foreach ($recentWords as $word) {
            $user->notify(new WordSubmitted($word));
        }
    }
}
