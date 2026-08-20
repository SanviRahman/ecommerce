<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetaPixelScript extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'meta_pixel_scripts';

    protected $fillable = [
        'name',
        'placement',
        'script_code',
        'code_hash',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('script_code')) {
                $model->code_hash = hash('sha256', trim($model->script_code));
            }
        });

        static::creating(function ($model) {
            if (auth('admin')->check()) {
                $model->created_by = auth('admin')->id();
            }
        });

        static::updating(function ($model) {
            if (auth('admin')->check()) {
                $model->updated_by = auth('admin')->id();
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}