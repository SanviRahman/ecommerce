<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FooterSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'footer_settings';

    protected $fillable = [
        'about_heading',
        'about_text',
        'navigation_heading',
        'products_heading',
        'contact_heading',
        'copyright_text',
    ];

    public static function current(): self
    {
        $footerSetting = static::withTrashed()
            ->orderByRaw("
                CASE
                    WHEN about_text IS NULL OR TRIM(about_text) = '' THEN 1
                    ELSE 0
                END
            ")
            ->orderByRaw("
                CASE
                    WHEN copyright_text IS NULL OR TRIM(copyright_text) = '' THEN 1
                    ELSE 0
                END
            ")
            ->orderByDesc('updated_at')
            ->first();

        if (! $footerSetting) {
            $footerSetting = static::create([
                'about_heading' => 'About Us',
                'navigation_heading' => 'Navigate',
                'products_heading' => 'Our Products',
                'contact_heading' => 'Our Showroom',
            ]);
        }

        if ($footerSetting->trashed()) {
            $footerSetting->restore();
        }

        return $footerSetting;
    }
}
