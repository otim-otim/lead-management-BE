<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(public UserService $userService)
    {
        
    }
    public function index()
    {
       try {
        $users = $this->userService->index();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
            'success' => false,
            'message' => $th->getMessage()
        ]);
       }
    }
}
