<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'upload files']);
        Permission::create(['name' => 'edit files']);
        Permission::create(['name' => 'delete files']);
        Permission::create(['name' => 'view files']);

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo(['upload files', 'edit files', 'view files']);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo(['view files']);
    }
}
