<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        call_user_func(function () {
            $this->call(RoleSeeder::class);
            $this->call(PerangkatDaerahSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(JabatanSeeder::class);
            $this->call(PakaianSeeder::class);
            $this->call(SuratSeeder::class);
        });
    }
}
