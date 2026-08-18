<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'guard_name',
        'group_name',
    ];

    public function scopeByGuard(Builder $query, string $guardName): Builder
    {
        return $query->where('guard_name', $guardName);
    }

    public function scopeByGroup(Builder $query, string $groupName): Builder
    {
        return $query->where('group_name', $groupName);
    }
}