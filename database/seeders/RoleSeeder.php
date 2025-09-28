<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'description' => 'Administrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'User',
                'description' => 'Regular user with limited access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
