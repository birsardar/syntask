<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthController extends Controller
{
    /**
     * Show the 2FA challenge page.
     */
    public function showChallenge()
    {
        return view('auth.2fa-challenge');
    }

    /**
     * Verify the 2FA code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        // In a real implementation, you would verify the code against the user's 2FA secret
        // For this demo, we'll just accept any 6-digit code
        if (strlen($request->code) == 6 && is_numeric($request->code)) {
            // Mark the session as 2FA verified
            session(['two_factor_verified' => true]);

            // Redirect to the originally intended URL or dashboard
            $redirectTo = session('intended_url', route('dashboard'));
            session()->forget('intended_url');

            return redirect($redirectTo)->with('status', 'Two-factor authentication verified.');
        }

        return back()->withErrors([
            'code' => 'The verification code is invalid.',
        ]);
    }
}
