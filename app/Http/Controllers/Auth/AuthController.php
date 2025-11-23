<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * Multi-role authentication: Login, register, logout with guards.
 * Session-based for shared hosting; redirects by role.
 */
class AuthController extends Controller
{
    /**
     * Show login form with role selection.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login: Multi-guard attempt.
     */
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required|in:transporter,agent'
    ]);

    $user = User::where('email', $request->email)
                ->where('role', $request->role)
                ->first();

    if ($user && Hash::check($request->password, $user->password_hash)) {
        Auth::guard($request->role)->login($user);
        //Auth::guard($user->getAuthGuardName())->login($user);
        
        return redirect()->intended(
            $request->role === 'transporter' ? '/transporter/dashboard' : '/agent/dashboard'
        );
    }

    return back()->withErrors(['email' => 'Invalid credentials or role']);
}

    /**
     * Show register form (role-specific).
     */
    public function showRegister(Request $request)
    {
        $role = $request->query('role', 'agent'); // Default to agent
        if (!in_array($role, ['transporter', 'agent'])) {
            abort(404);
        }
        return view('auth.register', compact('role'));
    }

    /**
     * Handle registration: Create user with role, send welcome email.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:transporter,agent'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active' // Enum
        ]);

        // Login immediately
        Auth::guard($request->role)->login($user);
        $request->session()->regenerate();

        // Welcome email
        $user->notify(new \App\Notifications\WelcomeNotification($user));

        return match ($request->role) {
            'transporter' => redirect('/transporter/dashboard'),
            'agent' => redirect('/agent/dashboard'),
            default => redirect('/')
        };
    }

    /**
     * Logout: Clear session by guard.
     */
    public function logout(Request $request)
    {
        $guardName = $request->user()->role ?? 'web';
        Auth::guard($guardName)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}