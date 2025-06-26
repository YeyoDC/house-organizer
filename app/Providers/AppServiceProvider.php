<?php

namespace App\Providers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use function Psy\debug;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('smart', function (Request $request, Closure $webResponse, array $options = []) {
            // checks if it's a mobile request
//            $isMobile = $request->attributes->get('is_mobile', false);
            if ($request->header('X-Client-Type') === 'mobile') {
                $user = Auth::user();

                // Determine if this is a login or register action
                $isLoginOrRegister = str($request->route()?->getName())->contains(['login', 'register']);

                $data = $options['data'] ?? [];

                // Auto-generate token only for login/register routes
                if ($isLoginOrRegister && $user) {
                    $data['token'] = $user->createToken('mobile-token')->plainTextToken;
                    $data['user'] = $user;
                }

                return response()->json([
                    'success' => $options['success'] ?? true,
                    'message' => $options['message'] ?? null,
                    'data' => $data,
                ], $options['status'] ?? 200);
            }
            else{
                // Default web response
                return $webResponse();
            }


        });

    }
}
