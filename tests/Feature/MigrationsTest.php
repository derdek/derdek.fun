<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\PermissionsDemoSeeder;

class MigrationsTest extends TestCase
{
    public function testExistRoleSuperAdmin()
    {
        $this->assertDatabaseMissing('roles', ['name' => 'super-admin']);

        $this->seed(PermissionsDemoSeeder::class);

        $this->assertDatabaseHas('roles', ['name' => 'super-admin']);
    }
}
