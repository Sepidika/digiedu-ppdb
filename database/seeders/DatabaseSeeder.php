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
            GaleriSeeder::class,
        ]);
    }
}