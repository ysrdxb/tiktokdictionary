<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Word;

class WordSubmitted extends Notification
{
    // use Queueable; // Removed to ensure instant delivery without workers

    public $word;

    /**
     * Create a new notification instance.
     */
    public function __construct(Word $word)
    {
        $this->word = $word;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'word_id' => $this->word->id,
            'word' => $this->word->term,
            'title' => 'Word Submitted!',
            'message' => "Your word '{$this->word->term}' has been successfully submitted.",
            'icon' => '🚀',
        ];
    }
}
