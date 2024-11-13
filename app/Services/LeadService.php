<?php

namespace App\Services;

use App\Http\DTO\LeadCreateDTO;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class LeadService
{
    public function create(LeadCreateDTO $leadCreateDTO): Lead
    {
        return DB::transaction(function () use ($leadCreateDTO) {
            return Lead::create($leadCreateDTO->toArray());
        });
    }
}