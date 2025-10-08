<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerangkatDaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('perangkat_daerahs')->insert([
            [
                'perangkat_daerah' => 'Kabupaten Indramayu',
                'singkatan' => 'Kab. Indramayu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'perangkat_daerah' => 'Sekretariat Daerah',
                'singkatan' => 'Setda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
