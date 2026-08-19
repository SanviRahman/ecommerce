<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'specifications',
        'is_featured',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'status' => 'boolean',
            'sort_order' => 'integer',
            'specifications' => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')->useDisk('public')->singleFile();
        $this->addMediaCollection('gallery')->useDisk('public');
        $this->addMediaCollection('data_sheet')->useDisk('public')->singleFile();
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('featured_image') ?: null;
    }

    public function getDataSheetUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('data_sheet') ?: null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}