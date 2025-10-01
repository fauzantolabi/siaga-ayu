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
                'asal_surat' => 'Dinas Pendidikan',
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
                'asal_surat' => 'Dinas Kesehatan',
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
