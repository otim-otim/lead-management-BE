<?php

namespace App\Http\DTO;

use DateTime;
use Illuminate\Http\Request;

class FollowUpCreateDTO
{
    public function __construct(
        public string $lead_id,
        public string $user_id,
        public DateTime $scheduled_at

    ) {

    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('leadId'),
            $request->input('userId'),
            $request->input('scheduleDate'),
        );
    }

    public function toArray(): array
    {
        $data = [
            'lead_id' => $this->lead_id,
            'user_id' => $this->user_id,
            'scheduled_at' => $this->scheduled_at,
        ];

        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }

}
