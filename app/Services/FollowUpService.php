<?php

namespace App\Services;

use App\Events\FollowUpStatusChanged;
use App\Models\Lead;
use App\Models\FollowUp;
use Illuminate\Support\Facades\DB;
use App\Http\DTO\FollowUpCreateDTO;
use App\Http\DTO\FollowUpUpdateDTO;
use App\Http\Resources\FollowUpResource;

class FollowUpService
{
    public function index(){
        try {
            $followups = FollowUp::latest()->get();
            return FollowUpResource::collection($followups);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(FollowUpCreateDTO $dto){
        try {
            $followup = FollowUp::create($dto->toArray());
            return new FollowUpResource($followup);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function show($id){
        try {
            $followup = FollowUp::find($id);
            return new FollowUpResource($followup);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(FollowUpUpdateDTO $dto, $id){
        try {
            $followup = FollowUp::findOrFail($id);
            $followup->update($dto->toArray());
            return new FollowUpResource($followup);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateFollowUpStatus(FollowUpUpdateDTO $dto, $id){
        try {
            $followup = $this->update($dto, $id);
            if($followup)
                event(new FollowUpStatusChanged($followup,$dto->status ,$followup->status));
            return $followup;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}