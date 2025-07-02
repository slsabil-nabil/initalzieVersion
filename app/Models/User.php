<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'agency_id',
        'role_id',
        'user_type',
        'is_active',
        'last_login_at',
        'department_id',
        'position_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public const USER_TYPES = [
        'super_admin' => 'super_admin',
        'agency_admin' => 'agency_admin',
        'agency_user' => 'agency_user'
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->user_type === self::USER_TYPES['super_admin'];
    }

    public function isAgencyAdmin(): bool
    {
        return $this->user_type === self::USER_TYPES['agency_admin'];
    }

    public function isAgencyUser(): bool
    {
        return $this->user_type === self::USER_TYPES['agency_user'];
    }

    public function hasAnyPermission($permissions)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->role && $this->role->hasAnyPermission($permissions);
    }

    public function canManageAgency($agencyId = null)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->isAgencyAdmin()) {
            return $agencyId ? $this->agency_id == $agencyId : true;
        }

        return false;
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function hasPermission($permission)
{
    if ($this->isSuperAdmin()) {
        return true;
    }

    return $this->role && $this->role->hasPermission($permission);
}

}
