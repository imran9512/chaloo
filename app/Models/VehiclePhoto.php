<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiclePhoto extends Model
{
    protected $fillable = ['vehicle_id', 'file_path', 'thumbnail_path', 'sort_order'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}