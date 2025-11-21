<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyListing extends Model
{
    protected $fillable = ['vehicle_id', 'markup_percentage', 'admin_approved'];

    protected $casts = [
        'markup_percentage' => 'decimal:2',
        'admin_approved' => 'boolean',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}