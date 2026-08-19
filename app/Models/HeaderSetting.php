<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'header_settings';

    protected $fillable = [
        'topbar_enabled',
        'topbar_text',
        'show_phone',
        'show_email',
        'cta_enabled',
        'cta_label',
        'cta_url',
    ];

    protected function casts(): array
    {
        return [
            'topbar_enabled' => 'boolean',
            'show_phone' => 'boolean',
            'show_email' => 'boolean',
            'cta_enabled' => 'boolean',
        ];
    }

    public static function current(): self
    {
        $headerSetting = static::withTrashed()->firstOrCreate(
            ['id' => 1],
            [
                'topbar_enabled' => true,
                'show_phone' => true,
                'show_email' => true,
                'cta_enabled' => false,
            ]
        );

        if ($headerSetting->trashed()) {
            $headerSetting->restore();
        }

        return $headerSetting;
    }
}