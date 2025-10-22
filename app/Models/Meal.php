<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meal extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(FoodRequest::class, 'meal_food_request')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
