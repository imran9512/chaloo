<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id', 'vehicle_type_id', 'seats', 'ac_status', 'city', 
        'base_rate', 'driver_rate', 'condition', 'status', 
        'available_in_days', 'special_notes', 'managed_by'
    ];

    protected $casts = [
        'ac_status' => 'boolean',
        'base_rate' => 'decimal:2',
        'driver_rate' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function photos()
    {
        return $this->hasMany(VehiclePhoto::class);
    }

    public function companyListing()
    {
        return $this->hasOne(CompanyListing::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}