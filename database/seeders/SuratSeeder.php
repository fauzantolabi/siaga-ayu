<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class SuratSeeder extends Seeder
{

    public function run(): void
    {
        \DB::table('surats')->insert([
            [
                'nomor_surat' => '1',
                'perihal' => 'Bupati',
                'tanggal_surat' => '1',
                'tanggal_terima' => '1',
                'sifat_surat' => '1',
                'hal' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => '1',
                'perihal' => 'Wakil Bupati',
                'tanggal_surat' => '1',
                'tanggal_terima' => '1',
                'sifat_surat' => '1',
                'hal' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
