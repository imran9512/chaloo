<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\PasswordResetMail; // Assume Mail class; create if needed
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Controller for password reset functionality.
 * Follows Laravel auth patterns with multi-role support.
 */
class PasswordResetController extends Controller
{
    /**
     * Display forgot password form.
     */
    public function forgot()
    {
        return view('auth.forgot-password'); // Blade view with form
    }

    /**
     * Handle forgot password request: Send reset email.
     * Validates email, creates token, sends via configurable template.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(60);
        $user->update([
            'password_reset_token' => $token,
            'password_reset_expires_at' => Carbon::now()->addMinutes(60)
        ]);

        // Use admin-configurable template variables
        $resetLink = url(route('password.reset', $token));
        $expiryTime = Carbon::now()->addMinutes(60)->format('Y-m-d H:i:s');
        Mail::to($user)->send(new PasswordResetMail([
            'user_name' => $user->name,
            'reset_link' => $resetLink,
            'app_name' => config('app.name'),
            'expiry_time' => $expiryTime
        ]));

        return back()->with('status', 'Reset link sent to your email.');
    }

    /**
     * Display reset password form with token.
     */
    public function reset($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    /**
     * Handle password reset: Validate token expiry, update password.
     */
    public function updatePassword(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::where([
            'email' => $request->email,
            'password_reset_token' => $token,
            'password_reset_expires_at' => '>', Carbon::now()
        ])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'password_reset_token' => null,
            'password_reset_expires_at' => null,
        ])->save();

        return redirect(route('login'))->with('status', 'Password reset successfully.');
    }
}