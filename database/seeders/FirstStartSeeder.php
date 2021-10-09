<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FirstStartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                PermissionsDemoSeeder::class,
                TestProgramsSeeder::class,
        ]);
        
    }
}
