<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Definition;

class VoteReceived extends Notification
{
    // use Queueable;

    public $definition;
    public $type; // 'agree' or 'disagree'

    /**
     * Create a new notification instance.
     */
    public function __construct(Definition $definition, string $type)
    {
        $this->definition = $definition;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Storing in DB for Livewire polling
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'definition_id' => $this->definition->id,
            'word' => $this->definition->word->term,
            'type' => $this->type,
            'title' => 'New Vote Received',
            'message' => $this->type === 'agree' 
                ? "Someone agreed with your definition of {$this->definition->word->term}!" 
                : "Someone disagreed with your definition of {$this->definition->word->term}.",
            'icon' => $this->type === 'agree' ? '👍' : '👎',
        ];
    }
}
