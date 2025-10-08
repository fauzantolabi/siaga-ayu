<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PakaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('pakaians')->insert([
            [
                'pakaian' => 'Pakaian Dinas Harian Khaki',
                'singkatan' => 'PDH Khaki',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pakaian' => 'Pakaian Dinas Sipil',
                'singkatan' => 'PDS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
