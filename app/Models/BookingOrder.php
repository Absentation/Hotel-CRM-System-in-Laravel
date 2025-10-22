<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingOrder extends Model
{
    protected $fillable = [
        'booking_id',
        'request_id',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(FoodRequest::class);
    }
}
