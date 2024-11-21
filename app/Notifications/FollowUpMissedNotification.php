<?php

namespace App\Notifications;

use App\Models\FollowUp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FollowUpMissedNotification extends Notification
{
    use Queueable;

    public Lead $lead ;
    public User $user ;    

    /**
     * Create a new notification instance.
     */
    public function __construct(public FollowUp $followUp)
    {
        $this->lead = $followUp->lead;
        $this->user = $followUp->user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database']; // Adding database to persist notifications
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable)
    {
        
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'followup_missed',
            'data' => [
                'followup_id' => $this->followUp->id,
                'title' => 'followup missed',
                'message' => 'The follow-up for '.$this->lead->name.' has been missed.',
                'action_url' => '/follow-ups/'.$this->followUp->id,
                'created_at' => now()->toISOString(),
            ]
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'followup missed',
            'message' => 'The follow-up for '.$this->lead->name.' has been missed.',
            'action_url' => '/follow-ups/'.$this->followUp->id,
        ];
    }
}
