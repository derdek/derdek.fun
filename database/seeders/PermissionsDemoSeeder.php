<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit programs']);
        Permission::create(['name' => 'delete programs']);
        Permission::create(['name' => 'publish programs']);
        Permission::create(['name' => 'unpublish programs']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit programs');
        $role1->givePermissionTo('delete programs');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish programs');
        $role2->givePermissionTo('unpublish programs');

        $role3 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'user@derdek.fun',
            'password' => bcrypt('userPassword'),
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@derdek.fun',
            'password' => bcrypt('adminPassword'),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin User',
            'email' => 'superadmin@derdek.fun',
            'password' => bcrypt('superadminPassword'),
        ]);
        $user->assignRole($role3);
    }
}