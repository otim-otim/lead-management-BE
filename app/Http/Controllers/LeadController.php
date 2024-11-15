<?php

namespace App\Http\Controllers;

use App\Http\DTO\LeadCreateDTO;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Services\LeadService;

class LeadController extends Controller
{
    public function __construct(public LeadService $leadService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $leads = $this->leadService->index();
            return response()->json([
                'success' => true,
                'data' => $leads
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required'],
                'email' => ['required','email','unique:leads'],
                'phone' => ['required','numeric',  'unique:leads'],
            ]);

            $dto = LeadCreateDTO::fromRequest($request);
            $lead = $this->leadService->create($dto);
            return response()->json([
                'success' => true,
                'data' => $lead
            ], 200);
            
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $lead = $this->leadService->show($id);
            return response()->json([
                'success' => true,
                'data' => $lead
            ], 200);
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
