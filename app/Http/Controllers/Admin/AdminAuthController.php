<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if accessing Super Admin login
            if ($request->routeIs('super.admin.login.post')) {
                if ($user->role === 'admin') {
                    $request->session()->regenerate();
                    return redirect()->intended(route('admin.dashboard'));
                }
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Only Super Admins can log in here.',
                ]);
            }

            // Check if accessing Staff/Admin login
            if ($user->role === 'operator') {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            // If user is Admin but trying to login via standard route (since super.admin.login is handled above)
            if ($user->role === 'admin') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Security: Super Admins must use the secure login URL.',
                ]);
            }

            // User is not an admin/operator, log them out
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'You do not have permission to access the admin panel.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the admin out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
