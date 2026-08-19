<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SiteSetting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $table = 'site_settings';

    protected $fillable = [
        'site_name',
        'logo_alt',
        'contact_phone',
        'contact_email',
        'whatsapp_url',
        'address',
        'business_hours',
        'map_embed_url',
    ];

    public static function current(): self
    {
        $siteSetting = static::withTrashed()->firstOrCreate(
            ['id' => 1],
            ['site_name' => 'Flooring Website']
        );

        if ($siteSetting->trashed()) {
            $siteSetting->restore();
        }

        return $siteSetting;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->useDisk('public')->singleFile();
        $this->addMediaCollection('favicon')->useDisk('public')->singleFile();
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo') ?: null;
    }

    public function getFaviconUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('favicon') ?: null;
    }
}