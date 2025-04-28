<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the default permissions
        $permissions = [
            array('name' => 'Create Role','group_name' => 'Roles'),
            array('name' => 'View Role','group_name' => 'Roles'),
            array('name' => 'Edit Role','group_name' => 'Roles'),
            array('name' => 'Delete Role','group_name' => 'Roles'),
            array('name' => 'Create Permission','group_name' => 'Permissions'),
            array('name' => 'View Permission','group_name' => 'Permissions'),
            array('name' => 'Edit Permission','group_name' => 'Permissions'),
            array('name' => 'Delete Permission','group_name' => 'Permissions'),
            array('name' => 'Assign Permission','group_name' => 'Permissions'),
            array('name' => 'Create User','group_name' => 'Users'),
            array('name' => 'View User','group_name' => 'Users'),
            array('name' => 'Edit User','group_name' => 'Users'),
            array('name' => 'Delete User','group_name' => 'Users'),
        ];

        // Create the permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['group_name' => $permission['group_name']]
            );
        }

    }
}
