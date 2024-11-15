<?php

namespace App\Notifications;

use App\Models\FollowUp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class FollowUpMissedNotification extends Notification
{
    use Queueable;

    // protected $followUp;

    /**
     * Create a new notification instance.
     */
    public function __construct(public FollowUp $followUp)
    {
        // $this->followUp = $followUp;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // Choose your preferred channels, e.g., 'mail', 'database', etc.
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Follow-Up Status Marked as Missed')
                    ->line('The follow-up for '.$this->followUp->title.' has been marked as missed.')
                    ->action('View Follow-Up', url('/follow-ups/'.$this->followUp->id))
                    ->line('Please take appropriate action.');
    }
}
