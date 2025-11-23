<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset "broker" that gets used by your application.
    |
    | For Chaloo we don't use the default 'web' guard at all for logged-in users.
    | Instead we use role-specific guards (transporter, agent, admin, operator).
    |
    */
    'defaults' => [
        'guard' => 'web',                    // Keep 'web' as fallback for guests
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Chaloo uses a single User model with a "role" column.
    | We create separate session-based guards for each role so that:
    |   → Auth::guard('transporter')->user() works
    |   → middleware('auth:transporter') works perfectly
    |   → Routes can be protected by exact role
    |
    */
    'guards' => [
        // Guest / normal web visitors
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Transporter Guard
        'transporter' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Agent Guard
        'agent' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Admin Guard (used by both super_admin and operator)
        // Operators share the same guard but have granular permissions inside controllers
        'admin' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Optional: separate guard only for super_admin (if you ever need it)
        // 'super_admin' => [
        //     'driver'   => 'session',
        //     'provider' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All guards use the same Eloquent User model.
    | We filter the correct user by the "role" column inside the AuthController.
    |
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        // If you ever switch to database driver (not needed):
        // 'users' => [
        //     'driver' => 'database',
        //     'table'  => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Standard Laravel password reset – works for all roles because they share
    | the same users table.
    |
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',        // Laravel 9+ default table
            'expire'   => 60,   // Token valid for 60 minutes (as per spec)
            'throttle' => 60,   // Prevent spamming reset requests
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | How long (in seconds) the "confirm password" screen stays valid.
    | Default = 3 hours (10800 seconds)
    |
    */
    'password_timeout' => 10800,

    /*
    |--------------------------------------------------------------------------
    | Custom Chaloo Settings (Optional but Helpful)
    |--------------------------------------------------------------------------
    */
    // You can add custom keys if you want to reference them in code
    'chaloo' => [
        'roles' => [
            'transporter' => 'transporter',
            'agent'       => 'agent',
            'super_admin' => 'super_admin',
            'operator'    => 'operator',
        ],
    ],

];