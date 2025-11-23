<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Agar koi bhi guard logged-in hai to redirect kar do
                return redirect($this->redirectTo($guard));
            }
        }

        return $next($request);
    }

    protected function redirectTo($guard)
    {
        return match ($guard) {
            'transporter' => '/transporter/dashboard',
            'agent'       => '/agent/dashboard',
            'admin'       => '/admin/dashboard',
            default       => RouteServiceProvider::HOME,
        };
    }
}