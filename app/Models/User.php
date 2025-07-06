<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UserPermissions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UserPermissions;

    /**
     * User type constants
     */
    public const USER_TYPES = [
        'super_admin' => 'super_admin',
        'agency_admin' => 'agency_admin',
        'agency_user' => 'agency_user'
    ];

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

    /**
     * Relationship: User belongs to an Agency
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Relationship: User belongs to a Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relationship: User belongs to a Position
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Relationship: User belongs to a Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Check if user has any of the given permissions
     *
     * @param array|string $permissions Single permission or array of permissions
     * @return bool
     */
    public function hasAnyPermission($permissions)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->role && $this->role->hasAnyPermission($permissions);
    }

    /**
     * Check if user has a specific permission
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->role && $this->role->hasPermission($permission);
    }

    /**
     * Check if user can manage an agency
     *
     * @param int|null $agencyId Specific agency ID to check (optional)
     * @return bool
     */
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

    /**
     * Scope: Only active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the user's full type name
     */
    public function getTypeNameAttribute(): string
    {
        return match($this->user_type) {
            self::USER_TYPES['super_admin'] => 'Super Administrator',
            self::USER_TYPES['agency_admin'] => 'Agency Administrator',
            self::USER_TYPES['agency_user'] => 'Agency User',
            default => 'Unknown'
        };
    }
}
