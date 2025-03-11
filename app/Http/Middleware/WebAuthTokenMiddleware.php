<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;

class WebAuthTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //  first,i try to get the token either from the Authorization header or the session
        $token = $request->bearerToken() ?? Session::get('auth_token');

        //  If no token is found, redirect the user to the login page with an error message
        if (!$token) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        // Attempt to find the token in the database using Laravel Sanctum
        $accessToken = PersonalAccessToken::findToken($token);

        //  If the token is invalid or does not belong to a user, redirect to login
        if (!$accessToken || !$accessToken->tokenable) {
            return redirect()->route('login')->with('error', 'Session expired, please log in again.');
        }

        auth()->login($accessToken->tokenable);

        return $next($request);
    }
}
