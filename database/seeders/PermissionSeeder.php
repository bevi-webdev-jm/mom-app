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
            'Reports' => [
                'report access' => 'Allow user to access reports.',
            ],
            'Moms' => [
                'mom access'    => 'Allow user to access mom list and details.',
                'mom create'    => 'Allow user to create mom.',
                'mom edit'      => 'Allow user to edit mom details.',
                'mom upload'    => 'Allow user to upload mom details',
                'mom delete'    => 'Allow user to delete mom.',
                'mom print'     => 'Allow user to print mom details',
            ],
            'Types' => [
                'type access'   => 'Allow user to access mom type list and details',
                'type create'   => 'Allow user to create mom type.',
                'type edit'     => 'Allow user to edit mom type details.',
                'type upload'   => 'Allow user to upload mom types.',
                'type delete'   => 'Allow user to delete mom type.'
            ],
            'Fire Alarm'    => [
                'fire alarm access' => 'Allow user to access fire alarm.',
            ],
            'Companies' => [
                'company access'    => 'Allow user to access company list and details.',
                'company create'    => 'Allow user to create company.',
                'company edit'      => 'Allow user to edit company details.',
                'company delete'    => 'Allow user to delete company.'
            ],
            'Locations' => [
                'location access'   => 'Allow user to access location list and details.',
                'location create'   => 'Allow user to create location.',
                'location edit'     => 'Allow user to edit location details.',
                'location delete'   => 'Allow user to delete location.'
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
                'system logs'       => 'Allow user to access system logs.',
                'system online'     => 'Allow user to view online users.',
            ],
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
