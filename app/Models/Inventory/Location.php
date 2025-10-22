<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $table = 'inventory_locations';

    protected $fillable = [
        'name',
        'slug',
        'location_type',
        'area',
        'description',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
