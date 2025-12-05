<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_type_id',
        'name',
        'brand',
        'model',
        'year',
        'registration_number',
        'color',
        'daily_rate',
        'driver_fee',
        'city',
        'description',
        'features',
        'images',
        'status', // available, booked, maintenance
        'available_from_date',
        'is_approved',
        'is_company_managed',
        'commission_percentage',
        'base_daily_rate',
    ];

    protected $casts = [
        'year' => 'integer',
        'daily_rate' => 'decimal:2',
        'driver_fee' => 'decimal:2',
        'features' => 'array',
        'images' => 'array',
        'available_from_date' => 'date',
        'is_approved' => 'boolean',
        'is_company_managed' => 'boolean',
        'commission_percentage' => 'decimal:2',
        'base_daily_rate' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}