<?php

namespace App\Http\DTO;

use DateTime;
use Illuminate\Http\Request;
use App\Enums\FollowUpStatusEnum;

class FollowUpCreateDTO
{
    public function __construct(
        public string $lead_id,
        public string $user_id,
        public string $scheduled_at

    ) {

    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('leadId'),
            $request->input('userId'),
            $request->input('scheduleAt'),
        );
    }

    public function toArray(): array
    {
        $data = [
            'lead_id' => $this->lead_id,
            'user_id' => $this->user_id,
            'scheduled_at' => $this->scheduled_at,
            'status' => FollowUpStatusEnum::PENDING
        ];

        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }

}
