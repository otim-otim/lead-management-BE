<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowUpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'lead_id' => new LeadResource($this->lead), 
            'user_id' => new UserResource($this->user), 
            'scheduledAt' => Carbon::parse($this->scheduled_at)->format('Y-m-d H:i:s'), 
            'status' => $this->status,
            'createdAt' => $this->created_at,
        ];
    }
}