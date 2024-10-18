<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->authenticate();

//        $request->session()->regenerate();
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return ResponseService::success([
            'access_token' => $token,
            'user' => $user
        ], "login success");
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return ResponseService::success(null, "Logged out successfully");
    }
}
