<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $table = 'inventory_items';

    protected $fillable = [
        'name',
        'sku',
        'unit',
        'unit_cost',
        'reorder_level',
        'track_quantity',
        'is_active',
        'category_id',
        'location_id',
        'description',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'track_quantity' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
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
