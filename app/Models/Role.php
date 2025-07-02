<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'permissions',
        'agency_id',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }

    public function hasAnyPermission($permissions)
    {
        if (!is_array($permissions)) {
            $permissions = [$permissions];
        }

        return !empty(array_intersect($permissions, $this->permissions ?? []));
    }

    
}
