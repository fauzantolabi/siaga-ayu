<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{

    public function run(): void
    {
        \DB::table('jabatans')->insert([
            [
                'id_perangkat_daerah' => '1',
                'jabatan' => 'Bupati',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_perangkat_daerah' => '1',
                'jabatan' => 'Wakil Bupati',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
