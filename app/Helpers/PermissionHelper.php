<?php

namespace App\Helpers;

use App\Models\Permission;
use App\Models\User;

class PermissionHelper
{
    /**
     * Check if user has a specific permission
     * Also checks parent permissions (e.g., if has 'edit_users', also has 'edit_users_transporters')
     */
    public static function hasPermission(User $user, string $permission): bool
    {
        // Admin has all permissions
        if ($user->role === 'admin') {
            return true;
        }

        // Only operators have permissions
        if ($user->role !== 'operator') {
            return false;
        }

        $userPermissions = Permission::where('user_id', $user->id)->first();

        if (!$userPermissions || !$userPermissions->permissions) {
            return false;
        }

        $grantedPermissions = $userPermissions->permissions;

        // Direct permission check
        if (in_array($permission, $grantedPermissions)) {
            return true;
        }

        // Check if parent permission is granted
        // e.g., if checking 'edit_users_transporters', check if 'edit_users' is granted
        foreach ($grantedPermissions as $granted) {
            if (str_starts_with($permission, $granted . '_')) {
                return true;
            }
        }

        // Check if user has edit permission (edit implies view)
        // e.g., if has 'edit_users_transporters', also has 'view_users_transporters'
        $editVersion = str_replace('view_', 'edit_', $permission);
        if ($editVersion !== $permission && in_array($editVersion, $grantedPermissions)) {
            return true;
        }

        // Check parent edit permission
        foreach ($grantedPermissions as $granted) {
            $editVersion = str_replace('view_', 'edit_', $permission);
            if (str_starts_with($editVersion, $granted . '_')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all permissions for a user
     */
    public static function getPermissions(User $user): array
    {
        // Admin has all permissions
        if ($user->role === 'admin') {
            return Permission::allPermissionSlugs();
        }

        $userPermissions = Permission::where('user_id', $user->id)->first();

        return $userPermissions->permissions ?? [];
    }

    /**
     * Set permissions for a user
     */
    public static function setPermissions(User $user, array $permissions): void
    {
        Permission::updateOrCreate(
            ['user_id' => $user->id],
            ['permissions' => $permissions]
        );
    }
}
