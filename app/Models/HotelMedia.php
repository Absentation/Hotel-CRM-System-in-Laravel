<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HotelMedia extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'media_type',
        'file_path',
        'thumbnail_path',
        'is_published',
        'display_order',
        'description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (HotelMedia $media) {
            if (! $media->slug) {
                $base = Str::slug($media->title ?: uniqid('media'));
                $slug = $base;
                $counter = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$counter}";
                    $counter++;
                }
                $media->slug = $slug;
            }
        });
    }
}
