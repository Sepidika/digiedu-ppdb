<?php

// Fix PendaftarSeeder
file_put_contents('database/seeders/PendaftarSeeder.php', <<<'PHP'
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
        ];

        $jalurList   = ['Zonasi', 'Prestasi Akademik', 'Afirmasi'];
        $jurusanList = ['MIPA', 'IPS'];
        $statusList  = ['Diterima','Diterima','Diterima','Menunggu','Menunggu','Ditolak'];
        $genderList  = ['Laki-Laki', 'Perempuan'];

        $rows = [];
        foreach ($namaList as $i => $nama) {
            $status = $statusList[array_rand($statusList)];
            $nisn   = '00' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            $noReg  = 'PPDB-2026-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            $rows[] = [
                'no_reg'        => $noReg,
                'nisn'          => $nisn,
                'nama'          => $nama,
                'tempat_lahir'  => 'Banyuwangi',
                'tanggal_lahir' => date('Y-m-d', strtotime('-' . rand(14,16) . ' years -' . rand(0,364) . ' days')),
                'jenis_kelamin' => $genderList[array_rand($genderList)],
                'alamat'        => 'Jl. ' . ['Melati','Mawar','Anggrek','Dahlia'][rand(0,3)] . ' No.' . rand(1,50) . ', Banyuwangi',
                'asal_sekolah'  => $sekolahList[array_rand($sekolahList)],
                'jalur'         => $jalurList[array_rand($jalurList)],
                'jurusan'       => $jurusanList[array_rand($jurusanList)],
                'nilai_rata'    => number_format(rand(750,950)/10, 2),
                'status'        => $status,
                'catatan_admin' => $status === 'Ditolak' ? 'Berkas tidak lengkap, ijazah belum dilegalisir.' : null,
                'created_at'    => now()->subDays(rand(1,30)),
                'updated_at'    => now(),
            ];
        }

        DB::table('pendaftars')->insert($rows);
        echo '✅ Pendaftar seeded (' . count($rows) . ' data)' . PHP_EOL;
    }
}
PHP);

// Fix ArtikelSeeder — sesuaikan kategori dengan enum
file_put_contents('database/seeders/ArtikelSeeder.php', <<<'PHP'
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
                'judul'        => 'Jadwal Ujian Masuk PPDB Gelombang 1 Resmi Dibuka',
                'kategori'     => 'Pengumuman',
                'isi'          => "Panitia PPDB SMA DigiEdu Banyuwangi mengumumkan jadwal ujian masuk Gelombang 1 Tahun Ajaran 2026/2027 telah resmi ditetapkan.\n\nUjian dilaksanakan secara Computer Based Test (CBT) di laboratorium komputer sekolah. Peserta wajib hadir 30 menit sebelum ujian dengan membawa kartu peserta.\n\nMateri ujian meliputi Tes Potensi Akademik, Bahasa Indonesia, Matematika, dan Bahasa Inggris.\n\nInformasi lebih lanjut hubungi panitia PPDB melalui WhatsApp atau datang ke sekretariat.",
                'penulis'      => 'Panitia PPDB',
                'status'       => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'judul'        => 'SMA DigiEdu Raih Juara 1 Olimpiade Sains Nasional Tingkat Provinsi',
                'kategori'     => 'Kegiatan Sekolah',
                'isi'          => "Kebanggaan besar datang dari SMA DigiEdu Banyuwangi. Tim siswa kami berhasil meraih Juara 1 Olimpiade Sains Nasional (OSN) bidang Matematika tingkat Provinsi Jawa Timur.\n\nPrestasi ini diraih oleh Muhammad Rizki (Kelas XI MIPA 2) setelah bersaing ketat dengan ratusan peserta dari seluruh Jawa Timur.\n\nMuhammad Rizki akan mewakili Jawa Timur di OSN tingkat nasional bulan Juli mendatang.",
                'penulis'      => 'Humas Sekolah',
                'status'       => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'judul'        => 'Program Beasiswa Penuh untuk Siswa Berprestasi 2026/2027',
                'kategori'     => 'Pengumuman',
                'isi'          => "SMA DigiEdu Banyuwangi membuka program beasiswa penuh bagi calon siswa berprestasi dari keluarga kurang mampu.\n\nProgram mencakup pembebasan SPP selama 3 tahun, tunjangan buku, dan akses fasilitas penuh.\n\nSyarat: nilai rapor minimal 85, surat keterangan tidak mampu, fotokopi KK, dan surat rekomendasi kepala sekolah asal.\n\nPendaftaran dilakukan bersamaan dengan PPDB reguler.",
                'penulis'      => 'Panitia PPDB',
                'status'       => 'published',
                'published_at' => now()->subDays(15),
            ],
            [
                'judul'        => 'Kunjungan Edukatif ke Museum Blambangan',
                'kategori'     => 'Kegiatan Sekolah',
                'isi'          => "Siswa kelas X SMA DigiEdu Banyuwangi melaksanakan kunjungan edukatif ke Museum Blambangan sebagai bagian implementasi Kurikulum Merdeka.\n\nKegiatan ini bertujuan mendekatkan siswa dengan sejarah lokal Banyuwangi dan Kerajaan Blambangan.\n\nSiswa mengamati langsung koleksi artefak dan prasasti, serta berdialog dengan kurator museum.",
                'penulis'      => 'Tim Jurnalistik Siswa',
                'status'       => 'published',
                'published_at' => now()->subDays(20),
            ],
            [
                'judul'        => 'Tata Cara Pengisian Formulir PPDB Online 2026/2027',
                'kategori'     => 'Pengumuman',
                'isi'          => "Panduan lengkap pengisian formulir PPDB online SMA DigiEdu Banyuwangi.\n\nLangkah pendaftaran:\n1. Siapkan dokumen (scan/foto)\n2. Kunjungi website resmi PPDB\n3. Isi data diri lengkap\n4. Upload dokumen\n5. Simpan nomor registrasi\n6. Cetak kartu pendaftaran\n\nDokumen diperlukan: ijazah/SKHUN, KK, pas foto 3x4, rapor semester 1-5.\n\nKesulitan? Hubungi panitia via WhatsApp.",
                'penulis'      => 'Panitia PPDB',
                'status'       => 'published',
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

        echo '✅ Artikel seeded (' . count($artikels) . ' artikel)' . PHP_EOL;
    }
}
PHP);

echo "✅ Semua seeder fixed!\n";