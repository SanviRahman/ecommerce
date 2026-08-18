<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guard_name',
        'group_name',
    ];

    /**
     * Scope a query to filter permissions by guard name.
     */
    public function scopeByGuard($query, string $guardName)
    {
        return $query->where('guard_name', $guardName);
    }

    /**
     * Scope a query to filter permissions by group name.
     */
    public function scopeByGroup($query, string $groupName)
    {
        return $query->where('group_name', $groupName);
    }
}
