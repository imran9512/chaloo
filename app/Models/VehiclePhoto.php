<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclePhoto extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'path', 'is_thumbnail', 'sort_order'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}