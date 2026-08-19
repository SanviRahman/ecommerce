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
        $footerSetting = static::withTrashed()->firstOrCreate(
            ['id' => 1],
            [
                'about_heading' => 'About Us',
                'navigation_heading' => 'Navigate',
                'products_heading' => 'Our Products',
                'contact_heading' => 'Our Showroom',
            ]
        );

        if ($footerSetting->trashed()) {
            $footerSetting->restore();
        }

        return $footerSetting;
    }
}