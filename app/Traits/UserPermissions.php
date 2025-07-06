<?php

namespace App\Traits;

use App\Models\DynamicList;
use App\Models\User;

trait UserPermissions
{
    /**
     * Check if user is a super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->user_type === User::USER_TYPES['super_admin'];
    }

    /**
     * Check if user is an agency admin
     */
    public function isAgencyAdmin(): bool
    {
        return $this->user_type === User::USER_TYPES['agency_admin'];
    }

    /**
     * Check if user is a regular agency user
     */
    public function isAgencyUser(): bool
    {
        return $this->user_type === User::USER_TYPES['agency_user'];
    }

    /**
     * Determine if user can edit a specific dynamic list
     *
     * @param DynamicList $list The list to check permissions for
     * @return bool True if user has edit permissions, false otherwise
     */
    public function canEditList(DynamicList $list): bool
    {
        // Super admins can edit any list
        if ($this->isSuperAdmin()) {
            return true;
        }

        // For non-system lists, check agency ownership
        if (!$list->is_system) {
            return $this->agency_id === $list->agency_id;
        }

        // System lists can only be edited by super admins
        return false;
    }

    /**
     * Check if user has any admin privileges (super admin or agency admin)
     */
    public function isAdmin(): bool
    {
        return $this->isSuperAdmin() || $this->isAgencyAdmin();
    }

    /**
     * Check if user can view a specific dynamic list
     *
     * @param DynamicList $list The list to check view permissions for
     * @return bool True if user can view the list
     */
    public function canViewList(DynamicList $list): bool
    {
        // All users can view system lists
        if ($list->is_system) {
            return true;
        }

        // For agency lists, check if user belongs to same agency
        return $this->agency_id === $list->agency_id;
    }
}
