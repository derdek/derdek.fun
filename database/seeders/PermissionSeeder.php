<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'edit programs']);

        Permission::create(['name' => 'create types']);

        Permission::create(['name' => 'publish programs']);

        Permission::create(['name' => 'edit permissions']);

        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit programs');

        $role2 = Role::create(['name' => 'moderator']);
        $role2->givePermissionTo('edit programs');
        $role2->givePermissionTo('create types');
        $role2->givePermissionTo('publish programs');

        $role3 = Role::create(['name' => 'admin']);

        $role4 = Role::create(['name' => 'users-moderator']);
        $role4->givePermissionTo('edit permissions');
    }
}
