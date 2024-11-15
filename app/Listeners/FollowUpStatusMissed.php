<?php

namespace App\Listeners;

use App\Events\FollowUpStatusChanged;
use App\Notifications\FollowUpMissedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FollowUpStatusMissed implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(FollowUpStatusChanged $event): void
    {
        // Check if the new status is "missed"
        if ($event->newStatus === 'missed') {
            // Send notification to relevant users
            $event->followUp->user->notify(new FollowUpMissedNotification($event->followUp));
        }
    }
}
