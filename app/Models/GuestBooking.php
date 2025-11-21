<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestBooking extends Model
{
    protected $fillable = [
        'guest_lead_id', 'vehicle_id', 'booking_dates', 
        'total_fare', 'payment_proof_path', 'status'
    ];

    protected $casts = [
        'total_fare' => 'decimal:2',
        'status' => 'string',
    ];

    public function guestLead()
    {
        return $this->belongsTo(GuestLead::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}