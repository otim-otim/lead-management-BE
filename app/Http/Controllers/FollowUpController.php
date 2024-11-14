<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\FollowUpStatusEnum;
use App\Services\FollowUpService;
use App\Http\DTO\FollowUpCreateDTO;
use App\Http\DTO\FollowUpUpdateDTO;
use Illuminate\Validation\Rules\Exists;

class FollowUpController extends Controller
{

    public function __construct(public FollowUpService $followUpService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $followups = $this->followUpService->index();
            return response()->json([
                'success' => true,
                'data' =>$followups
            ]);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ],$th->getCode());
        }
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'lead_id' => ['required',Rule::exists('leads','id')],
                'user_id' => ['required',Rule::exists('users','id')],
                'scheduled_at' => ['required','date:Y-m-d','after:today',],
            ]);

            $dto = FollowUpCreateDTO::fromRequest($request);
            $follow_up = $this->followUpService->store($dto);
            return response()->json([
                'success' => true,
                'data' => $follow_up
            ],201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $follow_up = $this->followUpService->show($id);
            return response()->json([
                'success' => true,
                'data' => $follow_up
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'user_id' => ['nullable', Rule::exists('users', 'id')],
                'scheduled_at' => ['nullable', 'date:Y-m-d', 'after:today'],
                'status' => ['nullable', Rule::in(FollowUpStatusEnum::toArray())] 
            ]);
            $dto = FollowUpUpdateDTO::fromRequest($request);
            $follow_up = $this->followUpService->update($dto,$id);
            
            return response()->json([
                'success' => true,
                'data' => $follow_up
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowUp $followUp)
    {
        //
    }
}
