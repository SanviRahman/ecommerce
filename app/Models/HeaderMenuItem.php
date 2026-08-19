<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderMenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'header_menu_items';

    protected $fillable = [
        'label',
        'route_name',
        'custom_url',
        'sort_order',
        'open_new_tab',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'open_new_tab' => 'boolean',
            'status' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}