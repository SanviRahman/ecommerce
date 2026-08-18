<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements HasMedia
{
    use HasFactory, HasRoles, InteractsWithMedia, Notifiable, SoftDeletes;

    protected $table = 'admins';

    protected string $guard_name = 'admin';

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'status',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'status' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function adminLogs(): HasMany
    {
        return $this->hasMany(AdminLog::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')->singleFile();
    }

    public function adminlte_profile_url(): string
    {
        return route('admin.profile');
    }

    public function adminlte_image(): string
    {
        return $this->image_url;
    }

    public function adminlte_desc(): string
    {
        return $this->email;
    }

    public function getImageUrlAttribute(): string
    {
        if ($media = $this->getFirstMedia('avatars')) {
            return $media->getUrl();
        }

        if ($this->photo) {
            return asset('storage/' . ltrim($this->photo, '/'));
        }

        $name = urlencode($this->name ?: 'Admin');

        return "https://ui-avatars.com/api/?name={$name}&background=random&color=fff&size=128";
    }
}