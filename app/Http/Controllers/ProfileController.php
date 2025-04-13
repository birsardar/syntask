<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        $user->update($validated);

        return back()->with('status', 'Profile updated successfully!');
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The password is incorrect.');
                }
            }],
        ]);

        $user->update([
            'email' => $validated['email'],
        ]);

        return back()->with('status', 'Email updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Password updated successfully!');
    }

    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        if ($user->profile_photo) {
            Storage::delete('public/' . $user->profile_photo);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->update([
            'profile_photo' => $path,
        ]);

        return back()->with('status', 'Profile photo updated successfully!');
    }

    public function show2FA()
    {
        return view('profile.2fa', [
            'user' => Auth::user(),
        ]);
    }

    public function toggle2FA(Request $request)
    {
        $user = Auth::user();

        // Basic implementation - in a real app, you'd generate and store 2FA secrets
        $user->update([
            'two_factor_enabled' => !$user->two_factor_enabled,
            'two_factor_secret' => $user->two_factor_enabled ? null : Str::random(40),
        ]);

        $status = $user->two_factor_enabled
            ? 'Two-factor authentication enabled!'
            : 'Two-factor authentication disabled!';

        return back()->with('status', $status);
    }

    public function confirm2FA(Request $request)
    {
        // This is a placeholder for actual 2FA confirmation
        // In a real app, you'd validate the 2FA code here

        return back()->with('status', '2FA confirmed successfully!');
    }
}
