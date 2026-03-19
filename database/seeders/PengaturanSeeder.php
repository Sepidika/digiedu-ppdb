<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Identitas Sekolah
            ['key' => 'nama_sekolah',    'value' => 'SMA DigiEdu Banyuwangi',         'label' => 'Nama Sekolah',          'grup' => 'identitas'],
            ['key' => 'email_ppdb',      'value' => 'ppdb@digiedu.sch.id',             'label' => 'Email PPDB',            'grup' => 'identitas'],
            ['key' => 'no_wa_admin',     'value' => '6281234567890',                   'label' => 'No WA Admin',           'grup' => 'identitas'],
            ['key' => 'alamat',          'value' => 'Jl. Jenderal Sudirman No. 45, Banyuwangi, Jawa Timur 68411', 'label' => 'Alamat', 'grup' => 'identitas'],
            ['key' => 'akreditasi',      'value' => 'A',                               'label' => 'Akreditasi',            'grup' => 'identitas'],
            ['key' => 'instagram_url',   'value' => 'https://instagram.com/digiedu',   'label' => 'URL Instagram',         'grup' => 'identitas'],
            ['key' => 'youtube_url',     'value' => 'https://youtube.com/@digiedu',    'label' => 'URL YouTube',           'grup' => 'identitas'],

            // PPDB
            ['key' => 'tahun_ajaran',    'value' => '2026/2027',                       'label' => 'Tahun Ajaran',          'grup' => 'ppdb'],
            ['key' => 'gelombang_aktif', 'value' => 'Gelombang 1',                     'label' => 'Gelombang Aktif',       'grup' => 'ppdb'],
            ['key' => 'kuota_mipa',      'value' => '150',                             'label' => 'Kuota MIPA',            'grup' => 'ppdb'],
            ['key' => 'kuota_ips',       'value' => '150',                             'label' => 'Kuota IPS',             'grup' => 'ppdb'],

            // Statistik
            ['key' => 'jumlah_pendidik', 'value' => '52',                              'label' => 'Jumlah Pendidik',       'grup' => 'statistik'],
            ['key' => 'jumlah_alumni',   'value' => '2400',                            'label' => 'Jumlah Alumni',         'grup' => 'statistik'],
            ['key' => 'jumlah_eskul',    'value' => '38',                              'label' => 'Jumlah Ekskul',         'grup' => 'statistik'],
            ['key' => 'jumlah_prestasi', 'value' => '162',                             'label' => 'Jumlah Prestasi',       'grup' => 'statistik'],

            // Kepala Sekolah
            ['key' => 'kepsek_nama',      'value' => 'Dr. H. Bambang Supriyadi, M.Pd.', 'label' => 'Nama Kepala Sekolah',  'grup' => 'profil'],
            ['key' => 'kepsek_sambutan',  'value' => 'Kami merancang kurikulum tidak hanya untuk mencetak siswa cerdas secara akademik, tetapi juga siswa yang peduli terhadap sejarah, budaya bangsa, dan siap menghadapi tantangan global dengan integritas tinggi.', 'label' => 'Sambutan Kepsek', 'grup' => 'profil'],
            ['key' => 'kepsek_foto',      'value' => '',                               'label' => 'Foto Kepala Sekolah',   'grup' => 'profil'],

            // Maps
            ['key' => 'maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126362.47461971701!2d114.2885918731307!3d-8.214088904576135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1451910248e35%3A0xc6e462c8282ea8e0!2sBanyuwangi!5e0!3m2!1sen!2sid!4v1700000000000', 'label' => 'Embed Google Maps', 'grup' => 'lokasi'],
        ];

       foreach ($settings as $s) {
        \App\Models\Pengaturan::firstOrCreate(
            ['key' => $s['key']],
            ['value' => $s['value']]
        );
    }   

        echo '✅ Pengaturan seeded . PHP_EOL;
    }
}

