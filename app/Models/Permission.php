<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'display_name',
    ];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }
}
