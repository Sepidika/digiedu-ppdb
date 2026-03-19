<?php
/**
 * DigiEdu PPDB - Seeder & Pengaturan Lengkap
 * Jalankan: php write-seeder.php
 */

$files = [];

// ============================================================
// 1. DatabaseSeeder.php
// ============================================================
$files['database/seeders/DatabaseSeeder.php'] = <<<'PHP'
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            PengaturanSeeder::class,
            JadwalSeeder::class,
            PendaftarSeeder::class,
            ArtikelSeeder::class,
        ]);
    }
}
PHP;

// ============================================================
// 2. AdminSeeder
// ============================================================
$files['database/seeders/AdminSeeder.php'] = <<<'PHP'
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->upsert([
            [
                'nama'          => 'Super Admin',
                'email'         => 'admin@digiedu.sch.id',
                'password'      => Hash::make('password123'),
                'role'          => 'superadmin',
                'status'        => 'aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama'          => 'Operator PPDB',
                'email'         => 'operator@digiedu.sch.id',
                'password'      => Hash::make('password123'),
                'role'          => 'operator',
                'status'        => 'aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ], ['email'], ['nama', 'password', 'role', 'status', 'updated_at']);

        echo "✅ Admin seeded\n";
    }
}
PHP;

// ============================================================
// 3. PengaturanSeeder — semua key termasuk yang baru
// ============================================================
$files['database/seeders/PengaturanSeeder.php'] = <<<'PHP'
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
            DB::table('pengaturans')->updateOrInsert(
                ['key' => $s['key']],
                array_merge($s, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        echo "✅ Pengaturan seeded (" . count($settings) . " key)\n";
    }
}
PHP;

// ============================================================
// 4. JadwalSeeder
// ============================================================
$files['database/seeders/JadwalSeeder.php'] = <<<'PHP'
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal_ppdbs')->truncate();
        DB::table('jadwal_ppdbs')->insert([
            ['tahap' => 1, 'nama_tahap' => 'Pendaftaran Online Gelombang 1', 'tanggal_mulai' => '2026-03-01', 'tanggal_selesai' => '2026-03-31', 'status' => 'selesai', 'created_at' => now(), 'updated_at' => now()],
            ['tahap' => 2, 'nama_tahap' => 'Verifikasi Berkas & Seleksi',    'tanggal_mulai' => '2026-04-01', 'tanggal_selesai' => '2026-04-15', 'status' => 'aktif',   'created_at' => now(), 'updated_at' => now()],
            ['tahap' => 3, 'nama_tahap' => 'Pengumuman Hasil Seleksi',       'tanggal_mulai' => '2026-04-20', 'tanggal_selesai' => '2026-04-20', 'status' => 'belum',   'created_at' => now(), 'updated_at' => now()],
            ['tahap' => 4, 'nama_tahap' => 'Daftar Ulang Siswa Diterima',    'tanggal_mulai' => '2026-04-21', 'tanggal_selesai' => '2026-04-30', 'status' => 'belum',   'created_at' => now(), 'updated_at' => now()],
            ['tahap' => 5, 'nama_tahap' => 'Pendaftaran Gelombang 2',        'tanggal_mulai' => '2026-05-01', 'tanggal_selesai' => '2026-05-20', 'status' => 'belum',   'created_at' => now(), 'updated_at' => now()],
            ['tahap' => 6, 'nama_tahap' => 'Masa Pengenalan Lingkungan',     'tanggal_mulai' => '2026-07-14', 'tanggal_selesai' => '2026-07-16', 'status' => 'belum',   'created_at' => now(), 'updated_at' => now()],
        ]);

        echo "✅ Jadwal PPDB seeded\n";
    }
}
PHP;

// ============================================================
// 5. PendaftarSeeder — 30 data dummy realistis
// ============================================================
$files['database/seeders/PendaftarSeeder.php'] = <<<'PHP'
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendaftarSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pendaftars')->truncate();

        $namaList = [
            'Ahmad Fauzi','Siti Rahayu','Budi Santoso','Dewi Lestari','Eko Prasetyo',
            'Fitria Handayani','Galih Permana','Hana Safitri','Irfan Maulana','Juwita Sari',
            'Kevin Ardian','Laila Nur','Muhammad Rizki','Nanda Puspita','Omar Farhan',
            'Putri Ayu','Qori Anggita','Reza Firmansyah','Salsabila','Taufik Hidayat',
            'Ulfa Mardiana','Vino Pratama','Winda Cahyani','Xena Valentina','Yogi Pratama',
            'Zahra Aulia','Arya Dwiputra','Bella Safira','Cahyo Nugroho','Dian Pertiwi',
        ];

        $sekolahList = [
            'SMP Negeri 1 Banyuwangi','SMP Negeri 2 Banyuwangi','SMP Negeri 3 Genteng',
            'MTs Negeri 1 Banyuwangi','SMP Islam Al-Hikmah','SMP Muhammadiyah Banyuwangi',
            'SMP Negeri 1 Rogojampi','SMP Negeri 2 Srono','SMP Katolik Santo Yoseph',
        ];

        $jalurList  = ['Zonasi', 'Prestasi', 'Afirmasi', 'Perpindahan'];
        $jurusanList = ['MIPA', 'IPS'];
        $statusList  = ['Diterima', 'Diterima', 'Diterima', 'Menunggu', 'Menunggu', 'Ditolak'];

        $rows = [];
        foreach ($namaList as $i => $nama) {
            $status  = $statusList[array_rand($statusList)];
            $nisn    = '00' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            $noReg   = 'PPDB-2026-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            $jurusan = $jurusanList[array_rand($jurusanList)];
            $rows[]  = [
                'no_reg'        => $noReg,
                'nisn'          => $nisn,
                'nama'          => $nama,
                'tempat_lahir'  => 'Banyuwangi',
                'tanggal_lahir' => date('Y-m-d', strtotime('-' . rand(14, 16) . ' years -' . rand(0, 364) . ' days')),
                'jenis_kelamin' => rand(0, 1) ? 'L' : 'P',
                'agama'         => 'Islam',
                'alamat'        => 'Jl. ' . ['Melati', 'Mawar', 'Anggrek', 'Dahlia'][rand(0,3)] . ' No.' . rand(1,50) . ', Banyuwangi',
                'no_hp'         => '08' . rand(100000000, 999999999),
                'email'         => strtolower(str_replace(' ', '.', $nama)) . '@gmail.com',
                'asal_sekolah'  => $sekolahList[array_rand($sekolahList)],
                'jalur'         => $jalurList[array_rand($jalurList)],
                'jurusan'       => $jurusan,
                'nilai_rata'    => number_format(rand(750, 950) / 10, 1),
                'status'        => $status,
                'catatan_admin' => $status === 'Ditolak' ? 'Berkas tidak lengkap, ijazah belum dilegalisir.' : null,
                'gelombang'     => 1,
                'created_at'    => now()->subDays(rand(1, 30)),
                'updated_at'    => now(),
            ];
        }

        DB::table('pendaftars')->insert($rows);
        echo "✅ Pendaftar seeded (" . count($rows) . " data)\n";
    }
}
PHP;

// ============================================================
// 6. ArtikelSeeder — 5 artikel dummy
// ============================================================
$files['database/seeders/ArtikelSeeder.php'] = <<<'PHP'
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('artikels')->truncate();

        $artikels = [
            [
                'judul'     => 'Jadwal Ujian Masuk PPDB Gelombang 1 Resmi Dibuka',
                'kategori'  => 'Pengumuman',
                'isi'       => "Panitia PPDB SMA DigiEdu Banyuwangi dengan bangga mengumumkan bahwa jadwal ujian masuk untuk Gelombang 1 Tahun Ajaran 2026/2027 telah resmi ditetapkan.\n\nUjian akan dilaksanakan secara Computer Based Test (CBT) di laboratorium komputer sekolah. Peserta wajib hadir 30 menit sebelum ujian dimulai dengan membawa kartu peserta yang telah dicetak.\n\nMateri ujian meliputi:\n- Tes Potensi Akademik (TPA)\n- Bahasa Indonesia\n- Matematika\n- Bahasa Inggris\n\nInformasi lebih lanjut dapat menghubungi panitia PPDB melalui WhatsApp atau datang langsung ke sekretariat.",
                'penulis'   => 'Panitia PPDB',
                'status'    => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'judul'     => 'SMA DigiEdu Raih Juara 1 Olimpiade Sains Nasional Tingkat Provinsi',
                'kategori'  => 'Prestasi',
                'isi'       => "Kebanggaan besar datang dari SMA DigiEdu Banyuwangi. Tim siswa kami berhasil meraih Juara 1 Olimpiade Sains Nasional (OSN) bidang Matematika tingkat Provinsi Jawa Timur.\n\nPrestasi gemilang ini diraih oleh Muhammad Rizki (Kelas XI MIPA 2) setelah bersaing ketat dengan ratusan peserta dari seluruh kabupaten/kota di Jawa Timur.\n\nKepala Sekolah Dr. H. Bambang Supriyadi, M.Pd. menyampaikan rasa bangga dan apresiasi setinggi-tingginya kepada siswa berprestasi beserta guru pembimbing yang telah bekerja keras mempersiapkan tim.\n\nMuhammad Rizki akan mewakili Jawa Timur di ajang OSN tingkat nasional yang akan diselenggarakan bulan Juli mendatang.",
                'penulis'   => 'Humas Sekolah',
                'status'    => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'judul'     => 'Program Beasiswa Penuh untuk Siswa Berprestasi 2026/2027',
                'kategori'  => 'Informasi',
                'isi'       => "SMA DigiEdu Banyuwangi kembali membuka program beasiswa penuh bagi calon siswa berprestasi dari keluarga kurang mampu untuk tahun ajaran 2026/2027.\n\nProgram beasiswa ini mencakup:\n- Pembebasan biaya SPP selama 3 tahun\n- Tunjangan buku dan alat tulis\n- Akses laboratorium dan fasilitas penuh\n- Bimbingan belajar intensif\n\nPersyaratan pendaftar beasiswa:\n1. Nilai rata-rata rapor SMP minimal 85\n2. Surat keterangan tidak mampu dari kelurahan\n3. Fotokopi Kartu Keluarga\n4. Surat rekomendasi dari kepala sekolah asal\n\nPendaftaran beasiswa dilakukan bersamaan dengan pendaftaran PPDB reguler. Seleksi akan dilakukan melalui wawancara dan verifikasi berkas.",
                'penulis'   => 'Panitia PPDB',
                'status'    => 'published',
                'published_at' => now()->subDays(15),
            ],
            [
                'judul'     => 'Kunjungan Edukatif ke Museum Blambangan: Belajar Sejarah Secara Nyata',
                'kategori'  => 'Kegiatan',
                'isi'       => "Ratusan siswa kelas X SMA DigiEdu Banyuwangi melaksanakan kunjungan edukatif ke Museum Blambangan sebagai bagian dari implementasi Kurikulum Merdeka.\n\nKegiatan yang berlangsung selama satu hari penuh ini bertujuan untuk mendekatkan siswa dengan sejarah lokal Banyuwangi dan Kerajaan Blambangan yang memiliki peran penting dalam sejarah Nusantara.\n\nSiswa diajak untuk mengamati langsung koleksi artefak, prasasti, dan dokumentasi sejarah yang tersimpan di museum. Mereka juga mendapat kesempatan berdialog langsung dengan kurator museum.\n\n\"Dengan melihat langsung benda-benda bersejarah, siswa akan lebih mudah memahami dan menginternalisasi nilai-nilai perjuangan,\" ujar Waka Kurikulum.",
                'penulis'   => 'Tim Jurnalistik Siswa',
                'status'    => 'published',
                'published_at' => now()->subDays(20),
            ],
            [
                'judul'     => 'Tata Cara Pengisian Formulir PPDB Online 2026/2027',
                'kategori'  => 'Panduan',
                'isi'       => "Bagi calon siswa yang akan mendaftar ke SMA DigiEdu Banyuwangi, berikut adalah panduan lengkap pengisian formulir PPDB online.\n\nLangkah-langkah pendaftaran:\n1. Siapkan dokumen yang diperlukan (scan/foto)\n2. Kunjungi website resmi PPDB sekolah\n3. Klik menu Daftar Sekarang\n4. Isi data diri dengan lengkap dan benar\n5. Upload dokumen yang dipersyaratkan\n6. Simpan nomor registrasi yang diberikan sistem\n7. Cetak kartu pendaftaran\n\nDokumen yang diperlukan:\n- Scan ijazah/SKHUN SMP (atau surat keterangan lulus)\n- Foto kartu keluarga\n- Pas foto terbaru ukuran 3x4\n- Rapor semester 1-5\n\nJika mengalami kesulitan, hubungi panitia PPDB melalui WhatsApp di nomor yang tertera di website.",
                'penulis'   => 'Panitia PPDB',
                'status'    => 'published',
                'published_at' => now()->subDays(25),
            ],
        ];

        foreach ($artikels as $a) {
            DB::table('artikels')->insert(array_merge($a, [
                'slug'       => Str::slug($a['judul']),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        echo "✅ Artikel seeded (" . count($artikels) . " artikel)\n";
    }
}
PHP;

// ============================================================
// TULIS SEMUA FILE
// ============================================================
$success = 0;
foreach ($files as $path => $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    if (file_put_contents($path, $content) !== false) {
        echo "✅ $path\n";
        $success++;
    } else {
        echo "❌ GAGAL: $path\n";
    }
}

echo "\n========================================\n";
echo "Selesai! $success file ditulis.\n";
echo "Jalankan: php artisan db:seed\n";
echo "========================================\n";