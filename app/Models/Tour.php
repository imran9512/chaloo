<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'name',
        'departure_city',
        'destinations',
        'departure_date',
        'arrival_date',
        'duration_days',
        'price_per_person',
        'price_per_couple',
        'description',
        'images',
        'optional_addons',
        'status',
    ];

    protected $casts = [
        'destinations' => 'array',
        'images' => 'array',
        'optional_addons' => 'array',
        'departure_date' => 'date',
        'arrival_date' => 'date',
        'price_per_person' => 'decimal:2',
        'price_per_couple' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper to get main destination (last city)
    public function getMainDestinationAttribute()
    {
        $destinations = $this->destinations;
        if (empty($destinations))
            return 'Unknown';
        $last = end($destinations);
        return $last['city'] ?? 'Unknown';
    }
}
