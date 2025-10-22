<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealFoodRequest extends Model
{
    protected $table = 'meal_food_request';

    protected $fillable = [
        'meal_id',
        'request_id',
        'quantity',
    ];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(FoodRequest::class, 'request_id');
    }
}
