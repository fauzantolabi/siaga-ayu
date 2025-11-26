<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // map singkatan PD => array jabatan (ordered; prioritas bisa disesuaikan)
        $map = [
            'SETDA' => [
                'BUPATI INDRAMAYU',
                'WAKIL BUPATI',
                'SEKRETARIS DAERAH',
                'STAF AHLI BIDANG PEMERINTAHAN HUKUM DAN POLITIK',
                'STAF AHLI BIDANG EKONOMI, KEUANGAN DAN PEMBANGUNAN',
                'STAF AHLI BIDANG KEMASYARAKATAN DAN SDM',
                'ASISTEN PEMERINTAHAN',
                'KABAG TATA PEMERINTAHAN',
                'KABAG OTONOMI DAERAH',
                'KABAG HUKUM',
                'ASISTEN EKONOMI, PEMBANGUNAN, DAN KESRA',
                'KABAG PEREKONOMIAN',
                'KABAG ADMINSTRASI PEMBANGUNAN',
                'KABAG KESRA',
                'KABAG PENGADAAN BARANG DAN JASA',
                'ASISTEN ADMINISTRASI',
                'KABAG ORGANISASI',
                'KABAG KEUANGAN DAN PERLENGKAPAN',
                'KABAG UMUM',
                'KABAG PROTOKOL DAN KOMUNIKASI',
            ],
            'SETWAN' => [
                'SEKRETARIS DPRD',
                'KABAG PERSIDANGAN DAN PER-UU',
                'KABAG PENGANGGARAN DAN PENGAWASAN',
                'KABAG UMUM',
            ],
            'INSPEKTORAT' => [
                'SEKRETARIS',
                'INSPEKTUR PEMBANTU WILAYAH I',
                'INSPEKTUR PEMBANTU WILAYAH II',
                'INSPEKTUR PEMBANTU WILAYAH III',
                'INSPEKTUR PEMBANTU WILAYAH IV',
                'INSPEKTUR PEMBANTU KHUSUS',
            ],
            'DISDIKBUD' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PEMBINAAN PAUD',
                'KABID PEMBINAAN SD',
                'KABID PEMBINAAN SMP',
                'KABID PEMBINAAN PENDIDIKAN NON FORMAL',
            ],
            'DINKES' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID KESEHATAN MASYARAKAT',
                'KABID PENCEGAHAN DAN PENGENDALIAN PENYAKIT',
                'KABID PELAYANAN KESEHATAN',
                'KABID SUMBER DAYA KESEHATAN',
            ],
            'DPUPR' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PENGEMBANGAN SUMBER DAYA AIR',
                'KABID TATA TEKNIS IRIGASI',
                'KABID JALAN',
                'KABID JEMBATAN',
                'KABID TATA BANGUNAN',
                'KABID PENATAAN RUANG',
            ],
            'SATPOLPP-DAMKAR' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PENEGAKAN PER UNDANG-UNDANGAN DAERAH',
                'KABID KETERTIBAN UMUM DAN KETENTERAMAN MASYARAKAT',
                'KABID PERLINDUNGAN MASYARAKAT',
                'KABID PEMADAM KEBAKARAN',
            ],
            'DLH' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID TATA LINGKUNGAN',
                'KABID PENGELOLAAN SAMPAH DAN LIMBAH B3',
                'KABID PENGENDALIAN PENCEMARAN DAN KERUSAKAN LINGKUNGAN',
                'KABID PENATAAN DAN PENINGKATAN KAPASITAS LINGKUNGAN HIDUP',
            ],
            'DISKOPDAGIN' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID KOPERASI, USAHA MIKRO DAN KECIL',
                'KABID PERDAGANGAN',
                'KABID PENGELOLAAN PASAR',
                'KABID PERINDUSTRIAN',
            ],
            'DISKIMRUM' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PERUMAHAN DAN PENYEHATAN LINGKUNGAN',
                'KABID KAWASAN PERMUKIMAN',
                'KABID PERTANAHAN',
            ],
            'DISDUKCAPIL' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PELAYANAN PENDAFTARAN PENDUDUK',
                'KABID PELAYANAN PENCATATAN SIPIL',
                'KABID PENGELOLAAN INFORMASI ADMINISTRASI KEPENDUDUKAN',
            ],
            'DPMD' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PEMERINTAHAN DESA',
                'KABID KELEMBAGAAN DAN PEMBERDAYAAN MASYARAKAT DESA',
                'KABID PEMBANGUNAN DESA',
            ],
            'DINSOS' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PERLINDUNGAN DAN JAMINAN SOSIAL',
                'KABID REHABILITASI SOSIAL',
                'KABID PEMBERDAYAAN SOSIAL DAN PENANGANAN FAKIR MISKIN',
            ],
            'DISNAKER' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PELATIHAN KERJA, PRODUKTIVITAS, DAN TRANSMIGRASI',
                'KABID PENEMPATAN TENAGA KERJA',
                'KABID HUBUNGAN INDUSTRIAL DAN JAMINAN SOSIAL',
            ],
            'DISHUB' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PERHUBUNGAN DARAT',
                'KABID KESELAMATAN LALU LINTAS',
                'KABID PERHUBUNGAN LAUT',
            ],
            'DISKOMINFO' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID INFORMASI DAN KOMUNIKASI PUBLIK',
                'KABID TEKNOLOGI INFORMASI DAN KOMUNIKASI',
                'KABID STATISTIK DAN PERSANDIAN',
            ],
            'DPMPTSP' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PENANAMAN MODAL',
                'KABID PENGOLAHAN DATA DAN SISTEM INFORMASI',
                'KABID PENGAWASAN DAN PENGENDALIAN',
                'KABID PELAYANAN PERIZINAN',
            ],
            'DISPARA' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PARIWISATA',
                'KABID PROMOSI DAN KEMITRAAN',
                'KABID EKONOMI KREATIF',
            ],
            'DISKANLA' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PEMBERDAYAAN NELAYAN KECIL',
                'KABID BINA USAHA DAN PENGELOLAAN TEMPAT PELELANGAN IKAN',
                'KABID PERIKANAN BUDI DAYA',
            ],
            'DKPP' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PRASARANA, SARANA, DAN PENYULUHAN',
                'KABID PERBIBITAN DAN PRODUKSI TERNAK',
                'KABID KESEHATAN HEWAN',
            ],
            'DISDUKP3A' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PENGENDALIAN PENDUDUK, PENYULUHAN, DAN PENGGERAKAN',
                'KABID KELUARGA BERENCANA, KETAHANAN, DAN KESEJAHTERAAN KELUARGA',
                'KABID PENGURUS UTAMAAN GENDER DAN PEMBERDAYAAN PEREMPUAN',
                'KABID PERLINDUNGAN PEREMPUAN DAN ANAK',
            ],
            'DPA' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PENYELENGGARAAN KEARSIPAN',
                'KABID PERPUSTAKAAN',
            ],
            'BAPPEDA' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PERENCANAAN, PENGENDALIAN, DAN EVALUASI',
                'KABID PEMERINTAHAN DAN SOSIAL BUDAYA',
                'KABID PEREKONOMIAN',
                'KABID INFRASTRUKTUR DAN KEWILAYAHAN',
                'KABID PENELITIAN DAN PENGEMBANGAN',
            ],
            'BKPSDM' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PENGADAAN, PEMBERHENTIAN, DAN INFORMASI',
                'KABID MUTASI DAN PROMOSI',
                'KABID PENGEMBANGAN KOMPETENSI APARATUR',
                'KABID PENILAIAN KINERJA APARATUR DAN PENGHARGAAN',
            ],
            'BKAD' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID ANGGARAN',
                'KABID PERBENDAHARAAN',
                'KABID AKUNTANSI',
                'KABID BARANG MILIK DAERAH',
            ],
            'BAPENDA' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID PERENCANAAN DAN PENGEMBANGAN',
                'KABID PAJAK DAERAH LAINYA',
                'KABID ANGGARAN PBBDAN BPHTR',
                'KABID EVALUASI DAN PENGEMBANGAN',
            ],
            'BPBD' => [
                'KEPALA',
                'SEKRETARIS',
                'KABID KEDARURATAN',
                'KABID REHABILITASI',
                'KABID PENCEGAHAN',
            ],
        ];

        // Untuk kecamatan, tambahkan jabatan dasar: CAMAT, SEKCAM
        $kecamatanSingkat = [
            'CAMAT INDRAMAYU',
            'CAMAT SINDANG',
            'CAMAT BALONGAN',
            'CAMAT ARAHAN',
            'CAMAT CANTIGI',
            'CAMAT PASEKAN',
            'CAMAT LOHBENER',
            'CAMAT KARANGAMPEL',
            'CAMAT JUNTINYUAT',
            'CAMAT KRAKENG',
            'CAMAT KEDOKANBUNDER',
            'CAMAT JATIBARANG',
            'CAMAT SLIYEG',
            'CAMAT WIDASARI',
            'CAMAT KERTASEMAYA',
            'CAMAT SUKAGUMIWANG',
            'CAMAT BANGODUA',
            'CAMAT TUKDANA',
            'CAMAT LOSARANG',
            'CAMAT CIKEDUNG',
            'CAMAT TERISI',
            'CAMAT LELEA',
            'CAMAT KANDANGHAUR',
            'CAMAT GABUSWETAN',
            'CAMAT KROYA',
            'CAMAT BONGAS',
            'CAMAT GANTAR',
            'CAMAT ANJATAN',
            'CAMAT SUKRA',
            'CAMAT PATROL',
            'CAMAT HAURGEULIS'
        ];

        // Insert kecamatan jabatan mapping
        foreach ($kecamatanSingkat as $sg) {
            $map[$sg] = ['CAMAT', 'SEKCAM', 'KASI', 'KABID/UNIT']; // generik
        }

        // Ambil semua perangkat daerah yang ada pada tabel untuk mapping
        $perangkat = DB::table('perangkat_daerahs')->pluck('id', 'singkatan')->toArray();
        $defaultPriority = 99;

        foreach ($map as $pdSing => $jabatanList) {
            if (!isset($perangkat[$pdSing])) {
                // skip jika perangkat daerah belum ada (log di laravel.log jika perlu)
                continue;
            }
            $pdId = $perangkat[$pdSing];

            foreach ($jabatanList as $idx => $jabatanName) {
                DB::table('jabatans')->updateOrInsert(
                    [
                        'jabatan' => $jabatanName,
                        'id_perangkat_daerah' => $pdId
                    ],
                    [
                        'prioritas' => ($idx + 1),
                        'created_at' => $now,
                        'updated_at' => $now
                    ]
                );
            }
        }
    }
}
