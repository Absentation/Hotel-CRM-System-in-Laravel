<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'booking_date',
        'check_in_date',
        'expected_check_out',
        'check_out_date',
        'special_request',
        'customer_id',
        'room_id',
        'employee_id',
        'username',
        'password',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'check_in_date' => 'date',
        'expected_check_out' => 'date',
        'check_out_date' => 'date',
    ];

    protected $hidden = [
        'password',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function additionalServices(): BelongsToMany
    {
        return $this->belongsToMany(AdditionalService::class, 'booking_additional_service')
            ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(BookingOrder::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'customer_id', 'customer_id');
    }
}
