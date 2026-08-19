<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\HeaderMenuItem;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $superAdmin = Role::withTrashed()
            ->where('name', 'super_admin')
            ->where('guard_name', 'admin')
            ->first();

        if (! $superAdmin) {
            $superAdmin = Role::create([
                'name' => 'super_admin',
                'guard_name' => 'admin',
            ]);
        } elseif ($superAdmin->trashed()) {
            $superAdmin->restore();
        }

        $admin = Admin::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'username' => 'admin',
                'phone' => '01700000000',
                'status' => true,
                'password' => Hash::make('password'),
            ]
        );

        $permissions = [
            [
                'group_name' => 'Global Settings',
                'guard_name' => 'admin',
                'permissions' => [
                    'dashboard_manage',
                    'media_manage',
                    'settings',
                    'system_tools',
                ],
            ],
            [
                'group_name' => 'Site Settings',
                'guard_name' => 'admin',
                'permissions' => [
                    'identity_settings',
                ],
            ],
            [
                'group_name' => 'Header Settings',
                'guard_name' => 'admin',
                'permissions' => [
                    'header_settings',
                ],
            ],
            [
                'group_name' => 'Header Menu',
                'guard_name' => 'admin',
                'permissions' => [
                    'header_menu_manage',
                ],
            ],
            [
                'group_name' => 'Roles',
                'guard_name' => 'admin',
                'permissions' => [
                    'role_manage',
                    'role_list',
                    'role_view',
                    'role_create',
                    'role_update',
                    'role_delete',
                    'role_trash',
                    'role_restore',
                    'role_force_delete',
                ],
            ],
            [
                'group_name' => 'Permission',
                'guard_name' => 'admin',
                'permissions' => [
                    'permission_manage',
                    'permission_list',
                    'permission_view',
                    'permission_create',
                    'permission_update',
                    'permission_delete',
                    'permission_trash',
                    'permission_restore',
                    'permission_force_delete',
                ],
            ],
            [
                'group_name' => 'Admin',
                'guard_name' => 'admin',
                'permissions' => [
                    'admin_manage',
                    'admin_list',
                    'admin_view',
                    'admin_create',
                    'admin_update',
                    'admin_delete',
                    'admin_trash',
                    'admin_restore',
                    'admin_force_delete',
                ],
            ],
        ];

        $permissionModels = collect();

        foreach ($permissions as $group) {
            foreach ($group['permissions'] as $permissionName) {
                $permission = Permission::withTrashed()
                    ->where('name', $permissionName)
                    ->where('guard_name', $group['guard_name'])
                    ->first();

                if (! $permission) {
                    $permission = Permission::create([
                        'name' => $permissionName,
                        'guard_name' => $group['guard_name'],
                        'group_name' => $group['group_name'],
                    ]);
                } else {
                    if ($permission->trashed()) {
                        $permission->restore();
                    }

                    if ($permission->group_name !== $group['group_name']) {
                        $permission->update([
                            'group_name' => $group['group_name'],
                        ]);
                    }
                }

                $permissionModels->push($permission);
            }
        }

        $superAdmin->syncPermissions($permissionModels);

        $admin->syncRoles([$superAdmin]);

        // Seed Default Header Menu Items
        $defaultMenuItems = [
            ['label' => 'Home', 'route_name' => 'home', 'sort_order' => 1, 'status' => true],
            ['label' => 'Services', 'route_name' => 'services.index', 'sort_order' => 2, 'status' => true],
            ['label' => 'About', 'route_name' => 'about.index', 'sort_order' => 3, 'status' => true],
            ['label' => 'Products', 'route_name' => 'products.index', 'sort_order' => 4, 'status' => true],
            ['label' => 'Contact Us', 'route_name' => 'contact.index', 'sort_order' => 5, 'status' => true],
        ];

        foreach ($defaultMenuItems as $item) {
            HeaderMenuItem::firstOrCreate(['label' => $item['label']], $item);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}