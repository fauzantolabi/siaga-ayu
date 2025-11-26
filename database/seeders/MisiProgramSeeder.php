<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Misi;
use App\Models\Program;

class MisiProgramSeeder extends Seeder
{
    public function run(): void
    {
        // ======== M I S I  1 ========
        $misi1 = Misi::create([
            'misi' => 'Meningkatkan kualitas sumber daya manusia berbasis nilai-nilai religius di semua sendi-sendi kehidupan',
            'description' => 'Fokus pada peningkatan kualitas SDM melalui pendidikan, keagamaan, kebudayaan, kesehatan, dan pemberdayaan perempuan.'
        ]);

        $programsMisi1 = [
            'Program Indramayu Belajar',
            'Program Indramayu Kuliah',
            'Program Indramayu Mengaji',
            'Program Indramayu Beribadah',
            'Program Indramayu Berzakat',
            'Program Pelestarian dan Pengembangan Kesenian Tradisional, Kebudayaan Daerah, dan Cagar Budaya',
            'Program Indramayu Membaca',
            'Program Indramayu Sehat',
            'Program Pemuda Kreatif, Inovatif dan Mandiri',
            'Program Indramayu Berolahraga',
            'Program Perlindungan dan Pemberdayaan Perempuan, Anak dan Lansia'
        ];

        foreach ($programsMisi1 as $p) {
            Program::create(['id_misi' => $misi1->id, 'description' => $p]);
        }

        // ======== M I S I  2 ========
        $misi2 = Misi::create([
            'misi' => 'Mengembangkan ekonomi kerakyatan yang adil, mandiri, berkelanjutan, dan berdaya saing',
            'description' => 'Fokus pada peningkatan kesejahteraan masyarakat melalui sektor pertanian, perikanan, UMKM, dan pariwisata.'
        ]);

        $programsMisi2 = [
            'Program Pendampingan Manajemen, Bantuan Modal Usaha, dan Akses Pemasaran',
            'Program Pengembangan Ekonomi Hijau',
            'Program Pengembangan Ekonomi Biru',
            'Program Peningkatan Kesejahteraan Petambak Garam',
            'Program Petani Sejahtera',
            'Program Pengembangan Peternakan Rakyat',
            'Program Peningkatan Kesejahteraan Nelayan dan Pembudidaya Ikan',
            'Program Pengembangan Pariwisata Indramayu',
            'Program Pasar Rakyat Indramayu',
            'Program Pengembangan Industri',
            'Program Perizinan Mudah, Cepat dan Terpadu',
            'Program Peningkatan Kesempatan dan Kompetensi Kerja',
            'Program Peduli Pekerja Migran',
            'Program Penanganan PPKS'
        ];

        foreach ($programsMisi2 as $p) {
            Program::create(['id_misi' => $misi2->id, 'description' => $p]);
        }

        // ======== M I S I  3 ========
        $misi3 = Misi::create([
            'misi' => 'Mewujudkan infrastruktur dan lingkungan hidup yang aman dan nyaman bagi masyarakat',
            'description' => 'Fokus pada peningkatan kualitas infrastruktur, transportasi, perumahan, dan pengelolaan lingkungan.'
        ]);

        $programsMisi3 = [
            'Program Jalan Mulus dan Aman',
            'Program Peningkatan Irigasi',
            'Program Peningkatan Ketersediaan Air Bersih/Air Minum',
            'Program Peningkatan Sanitasi',
            'Program Peningkatan Drainase',
            'Program Fasilitas Proyek Strategis Nasional',
            'Program Penyelenggaraan Penataan Ruang',
            'Program Peningkatan Kualitas Bangunan Gedung Pemerintah',
            'Program Peningkatan Rumah Layak Huni',
            'Program Pengurangan Kawasan Kumuh',
            'Program Penyediaan Sarana, Prasarana, dan Utilitas Permukiman',
            'Program Indramayu Hijau',
            'Program Pengelolaan Sampah',
            'Program Peningkatan Layanan Transportasi Darat',
            'Program Pencegahan dan Penanggulangan Banjir',
            'Program Indramayu Tangguh Bencana'
        ];

        foreach ($programsMisi3 as $p) {
            Program::create(['id_misi' => $misi3->id, 'description' => $p]);
        }

        // ======== M I S I  4 ========
        $misi4 = Misi::create([
            'misi' => 'Mewujudkan tata kelola pemerintahan yang baik',
            'description' => 'Fokus pada peningkatan kinerja aparatur, kebijakan publik, dan sistem pemerintahan berbasis teknologi.'
        ]);

        $programsMisi4 = [
            'Program Peningkatan Kualitas Penyelenggaraan Pemerintahaan Daerah',
            'Program Indramayu Smart Governance',
            'Program Penataan Daerah',
            'Program Peningkatan Kualitas Kebijakan Daerah',
            'Program Peningkatan Ketertiban dan Ketentraman Masyarakat',
            'Program Pengembangan Kompetensi ASN',
            'Program Peningkatan Kinerja ASN',
            'Program Pengembangan Ekosistem Inovasi Daerah',
            'Program Wong Reang Wadul',
            'Program Kerjasama Dalam Negeri'
        ];

        foreach ($programsMisi4 as $p) {
            Program::create(['id_misi' => $misi4->id, 'description' => $p]);
        }

        // ======== M I S I  5 ========
        $misi5 = Misi::create([
            'misi' => 'Meningkatkan pemberdayaan masyarakat dan desa berasaskan semangat gotong royong',
            'description' => 'Fokus pada peningkatan kapasitas masyarakat, kelembagaan desa, dan semangat kolaborasi sosial.'
        ]);

        $programsMisi5 = [
            'Program Penataan Balai Desa (Lebu)',
            'Program Penguatan RT dan RW',
            'Program Mobil Siaga',
            'Program Peningkatan Partisipasi dan Peningkatan Keamanan Lingkungan Desa',
            'Program Kerjasama Antar Desa',
            'Program Pengembangan BUMDes'
        ];

        foreach ($programsMisi5 as $p) {
            Program::create(['id_misi' => $misi5->id, 'description' => $p]);
        }
    }
}
