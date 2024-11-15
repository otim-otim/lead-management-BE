<?php

namespace App\Services;

use App\Http\DTO\LeadCreateDTO;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;


class LeadService
{
    public function create(LeadCreateDTO $leadCreateDTO): LeadResource
    {
        try {
            $lead =  Lead::create($leadCreateDTO->toArray());
            return new LeadResource($lead);
        } catch (\Throwable $th) {
            throw $th; //handle error someother way
        }
    }



    public function index(){
        try {
            $leads = Lead::latest()->get();
            return LeadResource::collection($leads);
        } catch (\Throwable $th) {
            throw $th; //handle error someother way
        }
    }

    public function show($id){
        try {
            $lead = Lead::findOrFail($id);
            return new LeadResource($lead);
        } catch (\Throwable $th) {
            throw $th; //handle error someother way
        }
    }
}