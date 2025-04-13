<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // If 2FA is enabled but not verified for this session
        if ($user && $user->two_factor_enabled && !session('two_factor_verified')) {
            // Store the intended URL to redirect back after 2FA verification
            session(['intended_url' => $request->url()]);

            return redirect()->route('2fa.challenge');
        }

        return $next($request);
    }
}
