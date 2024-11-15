<?php

namespace App\Events;

use App\Http\Resources\FollowUpResource;
use App\Models\FollowUp;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use App\Enums\FollowUpStatusEnum;

class FollowUpStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $followUp;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new event instance.
     */
    public function __construct(FollowUpResource $followUp, FollowUpStatusEnum $oldStatus, FollowUpStatusEnum $newStatus)
    {
        $this->followUp = $followUp;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PrivateChannel
    {
        $followUpModel = $this->followUp->resource;
        return new PrivateChannel("follow-up-updates.{$followUpModel->id}");
    }
}
