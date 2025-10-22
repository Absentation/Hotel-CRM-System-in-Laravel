<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $table = 'inventory_stocks';

    protected $fillable = [
        'item_id',
        'location_id',
        'quantity_on_hand',
        'quantity_reserved',
        'quantity_available',
        'last_audited_at',
    ];

    protected $casts = [
        'quantity_on_hand' => 'decimal:3',
        'quantity_reserved' => 'decimal:3',
        'quantity_available' => 'decimal:3',
        'last_audited_at' => 'datetime',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
