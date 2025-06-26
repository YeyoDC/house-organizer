<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Services\RegisteredUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function login(LoginRequest $request)
    {
        $isMobile = $request->attributes->get('isMobile', false);
        $request->ensureIsNotRateLimited();
        $user = $this->auth->authenticate($request->email, $request->password);
        RateLimiter::clear($request->throttleKey());
        $token = $user->createToken('mobile-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }


    public function logout(Request $request)
    {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out']);
    }
}
