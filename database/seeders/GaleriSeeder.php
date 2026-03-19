<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('galeris')->truncate();

        $data = [
            ['judul' => 'Upacara Bendera Hari Senin', 'kategori' => 'Kegiatan Akademik'],
            ['judul' => 'Lomba Debat Antar Kelas', 'kategori' => 'Kegiatan Akademik'],
            ['judul' => 'Latihan Pramuka', 'kategori' => 'Ekstrakurikuler'],
            ['judul' => 'Tim Basket Sekolah', 'kategori' => 'Ekstrakurikuler'],
            ['judul' => 'Juara OSN Matematika', 'kategori' => 'Prestasi'],
            ['judul' => 'Laboratorium Komputer', 'kategori' => 'Fasilitas'],
            ['judul' => 'Perpustakaan Sekolah', 'kategori' => 'Fasilitas'],
            ['judul' => 'Lapangan Olahraga', 'kategori' => 'Fasilitas'],
        ];

        foreach ($data as $d) {
            DB::table('galeris')->insert([
                'judul'      => $d['judul'],
                'file'       => 'galeri/placeholder.jpg',
                'tipe'       => 'foto',
                'kategori'   => $d['kategori'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo '✅ Galeri seeded (8 item, placeholder)' . PHP_EOL;
    }
}