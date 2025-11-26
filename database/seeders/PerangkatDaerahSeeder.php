<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerangkatDaerahSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $items = [
            // Sekretariat Daerah
            ['perangkat_daerah' => 'SEKRETARIAT DAERAH', 'singkatan' => 'SETDA'],

            // Sekretariat DPRD
            ['perangkat_daerah' => 'SEKRETARIAT DPRD', 'singkatan' => 'SETWAN'],

            // Inspektorat
            ['perangkat_daerah' => 'INSPEKTORAT', 'singkatan' => 'INSPEKTORAT'],

            // Dinas Pendidikan dan Kebudayaan
            ['perangkat_daerah' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 'singkatan' => 'DISDIKBUD'],

            // Dinas Kesehatan
            ['perangkat_daerah' => 'DINAS KESEHATAN', 'singkatan' => 'DINKES'],

            // Dinas Pekerjaan Umum dan Penataan Ruang
            ['perangkat_daerah' => 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG', 'singkatan' => 'DPUPR'],

            // Satpol PP & Damkar
            ['perangkat_daerah' => 'SATUAN POLISI PAMONG PRAJA DAN PEMADAM KEBAKARAN', 'singkatan' => 'SATPOLPP-DAMKAR'],

            // Dinas Lingkungan Hidup
            ['perangkat_daerah' => 'DINAS LINGKUNGAN HIDUP', 'singkatan' => 'DLH'],

            // Dinas Koperasi, UKM, Perdagangan, dan Perindustrian
            ['perangkat_daerah' => 'DINAS KOPERASI, USAHA KECIL DAN MENENGAH, PERDAGANGAN, DAN PERINDUSTRIAN', 'singkatan' => 'DISKOPDAGIN'],

            // Dinas Perumahan, Kawasan Permukiman dan Pertanahan
            ['perangkat_daerah' => 'DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN', 'singkatan' => 'DISKIMRUM'],

            // Dinas Kependudukan dan Pencatatan Sipil
            ['perangkat_daerah' => 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL', 'singkatan' => 'DISDUKCAPIL'],

            // Dinas Pemberdayaan Masyarakat dan Desa
            ['perangkat_daerah' => 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA', 'singkatan' => 'DPMD'],

            // Dinas Sosial
            ['perangkat_daerah' => 'DINAS SOSIAL', 'singkatan' => 'DINSOS'],

            // Dinas Tenaga Kerja
            ['perangkat_daerah' => 'DINAS TENAGA KERJA', 'singkatan' => 'DISNAKER'],

            // Dinas Perhubungan
            ['perangkat_daerah' => 'DINAS PERHUBUNGAN', 'singkatan' => 'DISHUB'],

            // Dinas Komunikasi dan Informatika
            ['perangkat_daerah' => 'DINAS KOMUNIKASI DAN INFORMATIKA', 'singkatan' => 'DISKOMINFO'],

            // Dinas Penanaman Modal dan PTSP
            ['perangkat_daerah' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', 'singkatan' => 'DPMPTSP'],

            // Dinas Pariwisata, Pemuda dan Olahraga
            ['perangkat_daerah' => 'DINAS PARIWISATA, PEMUDA DAN OLAH RAGA', 'singkatan' => 'DISPARA'],

            // Dinas Perikanan dan Kelautan
            ['perangkat_daerah' => 'DINAS PERIKANAN DAN KELAUTAN', 'singkatan' => 'DISKANLA'],

            // Dinas Ketahanan Pangan dan Pertanian
            ['perangkat_daerah' => 'DINAS KETAHANAN PANGAN DAN PERTANIAN', 'singkatan' => 'DKPP'],

            // Dinas Pengendalian Penduduk dan KB
            ['perangkat_daerah' => 'DINAS PENGENDALIAN PENDUDUK, KELUARGA BERENCANA,PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK', 'singkatan' => 'DISDUKP3A'],

            // Dinas Perpustakaan dan Kearsipan
            ['perangkat_daerah' => 'DINAS PERPUSTAKAAN DAN KEARSIPAN', 'singkatan' => 'DPA'],

            // Badan Perencanaan Pembangunan Daerah (BAPPEDA)
            ['perangkat_daerah' => 'BADAN PERENCANAAN PEMBANGUNAN, PENELITIAN DAN PENGEMBANGAN DAERAH', 'singkatan' => 'BAPPEDA'],

            // BKPSDM
            ['perangkat_daerah' => 'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA', 'singkatan' => 'BKPSDM'],

            // Badan Keuangan Aset Daerah
            ['perangkat_daerah' => 'BADAN KEUANGAN ASET DAERAH', 'singkatan' => 'BKAD'],

            // Badan Pendapatan Keuangan Aset Daerah
            ['perangkat_daerah' => 'BADAN PENDAPATAN KEUANGAN ASET DAERAH', 'singkatan' => 'BAPENDA'],

            // BPBD
            ['perangkat_daerah' => 'BADAN PENANGGULANGAN BENCANA DAERAH', 'singkatan' => 'BPBD'],

            // Kecamatan (gunakan singkatan CAMAT + nama)
            // List 31 kecamatan sesuai data
            ['perangkat_daerah' => 'KECAMATAN INDRAMAYU', 'singkatan' => 'CAMAT INDRAMAYU'],
            ['perangkat_daerah' => 'KECAMATAN SINDANG', 'singkatan' => 'CAMAT SINDANG'],
            ['perangkat_daerah' => 'KECAMATAN BALONGAN', 'singkatan' => 'CAMAT BALONGAN'],
            ['perangkat_daerah' => 'KECAMATAN ARAHAN', 'singkatan' => 'CAMAT ARAHAN'],
            ['perangkat_daerah' => 'KECAMATAN CANTIGI', 'singkatan' => 'CAMAT CANTIGI'],
            ['perangkat_daerah' => 'KECAMATAN PASEKAN', 'singkatan' => 'CAMAT PASEKAN'],
            ['perangkat_daerah' => 'KECAMATAN LOHBENER', 'singkatan' => 'CAMAT LOHBENER'],
            ['perangkat_daerah' => 'KECAMATAN KARANGAMPEL', 'singkatan' => 'CAMAT KARANGAMPEL'],
            ['perangkat_daerah' => 'KECAMATAN JUNTINYUAT', 'singkatan' => 'CAMAT JUNTINYUAT'],
            ['perangkat_daerah' => 'KECAMATAN KRAKENG', 'singkatan' => 'CAMAT KRAKENG'],
            ['perangkat_daerah' => 'KECAMATAN KEDOKANBUNDER', 'singkatan' => 'CAMAT KEDOKANBUNDER'],
            ['perangkat_daerah' => 'KECAMATAN JATIBARANG', 'singkatan' => 'CAMAT JATIBARANG'],
            ['perangkat_daerah' => 'KECAMATAN SLIYEG', 'singkatan' => 'CAMAT SLIYEG'],
            ['perangkat_daerah' => 'KECAMATAN WIDASARI', 'singkatan' => 'CAMAT WIDASARI'],
            ['perangkat_daerah' => 'KECAMATAN KERTASEMAYA', 'singkatan' => 'CAMAT KERTASEMAYA'],
            ['perangkat_daerah' => 'KECAMATAN SUKAGUMIWANG', 'singkatan' => 'CAMAT SUKAGUMIWANG'],
            ['perangkat_daerah' => 'KECAMATAN BANGODUA', 'singkatan' => 'CAMAT BANGODUA'],
            ['perangkat_daerah' => 'KECAMATAN TUKDANA', 'singkatan' => 'CAMAT TUKDANA'],
            ['perangkat_daerah' => 'KECAMATAN LOSARANG', 'singkatan' => 'CAMAT LOSARANG'],
            ['perangkat_daerah' => 'KECAMATAN CIKEDUNG', 'singkatan' => 'CAMAT CIKEDUNG'],
            ['perangkat_daerah' => 'KECAMATAN TERISI', 'singkatan' => 'CAMAT TERISI'],
            ['perangkat_daerah' => 'KECAMATAN LELEA', 'singkatan' => 'CAMAT LELEA'],
            ['perangkat_daerah' => 'KECAMATAN KANDANGHAUR', 'singkatan' => 'CAMAT KANDANGHAUR'],
            ['perangkat_daerah' => 'KECAMATAN GABUSWETAN', 'singkatan' => 'CAMAT GABUSWETAN'],
            ['perangkat_daerah' => 'KECAMATAN KROYA', 'singkatan' => 'CAMAT KROYA'],
            ['perangkat_daerah' => 'KECAMATAN BONGAS', 'singkatan' => 'CAMAT BONGAS'],
            ['perangkat_daerah' => 'KECAMATAN GANTAR', 'singkatan' => 'CAMAT GANTAR'],
            ['perangkat_daerah' => 'KECAMATAN ANJATAN', 'singkatan' => 'CAMAT ANJATAN'],
            ['perangkat_daerah' => 'KECAMATAN SUKRA', 'singkatan' => 'CAMAT SUKRA'],
            ['perangkat_daerah' => 'KECAMATAN PATROL', 'singkatan' => 'CAMAT PATROL'],
            ['perangkat_daerah' => 'KECAMATAN HAURGEULIS', 'singkatan' => 'CAMAT HAURGEULIS'],
        ];

        // Insert; gunakan upsert agar id tidak duplikasi saat seeding ulang
        foreach ($items as $item) {
            DB::table('perangkat_daerahs')->updateOrInsert(
                ['singkatan' => $item['singkatan']],
                ['perangkat_daerah' => $item['perangkat_daerah'], 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }
}
