<?php

namespace App\Jobs;

use App\Models\FollowUp;
use App\Enums\FollowUpStatusEnum;
use App\Events\FollowUpStatusChanged;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class FollowUpMissedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $follow_ups = FollowUp::where('status','!=' ,'missed')->where('scheduled_at', '<', now())->get();

        foreach ($follow_ups as $follow_up) {
            $old_status = $follow_up->status;
            $follow_up->status = FollowUpStatusEnum::MISSED->value;
            $follow_up->save();
            event(new FollowUpStatusChanged($follow_up,$old_status,FollowUpStatusEnum::MISSED->value));
        }
    }
}
