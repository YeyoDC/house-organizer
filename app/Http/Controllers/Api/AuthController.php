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

        // Detect if the client is mobile or web
       // e.g. 'mobile' or 'web'

        if ($isMobile) {
            $token = $user->createToken('mobile-token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }
        else{
            // Session-based login (web)
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }



    }


    public function logout(Request $request)
    {
        $clientType = $request->header('X-Client-Type');
        if ($clientType === 'mobile') {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out']);
        }
        else{
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login');
        }

    }
}
