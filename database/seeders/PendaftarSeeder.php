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