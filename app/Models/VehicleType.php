<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'capacity',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'capacity' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}