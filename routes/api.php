<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    //leads routes
    Route::post('/lead', [LeadController::class, 'store']);
    Route::get('/lead', [LeadController::class, 'show']);
    Route::get('/leads', [LeadController::class, 'index']);

    //followup routes

    
});
