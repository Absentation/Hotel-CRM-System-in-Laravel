<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodRequest extends Model
{
    protected $fillable = [
        'ordering_date',
        'special_request',
    ];

    protected $casts = [
        'ordering_date' => 'datetime',
    ];

    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_food_request')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function bookingOrders(): HasMany
    {
        return $this->hasMany(BookingOrder::class, 'request_id');
    }
}
