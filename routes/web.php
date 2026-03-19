<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // <-- Tambahan untuk form pendaftaran
use App\Models\Pendaftar;    // <-- Tambahan untuk insert database pendaftar baru
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\KartuController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\TestimoniController;

// Route ini dipindah ke PublicController — lihat bagian bawah file

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('pendaftar', PendaftarController::class)->except(['show']);
        Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::post('/verifikasi/{id}/setuju', [VerifikasiController::class, 'setuju'])->name('verifikasi.setuju');
        Route::post('/verifikasi/{id}/tolak',  [VerifikasiController::class, 'tolak'])->name('verifikasi.tolak');
        Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::post('/pengumuman/publish', [PengumumanController::class, 'publish'])->name('pengumuman.publish');
        Route::post('/pengumuman/{id}/notif', [PengumumanController::class, 'kirimNotif'])->name('pengumuman.notif');
        Route::get('/kartu', [KartuController::class, 'index'])->name('kartu.index');
        Route::get('/kartu/semua', [KartuController::class, 'cetakSemua'])->name('kartu.semua');
        Route::get('/kartu/{id}/cetak', [KartuController::class, 'cetak'])->name('kartu.cetak');
        Route::get('/kartu/{id}/pdf', [KartuController::class, 'exportPdf'])->name('kartu.pdf');
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::resource('artikel', ArtikelController::class)->except(['show']);
        Route::resource('galeri', GaleriController::class)->except(['show','edit','update']);
        Route::resource('banner', BannerController::class)->except(['show','edit','update']);
        Route::resource('admin-user', AdminUserController::class)->except(['show']);
        Route::get('/log', [LogController::class, 'index'])->name('log.index');
        Route::get('/log/export', [LogController::class, 'export'])->name('log.export');
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup/jalankan', [BackupController::class, 'jalankan'])->name('backup.jalankan');
        Route::get('/backup/excel', [BackupController::class, 'exportExcel'])->name('backup.excel');
        Route::get('/backup/pdf', [BackupController::class, 'exportPdf'])->name('backup.pdf');
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::resource('testimoni', TestimoniController::class)->only(['index','store','update','destroy']);    
    });
});

// ─── Halaman Publik ───────────────────────────────────────────
Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])->name('public.index');
Route::post('/cek-status', [App\Http\Controllers\PublicController::class, 'cekStatus'])->name('public.cek-status');
Route::get('/artikel/{artikel:slug}', [App\Http\Controllers\PublicController::class, 'artikel'])->name('public.artikel');

// ─── RUTE TAMBAHAN UNTUK FORM PENDAFTARAN SISWA ───────────────────────────────────────────
Route::get('/daftar', [App\Http\Controllers\PublicController::class, 'daftar'])->name('public.daftar');
Route::post('/daftar', [App\Http\Controllers\PublicController::class, 'storeDaftar'])->name('public.daftar.post');

// Redirect /admin ke /admin/login
Route::get('/admin', fn() => redirect()->route('admin.login'));

Route::get('/berita', [App\Http\Controllers\PublicController::class, 'artikelList'])->name('public.artikel-list');

// ─── CETAK KARTU PDF SISWA LOLOS ───────────────────────────────────────────
Route::get('/cetak-kartu/{id}', [App\Http\Controllers\PublicController::class, 'cetakKartu'])->name('public.cetak-kartu');