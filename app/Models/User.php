<?php

namespace App\Models;

// ---------------------------------------------------------------------
// IMPORTANT TRAITS
// ---------------------------------------------------------------------
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // =================================================================
    // MASS ASSIGNABLE FIELDS
    // =================================================================
    protected $fillable = [
        'name',
        'phone',
        'email',
        'city',
        'password_hash',           // hum custom column use kar rahe hain
        'role',                    // transporter | agent | super_admin | operator
        'status',                  // active | suspended | pending
        'subscription_ends_at',
        'listing_limit',           // kitne vehicles list kar sakta hai
        'credits',                 // future monetization ke liye
        // Operator permissions (boolean)
        'can_manage_transporters',
        'can_manage_agents',
        'can_manage_payments',
        'can_manage_vehicle_types',
        'can_manage_settings',
    ];

    // =================================================================
    // HIDDEN FIELDS (API / JSON response mein nahi dikhenge)
    // =================================================================
    protected $hidden = [
        'password_hash',
        'remember_token',
        'password_reset_token',
        'password_reset_expires_at',
    ];

    // =================================================================
    // CASTING (proper data types)
    // =================================================================
    protected $casts = [
        'subscription_ends_at'    => 'date',
        'listing_limit'           => 'integer',
        'credits'                 => 'integer',

        // Operator boolean permissions
        'can_manage_transporters' => 'boolean',
        'can_manage_agents'       => 'boolean',
        'can_manage_payments'     => 'boolean',
        'can_manage_vehicle_types'=> 'boolean',
        'can_manage_settings'     => 'boolean',
    ];

    // =================================================================
    // PASSWORD MUTATOR (Laravel expects 'password', hum 'password_hash' use kar rahe hain)
    // =================================================================
    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }

    // Optional: Agar kahin $user->password likha ho to bhi kaam kare
    public function getPasswordAttribute()
    {
        return $this->password_hash;
    }

    // =================================================================
    // CUSTOM HELPER METHODS (Multi-role Guard ke liye ZAROORI)
    // =================================================================
    /**
     * Return correct guard name based on user role
     * Used in AuthController@login() and middleware
     */
    public function getAuthGuardName(): string
    {
        return match ($this->role) {
            'transporter' => 'transporter',
            'agent'       => 'agent',
            'super_admin',
            'operator'    => 'admin',           // dono admin guard use karenge
            default       => 'web',
        };
    }

    // Role checking helpers (optional lekin bohot kaam aate hain)
    public function isTransporter(): bool { return $this->role === 'transporter'; }
    public function isAgent(): bool       { return $this->role === 'agent'; }
    public function isAdmin(): bool       { return in_array($this->role, ['super_admin', 'operator']); }
    public function isSuperAdmin(): bool  { return $this->role === 'super_admin'; }

    // =================================================================
    // RELATIONSHIPS (tumhare existing + thodi improvement)
    // =================================================================
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    // Favorites: Agent → Vehicles (N:N pivot)
    public function favorites()
    {
        return $this->belongsToMany(Vehicle::class, 'favorites', 'agent_id', 'vehicle_id')
                    ->withTimestamps();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'agent_id'); // ya transporter_id — jaisa table ho
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    // Optional: Payments, subscriptions, etc.
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
}