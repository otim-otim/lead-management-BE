<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SeniorUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (  in_array($user->role, [UserRoleEnum::ADMIN->value, UserRoleEnum::SALESMANAGER->value]) ) {
            return $next($request);
            
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
