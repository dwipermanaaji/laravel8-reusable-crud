<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'all']);
        Permission::create(['name' => 'examples.list']);
        Permission::create(['name' => 'examples.create']);
        Permission::create(['name' => 'examples.read']);
        Permission::create(['name' => 'examples.update']);
        Permission::create(['name' => 'examples.destroy']);        
    }
}
