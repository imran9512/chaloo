<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPackage extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'is_custom',
        'listing_limit',
        'price_paid',
        'started_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'is_custom' => 'boolean',
        'price_paid' => 'decimal:2',
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    // Check if package is active and not expired
    public function isActive(): bool
    {
        return $this->status === 'active' &&
            ($this->expires_at === null || $this->expires_at->isFuture());
    }

    // Get remaining listings
    public function getRemainingListings(): int
    {
        $used = $this->user->vehicles()->count() + $this->user->tours()->count();
        return max(0, $this->listing_limit - $used);
    }
}
