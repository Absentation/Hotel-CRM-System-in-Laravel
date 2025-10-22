<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingAdditionalService extends Model
{
    protected $table = 'booking_additional_service';

    protected $fillable = [
        'booking_id',
        'service_id',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(AdditionalService::class, 'service_id');
    }
}
