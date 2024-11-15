<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Handle user login attempt
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        // Rate limiting
        $key = 'login.' . $request->ip();
        $maxAttempts = 5; // Max attempts within decay time
        $decayMinutes = 1; // Time in minutes before attempts reset

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'error' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.'
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        try {
            // Validate request
            $validated = $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
                'device_name' => ['sometimes', 'string'], // Optional for token creation
            ]);

            // Attempt to authenticate
            if (!Auth::attempt($validated)) {
                RateLimiter::hit($key);
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            // Clear failed login attempts
            RateLimiter::clear($key);

            // Get authenticated user
            $user = User::where('email', $validated['email'])->first();

            // Create token if device_name is provided
            $token = $request->has('device_name') 
                ? $user->createToken($request->device_name)->plainTextToken 
                : null;

            // Regenerate session
            $request->session()->regenerate();

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Login successful'
            ], Response::HTTP_OK);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Handle user logout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke all tokens if using Sanctum token authentication
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // Logout from session
        Auth::guard('web')->logout();

        // Invalidate and regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Get authenticated user details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ], Response::HTTP_OK);
    }
}