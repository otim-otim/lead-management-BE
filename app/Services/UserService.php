<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function index(){
        try {
            return UserResource::collection(User::all());
        } catch (\Throwable $th) {
            throw $th;
        }
    }
   
}