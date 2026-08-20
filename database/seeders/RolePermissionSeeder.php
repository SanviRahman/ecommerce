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
                'name'       => 'super_admin',
                'guard_name' => 'admin',
            ]);
        } elseif ($superAdmin->trashed()) {
            $superAdmin->restore();
        }

        $admin = Admin::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'username' => 'admin',
                'phone'    => '01700000000',
                'status'   => true,
                'password' => Hash::make('password'),
            ]
        );

        $permissions = [
            [
                'group_name'  => 'Global Settings',
                'guard_name'  => 'admin',
                'permissions' => [
                    'dashboard_manage',
                    'media_manage',
                    'settings',
                    'system_tools',
                ],
            ],
            [
                'group_name'  => 'Site Settings',
                'guard_name'  => 'admin',
                'permissions' => [
                    'site_setting_manage',
                    'site_setting_list',
                    'site_setting_view',
                    'site_setting_create',
                    'site_setting_update',
                    'site_setting_delete',
                    'site_setting_trash',
                    'site_setting_restore',
                    'site_setting_force_delete',
                ],
            ],
            [
                'group_name'  => 'Header Settings',
                'guard_name'  => 'admin',
                'permissions' => [
                    'header_setting_manage',
                    'header_setting_list',
                    'header_setting_view',
                    'header_setting_create',
                    'header_setting_update',
                    'header_setting_delete',
                    'header_setting_trash',
                    'header_setting_restore',
                    'header_setting_force_delete',
                ],
            ],
            [
                'group_name'  => 'Header Menu',
                'guard_name'  => 'admin',
                'permissions' => [
                    'header_menu_manage',
                    'header_menu_list',
                    'header_menu_view',
                    'header_menu_create',
                    'header_menu_update',
                    'header_menu_delete',
                    'header_menu_trash',
                    'header_menu_restore',
                    'header_menu_force_delete',
                ],
            ],
            [
                'group_name'  => 'Footer Settings',
                'guard_name'  => 'admin',
                'permissions' => [
                    'footer_setting_manage',
                    'footer_setting_list',
                    'footer_setting_view',
                    'footer_setting_create',
                    'footer_setting_update',
                    'footer_setting_delete',
                    'footer_setting_trash',
                    'footer_setting_restore',
                    'footer_setting_force_delete',
                ],
            ],
            [
                'group_name'  => 'Footer Links',
                'guard_name'  => 'admin',
                'permissions' => [
                    'footer_link_manage',
                    'footer_link_list',
                    'footer_link_view',
                    'footer_link_create',
                    'footer_link_update',
                    'footer_link_delete',
                    'footer_link_trash',
                    'footer_link_restore',
                    'footer_link_force_delete',
                ],
            ],
            [
                'group_name'  => 'Categories',
                'guard_name'  => 'admin',
                'permissions' => [
                    'category_manage',
                    'category_list',
                    'category_view',
                    'category_create',
                    'category_update',
                    'category_delete',
                    'category_trash',
                    'category_restore',
                    'category_force_delete',
                ],
            ],

            [
                'group_name'  => 'Products',
                'guard_name'  => 'admin',
                'permissions' => [
                    'product_manage',
                    'product_list',
                    'product_view',
                    'product_create',
                    'product_update',
                    'product_delete',
                    'product_trash',
                    'product_restore',
                    'product_force_delete',
                ],
            ],
            [
                'group_name'  => 'Home Section Photos',
                'guard_name'  => 'admin',
                'permissions' => [
                    'home_section_photo_manage',
                    'home_section_photo_list',
                    'home_section_photo_view',
                    'home_section_photo_create',
                    'home_section_photo_update',
                    'home_section_photo_delete',
                    'home_section_photo_trash',
                    'home_section_photo_restore',
                    'home_section_photo_force_delete',
                ],
            ],
            [
                'group_name'  => 'Reviews',
                'guard_name'  => 'admin',
                'permissions' => [
                    'review_manage',
                    'review_list',
                    'review_view',
                    'review_create',
                    'review_update',
                    'review_delete',
                    'review_trash',
                    'review_restore',
                    'review_force_delete',
                ],
            ],
            [
                'group_name'  => 'Meta Pixel Scripts',
                'guard_name'  => 'admin',
                'permissions' => [
                    'meta_pixel_script_manage',
                    'meta_pixel_script_list',
                    'meta_pixel_script_view',
                    'meta_pixel_script_create',
                    'meta_pixel_script_update',
                    'meta_pixel_script_delete',
                    'meta_pixel_script_trash',
                    'meta_pixel_script_restore',
                    'meta_pixel_script_force_delete',
                ],
            ],
            [
                'group_name'  => 'Roles',
                'guard_name'  => 'admin',
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
                'group_name'  => 'Permission',
                'guard_name'  => 'admin',
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
                'group_name'  => 'Admin',
                'guard_name'  => 'admin',
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
            [
                'group_name'  => 'Contact Messages',
                'guard_name'  => 'admin',
                'permissions' => [
                    'contact_message_manage',
                    'contact_message_list',
                    'contact_message_view',
                    'contact_message_create',
                    'contact_message_update',
                    'contact_message_delete',
                    'contact_message_trash',
                    'contact_message_restore',
                    'contact_message_force_delete',
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
                        'name'       => $permissionName,
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
            ['label' => 'Contact Us', 'route_name' => 'contact.index', 'sort_order' => 5, 'status`' => true],
        ];

        foreach ($defaultMenuItems as $item) {
            $menuItem = HeaderMenuItem::withTrashed()
                ->where('label', $item['label'])
                ->first();

            if (! $menuItem) {
                HeaderMenuItem::create($item);
            } else {
                if ($menuItem->trashed()) {
                    $menuItem->restore();
                }
                $menuItem->update($item);
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
