<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'phone', 'email', 'city', 'password_hash', 
        'role', 'status', 'subscription_ends_at', 'listing_limit', 
        'credits', 'can_manage_transporters', 'can_manage_agents', 
        'can_manage_payments', 'can_manage_vehicle_types', 'can_manage_settings'
    ];

    protected $hidden = [
        'password_hash', 'remember_token',
    ];

    protected $casts = [
        'subscription_ends_at' => 'date',
        'listing_limit' => 'integer',
        'credits' => 'integer',
        'can_manage_transporters' => 'boolean',
        'can_manage_agents' => 'boolean',
        'can_manage_payments' => 'boolean',
        'can_manage_vehicle_types' => 'boolean',
        'can_manage_settings' => 'boolean',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }
}