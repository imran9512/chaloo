<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestLead extends Model
{
    protected $fillable = ['name', 'phone', 'city', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public function bookings()
    {
        return $this->hasMany(GuestBooking::class);
    }
}