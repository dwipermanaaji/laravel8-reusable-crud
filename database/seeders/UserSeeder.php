<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user0 = User::create([
            'id' => 1,
            'email' => 'admin@admin.com',
            'name' => 'Administrator',
            'password' => Hash::make('admin'),
        ]);
        $user0->assignRole('administrator');
    }
}
