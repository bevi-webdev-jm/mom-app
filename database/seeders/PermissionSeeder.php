<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions_arr = [
            'Items' => [
                'item access'   => 'Allow user to access item list and details',
                'item create'   => 'Allow user to create item.',
                'item edit'     => 'Allow user to edit item details.',
                'item delete'   => 'Allow user to delete item.'
            ],
            'Companies' => [
                'company access'    => 'Allow user to access company list and details.',
                'company create'    => 'Allow user to create company.',
                'company edit'      => 'Allow user to edit company details.',
                'company delete'    => 'Allow user to delete company.'
            ],
            'Users' => [
                'user access'           => 'Allow user to access user list and details',
                'user create'           => 'Allow user to create user.',
                'user edit'             => 'Allow user to edit user details.',
                'user change password'  => 'Allow user to change password of a user.',
                'user delete'           => 'Allow user to delete user.'
            ],
            'Roles' => [
                'role access'   => 'Allow user to access role list and details',
                'role create'   => 'Allow user to create role.',
                'role edit'     => 'Allow user to edit role details.',
                'role delete'   => 'Allow user to delete role.'
            ],
            'System' => [
                'system settings'   => 'Allow user to access system settings.',
                'system logs'       => 'Allow user to access system logs.'
            ]
        ];

        foreach($permissions_arr as $module => $permissions) {
            foreach($permissions as $permission => $description) {
                Permission::create([
                    'name' => $permission,
                    'module' => $module,
                    'description' => $description,
                ]);
            }
        }
    }
}
