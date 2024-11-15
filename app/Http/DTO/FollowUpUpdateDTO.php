<?php

namespace App\Http\DTO;

use DateTime;
use Illuminate\Http\Request;
use App\Enums\FollowUpStatusEnum;

class FollowUpUpdateDTO
{
    public function __construct(
        public ?string $user_id = null,
        public ?DateTime $scheduled_at = null,
        public ?FollowUpStatusEnum  $status = null

    ) {

    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('userId') ?? null,
            $request->input('scheduleAt') ?? null,
            $request->input('status') ?? null
        );
    }

    public function toArray(): array
    {
        $data = [
            'user_id' => $this->user_id,
            'scheduled_at' => $this->scheduled_at,
            'status' => $this->status
        ];

        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }

}
