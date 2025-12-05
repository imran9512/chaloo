<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'company_name',
        'id_card_image',
        'id_card_back_image',
        'license_image',
        'license_back_image',
        'email',
        'phone',
        'city',
        'password',
        'role', // guest, transporter, agent, admin, operator
        'status', // active, suspended
        'operator_permissions', // JSON array
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'operator_permissions' => 'array',
    ];

    // Helper Methods
    public function isTransporter(): bool
    {
        return $this->role === 'transporter';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        if (!$this->isOperator()) {
            return false;
        }
        return in_array($permission, $this->operator_permissions ?? []);
    }

    // Relationships
    public function vehicles()
    {
        return $this->hasMany(\App\Models\Vehicle::class);
    }

    public function tours()
    {
        return $this->hasMany(\App\Models\Tour::class);
    }


}