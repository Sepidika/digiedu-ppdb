<?php
/**
 * DigiEdu PPDB - Public Frontend Writer
 * Jalankan: php write-public.php
 */

$files = [];

// ============================================================
// 1. PublicController.php
// ============================================================
$files['app/Http/Controllers/PublicController.php'] = <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Banner;
use App\Models\Galeri;
use App\Models\Pendaftar;
use App\Models\Pengaturan;
use App\Models\JadwalPpdb;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $settings    = $this->getSettings();
        $banners     = Banner::where('aktif', true)->orderBy('urutan')->get();
        $artikels    = Artikel::where('status', 'published')->latest('published_at')->take(3)->get();
        $galeris     = Galeri::latest()->take(8)->get();
        $jadwals     = JadwalPpdb::orderBy('tahap')->get();
        $stats = [
            'total'    => Pendaftar::count(),
            'diterima' => Pendaftar::where('status', 'Diterima')->count(),
        ];

        return view('public.index', compact(
            'settings', 'banners', 'artikels', 'galeris', 'jadwals', 'stats'
        ));
    }

    public function cekStatus(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
        ]);

        $pendaftar = Pendaftar::where('nisn', $request->nisn)->first();

        return view('public.cek-status', compact('pendaftar'));
    }

    public function artikel(Artikel $artikel)
    {
        if ($artikel->status !== 'published') abort(404);
        $lainnya = Artikel::where('status', 'published')
            ->where('id', '!=', $artikel->id)
            ->latest('published_at')->take(3)->get();
        $settings = $this->getSettings();
        return view('public.artikel', compact('artikel', 'lainnya', 'settings'));
    }

    private function getSettings(): array
    {
        return [
            'nama_sekolah'    => Pengaturan::get('nama_sekolah',    'DigiEdu School Banyuwangi'),
            'email_ppdb'      => Pengaturan::get('email_ppdb',      'info@digiedu.sch.id'),
            'no_wa_admin'     => Pengaturan::get('no_wa_admin',     '81234567890'),
            'alamat'          => Pengaturan::get('alamat',          'Jl. Jenderal Sudirman No. 45'),
            'kuota_mipa'      => Pengaturan::get('kuota_mipa',      150),
            'kuota_ips'       => Pengaturan::get('kuota_ips',       150),
            'tahun_ajaran'    => Pengaturan::get('tahun_ajaran',    '2026/2027'),
            'gelombang_aktif' => Pengaturan::get('gelombang_aktif', 'Gelombang 1'),
        ];
    }
}
PHP;

// ============================================================
// 2. Tambah routes public ke web.php
// ============================================================
$routeAppend = <<<'ROUTE'

// ─── Halaman Publik ──────────────────────────────────────────
Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])->name('public.index');
Route::post('/cek-status', [App\Http\Controllers\PublicController::class, 'cekStatus'])->name('public.cek-status');
Route::get('/artikel/{artikel:slug}', [App\Http\Controllers\PublicController::class, 'artikel'])->name('public.artikel');
ROUTE;

$webPhp = file_get_contents('routes/web.php');
// Ganti redirect lama ke admin dengan route publik
$webPhp = str_replace(
    "Route::get('/', fn() => redirect()->route('admin.dashboard'));",
    "// Route ini dipindah ke PublicController — lihat bagian bawah file",
    $webPhp
);

if (!str_contains($webPhp, 'PublicController')) {
    $webPhp .= $routeAppend;
}
file_put_contents('routes/web.php', $webPhp);
echo "✅ routes/web.php diupdate\n";

// ============================================================
// 3. Buat folder views/public
// ============================================================
foreach (['resources/views/public'] as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0755, true);
}

// ============================================================
// 4. Layout publik
// ============================================================
$files['resources/views/public/layout.blade.php'] = <<<'BLADE'
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings['nama_sekolah']) - PPDB {{ $settings['tahun_ajaran'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="text-slate-800 bg-white">

    {{-- Tombol WA Melayang --}}
    <div class="fixed bottom-5 right-5 z-[100] group flex items-center">
        <div class="absolute right-14 bg-white px-3 py-2 rounded-xl shadow-lg border border-slate-100 text-xs font-bold text-slate-700 opacity-0 group-hover:opacity-100 transition-all whitespace-nowrap pointer-events-none">
            Tanya PPDB? Chat Kami!
        </div>
        <a href="https://wa.me/62{{ $settings['no_wa_admin'] }}" target="_blank"
            class="relative bg-[#25D366] text-white w-13 h-13 w-14 h-14 rounded-full flex items-center justify-center shadow-xl hover:scale-110 transition-all">
            <span class="absolute inset-0 rounded-full bg-[#25D366] animate-ping opacity-40"></span>
            <svg class="w-7 h-7 z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
    </div>

    {{-- Navbar --}}
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-lg border-b border-slate-100 shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 md:h-20 items-center">
                <a href="{{ route('public.index') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold text-lg">D</div>
                    <span class="font-extrabold text-xl text-slate-800">DigiEdu<span class="text-blue-600">.</span></span>
                </a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('public.index') }}#profil" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Profil</a>
                    <a href="{{ route('public.index') }}#fasilitas" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Program</a>
                    <a href="{{ route('public.index') }}#jadwal" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Jadwal PPDB</a>
                    <a href="{{ route('public.index') }}#cek-status" class="bg-slate-900 text-white px-5 py-2.5 rounded-full font-bold hover:bg-blue-600 transition text-sm shadow-lg">Cek Status</a>
                </div>
                <button id="mobile-btn" class="md:hidden text-slate-600 p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 shadow-lg">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('public.index') }}#profil" class="mobile-link block px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 font-semibold text-sm">Profil</a>
                <a href="{{ route('public.index') }}#fasilitas" class="mobile-link block px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 font-semibold text-sm">Program</a>
                <a href="{{ route('public.index') }}#jadwal" class="mobile-link block px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 font-semibold text-sm">Jadwal PPDB</a>
                <a href="{{ route('public.index') }}#cek-status" class="mobile-link block px-3 py-2.5 rounded-lg bg-blue-600 text-white font-bold text-sm text-center mt-2">Cek Status Pendaftaran</a>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 mt-16">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-cyan-400 to-blue-600"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center text-white font-bold">D</div>
                        <span class="font-extrabold text-xl text-white">DigiEdu<span class="text-blue-400">.</span></span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">{{ $settings['nama_sekolah'] }} — Mencetak generasi kritis, berbudaya, dan siap menghadapi tantangan global.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('public.index') }}" class="hover:text-blue-400 transition">Beranda</a></li>
                        <li><a href="{{ route('public.index') }}#jadwal" class="hover:text-blue-400 transition">Jadwal PPDB</a></li>
                        <li><a href="{{ route('public.index') }}#cek-status" class="text-cyan-400 font-semibold hover:text-cyan-300 transition">Cek Status</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-blue-400 transition">Portal Admin</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li>{{ $settings['alamat'] }}</li>
                        <li>{{ $settings['email_ppdb'] }}</li>
                        <li>+62 {{ $settings['no_wa_admin'] }}</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>© {{ date('Y') }} {{ $settings['nama_sekolah'] }}. Hak cipta dilindungi.</p>
                <a href="{{ route('admin.login') }}" class="hover:text-white transition">Panel Admin →</a>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu
        const btn = document.getElementById('mobile-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => menu.classList.toggle('hidden'));
        document.querySelectorAll('.mobile-link').forEach(l => l.addEventListener('click', () => menu.classList.add('hidden')));

        // Navbar scroll
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.classList.remove('bg-white/90');
                nav.classList.add('bg-white/98', 'shadow-md');
            } else {
                nav.classList.add('bg-white/90');
                nav.classList.remove('bg-white/98', 'shadow-md');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
BLADE;

// ============================================================
// 5. Halaman utama publik
// ============================================================
$files['resources/views/public/index.blade.php'] = <<<'BLADE'
@extends('public.layout')
@section('title', 'Beranda')

@section('content')
{{-- Hero --}}
<section class="pt-32 pb-16 lg:pt-44 lg:pb-24 px-4 w-full max-w-7xl mx-auto flex flex-col items-center text-center relative">
    <div class="absolute top-0 left-[-10%] w-96 h-96 rounded-full bg-blue-200 opacity-20 blur-[80px] -z-10"></div>
    <div class="absolute top-[20%] right-[-10%] w-80 h-80 rounded-full bg-cyan-200 opacity-20 blur-[80px] -z-10"></div>

    <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-blue-700 font-semibold text-sm mb-6 shadow-sm">
        <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
        Pendaftaran {{ $settings['tahun_ajaran'] }} — {{ $settings['gelombang_aktif'] }} Dibuka
    </div>

    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-slate-900 tracking-tight leading-tight mb-5">
        Pendidikan Berkualitas<br class="hidden md:block">
        untuk <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Generasi Masa Depan</span>
    </h1>

    <p class="text-base md:text-lg text-slate-500 max-w-2xl mb-8 leading-relaxed">
        {{ $settings['nama_sekolah'] }} — Membangun karakter kebangsaan dan wawasan global dengan sistem pembelajaran modern yang terintegrasi.
    </p>

    <div class="flex flex-col sm:flex-row gap-4">
        <a href="#cek-status" class="px-8 py-4 rounded-full bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold shadow-xl shadow-blue-500/30 hover:scale-105 transition">
            Cek Status Pendaftaran
        </a>
        <a href="#jadwal" class="px-8 py-4 rounded-full bg-white text-slate-700 font-bold shadow-lg border border-slate-100 hover:bg-slate-50 transition">
            Lihat Jadwal PPDB
        </a>
    </div>
</section>

{{-- Stats --}}
<section class="py-12 bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div class="p-4">
            <h3 class="text-4xl md:text-5xl font-extrabold text-white mb-1">{{ $stats['total'] }}<span class="text-blue-500">+</span></h3>
            <p class="text-slate-400 text-xs uppercase tracking-widest font-bold">Total Pendaftar</p>
        </div>
        <div class="p-4">
            <h3 class="text-4xl md:text-5xl font-extrabold text-white mb-1">{{ $stats['diterima'] }}<span class="text-blue-500">+</span></h3>
            <p class="text-slate-400 text-xs uppercase tracking-widest font-bold">Siswa Diterima</p>
        </div>
        <div class="p-4">
            <h3 class="text-4xl md:text-5xl font-extrabold text-white mb-1">{{ $settings['kuota_mipa'] }}<span class="text-blue-500">+</span></h3>
            <p class="text-slate-400 text-xs uppercase tracking-widest font-bold">Kuota MIPA</p>
        </div>
        <div class="p-4">
            <h3 class="text-4xl md:text-5xl font-extrabold text-white mb-1">{{ $settings['kuota_ips'] }}<span class="text-blue-500">+</span></h3>
            <p class="text-slate-400 text-xs uppercase tracking-widest font-bold">Kuota IPS</p>
        </div>
    </div>
</section>

{{-- Jadwal PPDB --}}
<section id="jadwal" class="py-16 md:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-blue-600 font-bold tracking-wider uppercase text-xs md:text-sm">Timeline</span>
            <h2 class="mt-2 text-2xl md:text-4xl font-extrabold text-slate-900">Jadwal PPDB {{ $settings['tahun_ajaran'] }}</h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach($jadwals as $jadwal)
            <div class="flex items-center gap-5 p-5 {{ $jadwal->status == 'aktif' ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/20' : ($jadwal->status == 'selesai' ? 'bg-white border border-slate-200 opacity-60' : 'bg-white border border-slate-200') }} rounded-2xl transition">
                <div class="w-12 h-12 {{ $jadwal->status == 'aktif' ? 'bg-white/20' : 'bg-slate-100' }} rounded-xl flex items-center justify-center font-extrabold text-lg {{ $jadwal->status == 'aktif' ? 'text-white' : 'text-slate-600' }} shrink-0">{{ $jadwal->tahap }}</div>
                <div class="flex-1">
                    <p class="text-xs font-bold {{ $jadwal->status == 'aktif' ? 'text-blue-100' : 'text-slate-400' }} uppercase">Tahap {{ $jadwal->tahap }}</p>
                    <h4 class="font-extrabold text-base {{ $jadwal->status == 'aktif' ? 'text-white' : 'text-slate-800' }}">{{ $jadwal->nama_tahap }}</h4>
                    <p class="text-xs {{ $jadwal->status == 'aktif' ? 'text-blue-100' : 'text-slate-500' }} mt-0.5">
                        {{ $jadwal->tanggal_mulai?->format('d M Y') }}
                        @if($jadwal->tanggal_selesai && $jadwal->tanggal_selesai != $jadwal->tanggal_mulai)
                            — {{ $jadwal->tanggal_selesai?->format('d M Y') }}
                        @endif
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold {{ $jadwal->status == 'aktif' ? 'bg-white text-blue-600' : ($jadwal->status == 'selesai' ? 'bg-slate-200 text-slate-600' : 'bg-slate-100 text-slate-500') }}">
                    {{ strtoupper($jadwal->status) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Cek Status --}}
<section id="cek-status" class="py-16 md:py-20 bg-white">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <span class="text-blue-600 font-bold tracking-wider uppercase text-xs md:text-sm">Portal Pendaftar</span>
        <h2 class="mt-2 text-2xl md:text-4xl font-extrabold text-slate-900 mb-4">Cek Status Pendaftaran</h2>
        <p class="text-slate-500 text-sm mb-8">Masukkan NISN kamu untuk melihat status verifikasi berkas dan hasil seleksi.</p>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
            @if(session('cek_error'))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm font-semibold">
                {{ session('cek_error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('public.cek-status') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2 text-left">Nomor Induk Siswa Nasional (NISN)</label>
                    <input type="text" name="nisn" placeholder="Contoh: 0081234567" required
                        class="w-full px-5 py-4 border-2 border-slate-200 rounded-2xl text-base font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-center tracking-widest">
                    @error('nisn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-4 rounded-2xl font-extrabold hover:from-blue-700 hover:to-blue-600 transition shadow-lg shadow-blue-500/30">
                    Cek Status Sekarang
                </button>
            </form>
        </div>
    </div>
</section>

{{-- Artikel --}}
@if($artikels->count() > 0)
<section id="berita" class="py-16 md:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-end mb-10">
            <div>
                <span class="text-blue-600 font-bold tracking-wider uppercase text-xs md:text-sm">Mading Digital</span>
                <h2 class="mt-1 text-2xl md:text-3xl font-extrabold text-slate-900">Berita & Pengumuman</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($artikels as $a)
            <a href="{{ route('public.artikel', $a->slug) }}" class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-lg border border-slate-100 cursor-pointer transition block">
                <div class="h-44 bg-slate-200 rounded-xl mb-4 overflow-hidden relative">
                    @if($a->foto_cover)
                        <img src="{{ asset('storage/'.$a->foto_cover) }}" alt="{{ $a->judul }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-100">
                            <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $a->kategori }}</span>
                </div>
                <h3 class="font-bold text-slate-900 mb-2 line-clamp-2 text-sm md:text-base">{{ $a->judul }}</h3>
                <p class="text-slate-500 text-xs">{{ $a->penulis }} • {{ $a->published_at?->format('d M Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
BLADE;

// ============================================================
// 6. Halaman Cek Status
// ============================================================
$files['resources/views/public/cek-status.blade.php'] = <<<'BLADE'
@extends('public.layout')
@section('title', 'Cek Status Pendaftaran')

@section('content')
<div class="pt-32 pb-16 min-h-screen px-4">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900">Hasil Cek Status</h1>
            <p class="text-slate-500 mt-2">Status pendaftaran PPDB {{ date('Y') }}/{{ date('Y')+1 }}</p>
        </div>

        @if($pendaftar)
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            {{-- Header status --}}
            <div class="p-6 {{ $pendaftar->status == 'Diterima' ? 'bg-gradient-to-r from-green-500 to-emerald-400' : ($pendaftar->status == 'Ditolak' ? 'bg-gradient-to-r from-red-500 to-rose-400' : 'bg-gradient-to-r from-amber-500 to-yellow-400') }} text-white text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-extrabold">
                    {{ substr($pendaftar->nama, 0, 1) }}
                </div>
                <h2 class="text-xl font-extrabold">{{ $pendaftar->nama }}</h2>
                <p class="text-white/80 text-sm mt-1">{{ $pendaftar->no_reg }}</p>
                <div class="mt-4 inline-block bg-white/20 backdrop-blur px-6 py-2 rounded-full font-extrabold text-sm">
                    @if($pendaftar->status == 'Diterima') ✅ DITERIMA
                    @elseif($pendaftar->status == 'Ditolak') ❌ BERKAS DITOLAK
                    @else ⏳ MENUNGGU VERIFIKASI
                    @endif
                </div>
            </div>

            {{-- Detail --}}
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">NISN</p>
                        <p class="font-extrabold text-slate-800">{{ $pendaftar->nisn }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Asal Sekolah</p>
                        <p class="font-semibold text-slate-800">{{ $pendaftar->asal_sekolah }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Jalur</p>
                        <p class="font-bold text-blue-600">{{ $pendaftar->jalur }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Jurusan</p>
                        <p class="font-bold text-blue-600">{{ $pendaftar->jurusan }}</p>
                    </div>
                    @if($pendaftar->nilai_rata)
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Nilai Rata-rata</p>
                        <p class="font-extrabold text-slate-800">{{ $pendaftar->nilai_rata }}</p>
                    </div>
                    @endif
                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Tanggal Daftar</p>
                        <p class="font-semibold text-slate-800">{{ $pendaftar->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                @if($pendaftar->status == 'Ditolak' && $pendaftar->catatan_admin)
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <p class="text-xs font-bold text-red-600 uppercase mb-1">Alasan Penolakan</p>
                    <p class="text-sm text-red-700">{{ $pendaftar->catatan_admin }}</p>
                </div>
                @endif

                @if($pendaftar->status == 'Menunggu')
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                    <p class="text-sm font-semibold text-amber-700">Berkas kamu sedang dalam proses verifikasi oleh panitia. Harap tunggu pengumuman resmi.</p>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-10 text-center">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-xl font-extrabold text-slate-700 mb-2">NISN Tidak Ditemukan</h3>
            <p class="text-slate-500 text-sm mb-6">Data dengan NISN tersebut tidak ada dalam sistem PPDB kami. Pastikan NISN yang dimasukkan sudah benar.</p>
        </div>
        @endif

        <div class="mt-6 text-center">
            <a href="{{ route('public.index') }}#cek-status" class="text-blue-600 font-bold hover:underline text-sm">← Cek NISN Lain</a>
        </div>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// 7. Halaman detail artikel
// ============================================================
$files['resources/views/public/artikel.blade.php'] = <<<'BLADE'
@extends('public.layout')
@section('title', $artikel->judul)

@section('content')
<div class="pt-28 pb-16 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-slate-400 font-semibold mb-6">
            <a href="{{ route('public.index') }}" class="hover:text-blue-600">Beranda</a>
            <span>/</span>
            <span class="text-slate-600">{{ $artikel->judul }}</span>
        </div>

        {{-- Cover --}}
        @if($artikel->foto_cover)
        <div class="h-64 md:h-96 rounded-3xl overflow-hidden mb-8 shadow-xl">
            <img src="{{ asset('storage/'.$artikel->foto_cover) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
        </div>
        @endif

        {{-- Meta --}}
        <div class="flex items-center gap-3 mb-4">
            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">{{ $artikel->kategori }}</span>
            <span class="text-slate-400 text-xs">{{ $artikel->penulis }}</span>
            <span class="text-slate-400 text-xs">•</span>
            <span class="text-slate-400 text-xs">{{ $artikel->published_at?->format('d M Y') }}</span>
        </div>

        {{-- Judul --}}
        <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-8 leading-tight">{{ $artikel->judul }}</h1>

        {{-- Isi --}}
        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-base">
            {!! nl2br(e($artikel->isi)) !!}
        </div>

        {{-- Artikel lainnya --}}
        @if($lainnya->count() > 0)
        <div class="mt-16 pt-8 border-t border-slate-100">
            <h3 class="text-lg font-extrabold text-slate-900 mb-6">Artikel Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($lainnya as $a)
                <a href="{{ route('public.artikel', $a->slug) }}" class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md border border-slate-100 transition block">
                    <div class="h-32 bg-slate-200 rounded-xl mb-3 overflow-hidden">
                        @if($a->foto_cover)
                            <img src="{{ asset('storage/'.$a->foto_cover) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <h4 class="font-bold text-sm text-slate-800 line-clamp-2">{{ $a->judul }}</h4>
                    <p class="text-xs text-slate-400 mt-1">{{ $a->published_at?->format('d M Y') }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
BLADE;

// ============================================================
// TULIS SEMUA FILE
// ============================================================
$success = 0;
foreach ($files as $path => $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    if (file_put_contents($path, $content) !== false) {
        echo "✅ $path\n";
        $success++;
    } else {
        echo "❌ GAGAL: $path\n";
    }
}

// Update routes
file_put_contents('routes/web.php', file_get_contents('routes/web.php'));

echo "\n========================================\n";
echo "Selesai! $success file berhasil ditulis.\n";
echo "========================================\n";
echo "Buka: http://digiedu-ppdb.test\n";
echo "Cek status: http://digiedu-ppdb.test/cek-status\n";