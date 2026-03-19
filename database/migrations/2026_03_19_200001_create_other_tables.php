<?php
// FILE: database/migrations/2026_03_19_200001_create_artikels_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('isi');
            $table->string('foto_cover')->nullable();
            $table->enum('kategori', ['Pengumuman', 'Esai / Jurnal Siswa', 'Kegiatan Sekolah']);
            $table->string('penulis');
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('file');
            $table->enum('tipe', ['foto', 'video'])->default('foto');
            $table->enum('kategori', ['Kegiatan Akademik', 'Ekstrakurikuler', 'Prestasi', 'Fasilitas']);
            $table->unsignedBigInteger('diupload_oleh')->nullable();
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('file');
            $table->integer('urutan')->default(1);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('jadwal_ppdb', function (Blueprint $table) {
            $table->id();
            $table->integer('tahap');
            $table->string('nama_tahap');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['belum', 'aktif', 'selesai'])->default('belum');
            $table->timestamps();
        });

        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikels');
        Schema::dropIfExists('galeris');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('jadwal_ppdb');
        Schema::dropIfExists('pengaturan');
    }
};