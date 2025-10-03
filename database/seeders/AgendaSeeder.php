<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agenda::create([
            'id_user' => 1, // isi sesuai id user yg ada di tabel users
            'tanggal' => now()->format('Y-m-d'),
            'waktu' => '10:00:00',
            'agenda' => 'Rapat Koordinasi',
            'id_jabatan' => 1, // pastikan ada data di tabel jabatans
            'tempat' => 'Ruang Rapat Utama',
            'id_pakaian' => 1, // pastikan ada data di tabel pakaian
            'id_surat' => 1, // pastikan ada surat dengan id=1
            'resume' => 'Membahas agenda kerja bulanan',
            'foto' => null,
        ]);
    }
}
