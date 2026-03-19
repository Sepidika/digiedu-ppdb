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