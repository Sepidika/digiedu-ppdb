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
                'role'          => 'super_admin',
                'status'        => 'aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama'          => 'Operator PPDB',
                'email'         => 'operator@digiedu.sch.id',
                'password'      => Hash::make('password123'),
                'role'          => 'operator_verifikasi',
                'status'        => 'aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ], ['email'], ['nama', 'password', 'role', 'status', 'updated_at']);

        echo "✅ Admin seeded\n";
    }
}
