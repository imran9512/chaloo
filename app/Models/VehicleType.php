<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = ['name', 'slug'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}