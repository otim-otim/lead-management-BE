<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\FollowUpController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    //leads routes
    Route::post('/leads', [LeadController::class, 'store']);
    Route::get('/leads/{id}', [LeadController::class, 'show']);
    Route::get('/leads', [LeadController::class, 'index']);

    //followup routes

    Route::post('/followups', [FollowUpController::class, 'store']);
    Route::get('/followups/{id}', [FollowUpController::class, 'show']);
    Route::get('/followups', [FollowUpController::class, 'index']);
    Route::patch('/followups/{id}/{status}', [FollowUpController::class, 'updateFollowUpStatus'])->middleware('senior-user');

    Route::get('/users',[UserController::class, 'index']);
    
});