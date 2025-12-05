<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    protected $fillable = [
        'user_id',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Available permissions with hierarchy
    public static function availablePermissions(): array
    {
        return [
            'view_users' => [
                'label' => 'View Users',
                'children' => [
                    'view_users_transporters' => 'View Transporters',
                    'view_users_agents' => 'View Agents',
                    'view_users_staff' => 'View Staff',
                ]
            ],
            'edit_users' => [
                'label' => 'Edit Users',
                'children' => [
                    'edit_users_transporters' => 'Edit Transporters',
                    'edit_users_agents' => 'Edit Agents',
                    'edit_users_staff' => 'Edit Staff',
                ]
            ],
            'delete_users' => [
                'label' => 'Delete Users',
                'children' => [
                    'delete_users_transporters' => 'Delete Transporters',
                    'delete_users_agents' => 'Delete Agents',
                    'delete_users_staff' => 'Delete Staff',
                ]
            ],
            'manage_vehicle_types' => [
                'label' => 'Manage Vehicle Types',
                'children' => []
            ],
            'manage_vehicles' => [
                'label' => 'Manage Public Vehicles',
                'children' => []
            ],
            'manage_approvals' => [
                'label' => 'Manage Approvals',
                'children' => [
                    'manage_approvals_transporters_view' => 'View Transporter Approvals',
                    'manage_approvals_transporters_edit' => 'Edit Transporter Approvals',
                    'manage_approvals_agents_view' => 'View Agent Approvals',
                    'manage_approvals_agents_edit' => 'Edit Agent Approvals',
                ]
            ],
            'view_reports' => [
                'label' => 'View Reports',
                'children' => []
            ],
            'manage_packages' => [
                'label' => 'Manage Packages',
                'children' => [
                    'manage_packages_assign' => 'Assign Packages to Users',
                    'manage_packages_edit' => 'Create/Edit Package Plans',
                ]
            ],
        ];
    }

    // Get flat list of all permission slugs
    public static function allPermissionSlugs(): array
    {
        $slugs = [];
        foreach (self::availablePermissions() as $parentSlug => $data) {
            $slugs[] = $parentSlug;
            if (!empty($data['children'])) {
                $slugs = array_merge($slugs, array_keys($data['children']));
            }
        }
        return $slugs;
    }

    // Permission Groups/Templates
    public static function permissionGroups(): array
    {
        return [
            'manager' => [
                'label' => 'Manager (Full Access)',
                'permissions' => [
                    'view_users',
                    'view_users_transporters',
                    'view_users_agents',
                    'view_users_staff',
                    'edit_users',
                    'edit_users_transporters',
                    'edit_users_agents',
                    'edit_users_staff',
                    'delete_users',
                    'delete_users_transporters',
                    'delete_users_agents',
                    'delete_users_staff',
                    'manage_vehicle_types',
                    'manage_vehicles',
                    'manage_approvals',
                    'manage_approvals_transporters_view',
                    'manage_approvals_transporters_edit',
                    'manage_approvals_agents_view',
                    'manage_approvals_agents_edit',
                    'view_reports',
                    'manage_packages',
                    'manage_packages_assign',
                    'manage_packages_edit',
                ]
            ],
            'support_staff' => [
                'label' => 'Support Staff',
                'permissions' => [
                    'view_users',
                    'view_users_transporters',
                    'view_users_agents',
                    'manage_approvals',
                    'manage_approvals_transporters_view',
                    'manage_approvals_transporters_edit',
                    'manage_approvals_agents_view',
                    'manage_approvals_agents_edit',
                ]
            ],
            'data_entry' => [
                'label' => 'Data Entry',
                'permissions' => [
                    'view_users',
                    'view_users_transporters',
                    'view_users_agents',
                    'edit_users',
                    'edit_users_transporters',
                    'edit_users_agents',
                    'manage_vehicle_types',
                    'manage_vehicles',
                ]
            ],
            'viewer' => [
                'label' => 'Viewer (Read Only)',
                'permissions' => [
                    'view_users',
                    'view_users_transporters',
                    'view_users_agents',
                    'view_users_staff',
                    'view_reports',
                ]
            ],
        ];
    }
}
