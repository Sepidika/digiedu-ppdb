<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('no_reg')->unique()->nullable(); // Auto: PPDB-2026-001
            $table->string('nisn', 20)->unique();
            $table->string('nik', 20)->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('asal_sekolah');
            $table->enum('jalur', ['Zonasi', 'Prestasi Akademik', 'Afirmasi']);
            $table->enum('jurusan', ['MIPA', 'IPS']);
            $table->string('nama_wali')->nullable();
            $table->string('no_wa')->nullable();
            $table->decimal('nilai_rata', 5, 2)->nullable();
            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->string('foto_kk')->nullable();
            $table->string('foto_ijazah')->nullable();
            $table->string('foto_rapor')->nullable();
            $table->string('foto_siswa')->nullable();
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();
            $table->timestamp('diverifikasi_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};