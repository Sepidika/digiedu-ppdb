<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal_ppdb')->truncate();
        DB::table('jadwal_ppdb')->insert([
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
