<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdditionalService extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_additional_service', 'service_id')
            ->withTimestamps();
    }
}
