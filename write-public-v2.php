<?php
/**
 * DigiEdu PPDB - Public Frontend v2 (Full Template)
 * Jalankan: php write-public-v2.php
 */

$files = [];

// ============================================================
// 1. Update PublicController.php — tambah data sambutan & stats dari settings
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
        $settings = $this->getSettings();
        $banners  = Banner::where('aktif', true)->orderBy('urutan')->get();
        $artikels = Artikel::where('status', 'published')->latest('published_at')->take(3)->get();
        $galeris  = Galeri::latest()->take(8)->get();
        $jadwals  = JadwalPpdb::orderBy('tahap')->get();
        $stats = [
            'total'     => Pendaftar::count(),
            'diterima'  => Pendaftar::where('status', 'Diterima')->count(),
            'pendidik'  => Pengaturan::get('jumlah_pendidik',  '50'),
            'alumni'    => Pengaturan::get('jumlah_alumni',    '2000'),
            'eskul'     => Pengaturan::get('jumlah_eskul',     '35'),
            'prestasi'  => Pengaturan::get('jumlah_prestasi',  '150'),
        ];

        return view('public.index', compact(
            'settings', 'banners', 'artikels', 'galeris', 'jadwals', 'stats'
        ));
    }

    public function cekStatus(Request $request)
    {
        $request->validate(['nisn' => 'required|string'], ['nisn.required' => 'NISN wajib diisi.']);
        $pendaftar = Pendaftar::where('nisn', $request->nisn)->first();
        return view('public.cek-status', compact('pendaftar'));
    }

    public function artikel(Artikel $artikel)
    {
        if ($artikel->status !== 'published') abort(404);
        $lainnya  = Artikel::where('status', 'published')->where('id', '!=', $artikel->id)->latest('published_at')->take(3)->get();
        $settings = $this->getSettings();
        return view('public.artikel', compact('artikel', 'lainnya', 'settings'));
    }

    private function getSettings(): array
    {
        return [
            'nama_sekolah'      => Pengaturan::get('nama_sekolah',      'DigiEdu School Banyuwangi'),
            'email_ppdb'        => Pengaturan::get('email_ppdb',        'info@digiedu.sch.id'),
            'no_wa_admin'       => Pengaturan::get('no_wa_admin',       '81234567890'),
            'alamat'            => Pengaturan::get('alamat',            'Jl. Jenderal Sudirman No. 45, Banyuwangi, Jawa Timur 68411'),
            'kuota_mipa'        => Pengaturan::get('kuota_mipa',        '150'),
            'kuota_ips'         => Pengaturan::get('kuota_ips',         '150'),
            'tahun_ajaran'      => Pengaturan::get('tahun_ajaran',      '2026/2027'),
            'gelombang_aktif'   => Pengaturan::get('gelombang_aktif',   'Gelombang 1'),
            'kepsek_nama'       => Pengaturan::get('kepsek_nama',       'Dr. Kepala Sekolah, M.Pd.'),
            'kepsek_sambutan'   => Pengaturan::get('kepsek_sambutan',   'Kami merancang kurikulum tidak hanya untuk mencetak siswa cerdas, tapi juga peduli terhadap sejarah dan budaya bangsa.'),
            'kepsek_foto'       => Pengaturan::get('kepsek_foto',       ''),
            'maps_embed'        => Pengaturan::get('maps_embed',        'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126362.47461971701!2d114.2885918731307!3d-8.214088904576135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1451910248e35%3A0xc6e462c8282ea8e0!2sBanyuwangi!5e0!3m2!1sen!2sid!4v1700000000000'),
            'instagram_url'     => Pengaturan::get('instagram_url',     '#'),
            'youtube_url'       => Pengaturan::get('youtube_url',       '#'),
            'akreditasi'        => Pengaturan::get('akreditasi',        'A'),
        ];
    }
}
PHP;

// ============================================================
// 2. Layout publik
// ============================================================
$files['resources/views/public/layout.blade.php'] = <<<'BLADE'
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', $settings['nama_sekolah']) - PPDB {{ $settings['tahun_ajaran'] }}</title>
    <meta name="description" content="PPDB {{ $settings['tahun_ajaran'] }} - {{ $settings['nama_sekolah'] }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; overflow-x: hidden; }
        .float-anim { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .fade-in { animation: fadeIn 0.6s ease-in-out; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body class="relative text-slate-800 w-full overflow-x-hidden">

{{-- Tombol WA Melayang --}}
<div class="fixed bottom-4 right-4 md:bottom-6 md:right-6 z-[100] group flex items-center">
    <div class="absolute right-14 md:right-16 bg-white px-3 py-1 md:px-4 md:py-2 rounded-xl shadow-lg border border-slate-100 text-xs md:text-sm font-bold text-slate-700 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0 whitespace-nowrap pointer-events-none">
        Tanya PPDB? Chat Kami!
        <div class="absolute right-[-5px] top-1/2 -translate-y-1/2 w-2 h-2 bg-white transform rotate-45 border-r border-t border-slate-100"></div>
    </div>
    <a href="https://wa.me/62{{ $settings['no_wa_admin'] }}" target="_blank"
        class="relative bg-[#25D366] text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-[0_10px_20px_rgba(37,211,102,0.3)] hover:scale-110 transition-all duration-300">
        <span class="absolute inset-0 rounded-full bg-[#25D366] animate-ping opacity-50"></span>
        <svg class="w-6 h-6 md:w-7 md:h-7 z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
</div>

{{-- Background Blobs --}}
<div class="absolute top-[-5%] left-[-10%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] rounded-full bg-blue-300 opacity-20 blur-[80px] -z-10 pointer-events-none"></div>
<div class="absolute top-[15%] right-[-10%] w-[250px] md:w-[400px] h-[250px] md:h-[400px] rounded-full bg-cyan-300 opacity-20 blur-[80px] -z-10 pointer-events-none"></div>

{{-- Navbar --}}
<nav class="fixed w-full z-50 bg-white/80 backdrop-blur-lg border-b border-white/20 shadow-sm transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-20 items-center">
            <a href="{{ route('public.index') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">D</div>
                <span class="font-extrabold text-xl md:text-2xl text-slate-800 tracking-tight">DigiEdu<span class="text-blue-600">.</span></span>
            </a>
            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('public.index') }}#profil" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Profil</a>
                <a href="{{ route('public.index') }}#program" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Program</a>
                <a href="{{ route('public.index') }}#jadwal" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Jadwal PPDB</a>
                <a href="{{ route('public.index') }}#berita" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Berita</a>
                <a href="{{ route('public.index') }}#cek-status" class="bg-slate-900 text-white px-6 py-2.5 rounded-full font-bold hover:bg-blue-600 transition shadow-lg text-sm">Cek Status</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-slate-600 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 absolute w-full shadow-lg left-0 top-16 z-50">
        <div class="px-4 pt-2 pb-6 space-y-1 flex flex-col">
            <a href="{{ route('public.index') }}#profil"     class="mobile-menu-link text-slate-600 font-semibold block px-3 py-3 rounded-lg hover:bg-slate-50 text-sm">Profil</a>
            <a href="{{ route('public.index') }}#program"    class="mobile-menu-link text-slate-600 font-semibold block px-3 py-3 rounded-lg hover:bg-slate-50 text-sm">Program</a>
            <a href="{{ route('public.index') }}#jadwal"     class="mobile-menu-link text-slate-600 font-semibold block px-3 py-3 rounded-lg hover:bg-slate-50 text-sm">Jadwal PPDB</a>
            <a href="{{ route('public.index') }}#berita"     class="mobile-menu-link text-slate-600 font-semibold block px-3 py-3 rounded-lg hover:bg-slate-50 text-sm">Berita</a>
            <a href="{{ route('public.index') }}#cek-status" class="mobile-menu-link bg-blue-600 text-white font-bold text-center block px-3 py-3 mt-2 rounded-xl shadow-md text-sm">Cek Status Pendaftaran</a>
        </div>
    </div>
</nav>

{{-- Content --}}
@yield('content')

{{-- Footer --}}
<footer class="bg-slate-900 text-slate-300 relative w-full overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-cyan-400 to-blue-600"></div>
    <div class="absolute bottom-0 right-[-10%] w-96 h-96 bg-blue-600 rounded-full opacity-10 blur-[100px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center text-white font-bold text-lg">D</div>
                    <span class="font-extrabold text-xl text-white">DigiEdu<span class="text-blue-400">.</span></span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">{{ $settings['nama_sekolah'] }} — Mencetak generasi kritis, berbudaya, dan siap menghadapi tantangan global.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-5 uppercase text-xs tracking-wider">Navigasi</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('public.index') }}"            class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="{{ route('public.index') }}#profil"     class="hover:text-blue-400 transition">Profil Sekolah</a></li>
                    <li><a href="{{ route('public.index') }}#jadwal"     class="hover:text-blue-400 transition">Jadwal PPDB</a></li>
                    <li><a href="{{ route('public.index') }}#cek-status" class="text-cyan-400 font-semibold hover:text-cyan-300 transition">Cek Status</a></li>
                    <li><a href="{{ route('admin.login') }}"             class="hover:text-blue-400 transition">Portal Admin</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-5 uppercase text-xs tracking-wider">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $settings['alamat'] }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ $settings['email_ppdb'] }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>+62 {{ $settings['no_wa_admin'] }}</span>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-5 uppercase text-xs tracking-wider">Jam Operasional</h4>
                <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700/50">
                    <p class="text-sm text-slate-400 flex justify-between mb-2"><span>Senin - Jumat</span><span class="text-white font-semibold">07.00 - 15.00</span></p>
                    <p class="text-sm text-slate-400 flex justify-between"><span>Sabtu (Eskul)</span><span class="text-white font-semibold">08.00 - 12.00</span></p>
                </div>
                <div class="flex gap-3 mt-5">
                    <a href="{{ $settings['instagram_url'] }}" target="_blank" class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="{{ $settings['youtube_url'] }}" target="_blank" class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-red-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-slate-500">
            <p>© {{ date('Y') }} {{ $settings['nama_sekolah'] }}. Hak cipta dilindungi.</p>
            <a href="{{ route('admin.login') }}" class="hover:text-white transition">Panel Admin →</a>
        </div>
    </div>
</footer>

<script>
    const btn  = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    document.querySelectorAll('.mobile-menu-link').forEach(l => l.addEventListener('click', () => menu.classList.add('hidden')));
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 20) {
            nav.classList.remove('bg-white/80'); nav.classList.add('bg-white/98', 'shadow-md');
        } else {
            nav.classList.add('bg-white/80'); nav.classList.remove('bg-white/98', 'shadow-md');
        }
    });
</script>
@stack('scripts')
</body>
</html>
BLADE;

// ============================================================
// 3. index.blade.php — FULL TEMPLATE
// ============================================================
$files['resources/views/public/index.blade.php'] = <<<'BLADE'
@extends('public.layout')
@section('title', 'Beranda')

@section('content')

{{-- ═══════════════════════════════════════════
    HERO
════════════════════════════════════════════ --}}
<main class="pt-28 pb-10 sm:pt-32 sm:pb-16 lg:pt-40 lg:pb-20 px-4 w-full max-w-7xl mx-auto flex flex-col items-center text-center relative z-10">
    <div class="flex items-center justify-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-blue-50 border border-blue-100 text-blue-700 font-semibold text-[10px] sm:text-sm mb-5 shadow-sm">
        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-blue-600 animate-pulse shrink-0"></span>
        <span>Pendaftaran {{ $settings['tahun_ajaran'] }} — {{ $settings['gelombang_aktif'] }} Dibuka</span>
    </div>

    <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-slate-900 tracking-tight leading-snug mb-4 w-full px-2">
        Pendidikan Berkualitas untuk<br class="hidden sm:block"/>
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Generasi Masa Depan</span>
    </h1>

    <p class="text-sm sm:text-lg md:text-xl text-slate-500 max-w-2xl w-full mb-8 px-2 sm:px-0 leading-relaxed">
        Membangun karakter kebangsaan dan wawasan global. Sistem pembelajaran modern yang terintegrasi untuk mencetak pemuda kritis dan berbudaya.
    </p>

    <div class="flex flex-col sm:flex-row justify-center w-full max-w-xs sm:max-w-none gap-3 px-2">
        <a href="#cek-status" class="w-full sm:w-auto px-6 py-3.5 sm:px-8 sm:py-4 rounded-full bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold text-sm sm:text-base shadow-xl shadow-blue-500/30 hover:scale-105 transition">
            Cek Status Pendaftaran
        </a>
        <a href="#jadwal" class="w-full sm:w-auto px-6 py-3.5 sm:px-8 sm:py-4 rounded-full bg-white text-slate-700 font-bold text-sm sm:text-base shadow-lg border border-slate-100 hover:bg-slate-50 transition flex items-center justify-center gap-2">
            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
            Lihat Jadwal PPDB
        </a>
    </div>
</main>

{{-- Logo Bar --}}
<section class="pb-12 pt-2 w-full overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-5">Terakreditasi {{ $settings['akreditasi'] }} & Menjalin Kemitraan Dengan</p>
        <div class="flex flex-wrap justify-center items-center gap-6 md:gap-16 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
            <span class="text-base md:text-2xl font-extrabold text-slate-600">KEMDIKBUD</span>
            <span class="text-base md:text-2xl font-extrabold text-slate-600">BAN-SM</span>
            <span class="text-base md:text-2xl font-extrabold text-slate-600">KAMPUS MERDEKA</span>
            <span class="text-base md:text-2xl font-extrabold text-slate-600 hidden md:block">UNAIR</span>
        </div>
    </div>
</section>

{{-- Preview Card Floating --}}
<div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 float-anim mb-10 md:mb-16">
    <div class="bg-white rounded-2xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.12)] border border-slate-100 overflow-hidden">
        <div class="bg-slate-50 px-3 py-2 md:px-4 md:py-3 border-b border-slate-100 flex items-center gap-2">
            <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
            <div class="mx-auto bg-white px-3 py-1 rounded-md text-[9px] md:text-xs font-medium text-slate-400 border border-slate-200 shadow-sm">
                ppdb.{{ strtolower(str_replace(' ', '', $settings['nama_sekolah'])) }}.sch.id
            </div>
        </div>
        <div class="p-4 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            <div class="col-span-1 border-b md:border-b-0 md:border-r border-slate-100 pb-6 md:pb-0 md:pr-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-blue-100 border-4 border-white shadow-md flex items-center justify-center text-blue-600 font-bold text-lg shrink-0">S</div>
                    <div>
                        <h3 class="font-bold text-slate-800">Sarinah</h3>
                        <p class="text-xs text-slate-500">ID: PPDB-{{ date('Y') }}-089</p>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-100 rounded-xl p-3">
                    <span class="text-[10px] font-bold text-green-600 uppercase tracking-wider">Status Seleksi</span>
                    <p class="font-extrabold text-green-700 text-base mt-1">DITERIMA TAHAP 1</p>
                </div>
            </div>
            <div class="col-span-1 md:col-span-2">
                <h3 class="font-bold text-slate-800 mb-4">Kelengkapan Dokumen</h3>
                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-600">Proses Verifikasi</span>
                        <span class="text-xs font-bold text-blue-600">85% Lengkap</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 h-full rounded-full" style="width:85%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 rounded-xl border border-slate-100 bg-slate-50">
                        <svg class="w-5 h-5 text-slate-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="text-xs font-medium text-slate-500">Ijazah & KK</p>
                        <p class="text-xs font-bold text-green-600 mt-0.5">✓ Valid</p>
                    </div>
                    <div class="p-3 rounded-xl border border-slate-100 bg-slate-50">
                        <svg class="w-5 h-5 text-slate-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-xs font-medium text-slate-500">Kuota IPS</p>
                        <p class="text-xs font-bold text-slate-800 mt-0.5">Sisa {{ $settings['kuota_ips'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
    STATS — dari DB
════════════════════════════════════════════ --}}
<section class="py-10 md:py-16 bg-slate-900 relative overflow-hidden w-full">
    <div class="absolute inset-0 bg-blue-600 opacity-20 blur-[100px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 relative z-10 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center md:divide-x divide-slate-800">
        <div class="p-3 md:p-4">
            <h3 class="text-3xl md:text-5xl font-extrabold text-white mb-1">{{ $stats['pendidik'] }}<span class="text-blue-500">+</span></h3>
            <p class="text-slate-400 text-[10px] md:text-sm uppercase tracking-widest font-bold">Pendidik</p>
        </div>
        <div class="p-3 md:p-4">
            <h3 class="text-3xl md:text-5xl font-extrabold text-white mb-1">{{ number_format($stats['alumni']) }}<span class="text-blue-500">+</span></h3>
            <p class="text-slate-400 text-[10px] md:text-sm uppercase tracking-widest font-bold">Alumni</p>
        </div>
        <div class="p-3 md:p-4">
            <h3 class="text-3xl md:text-5xl font-extrabold text-white mb-1">{{ $stats['eskul'] }}<span class="text-blue-500">+</span></h3>
            <p class="text-slate-400 text-[10px] md:text-sm uppercase tracking-widest font-bold">Ekskul</p>
        </div>
        <div class="p-3 md:p-4">
            <h3 class="text-3xl md:text-5xl font-extrabold text-white mb-1">{{ $stats['prestasi'] }}<span class="text-blue-500">+</span></h3>
            <p class="text-slate-400 text-[10px] md:text-sm uppercase tracking-widest font-bold">Prestasi</p>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    SAMBUTAN KEPALA SEKOLAH — dari settings DB
════════════════════════════════════════════ --}}
<section id="profil" class="py-16 md:py-24 bg-white relative w-full overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center gap-10 md:gap-16">
        <div class="w-full md:w-5/12 relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-cyan-400 rounded-3xl transform -rotate-3 md:-rotate-6 scale-105 opacity-20"></div>
            @if($settings['kepsek_foto'])
                <img src="{{ asset('storage/'.$settings['kepsek_foto']) }}" alt="Kepala Sekolah"
                    class="relative rounded-3xl shadow-xl object-cover h-[300px] md:h-[480px] w-full border-4 border-white">
            @else
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Kepala Sekolah"
                    class="relative rounded-3xl shadow-xl object-cover h-[300px] md:h-[480px] w-full border-4 border-white">
            @endif
            <div class="absolute -bottom-4 right-2 md:-bottom-6 md:-right-6 bg-white p-3 md:p-4 rounded-xl md:rounded-2xl shadow-xl flex items-center gap-3">
                <div class="w-9 h-9 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <p class="font-bold text-slate-800 text-xs md:text-sm">Sekolah Penggerak</p>
                    <p class="text-[10px] md:text-xs text-slate-500">Tingkat Nasional</p>
                </div>
            </div>
        </div>
        <div class="w-full md:w-7/12 mt-6 md:mt-0">
            <span class="text-blue-600 font-bold tracking-wider uppercase text-xs md:text-sm border-b-2 border-blue-600 pb-1">Sambutan Pimpinan</span>
            <h2 class="mt-5 text-xl md:text-4xl font-extrabold text-slate-900 leading-tight">"Pendidikan bukan sekadar transfer ilmu, tapi pembentukan nalar."</h2>
            <p class="mt-5 text-sm md:text-lg text-slate-600 leading-relaxed">{{ $settings['kepsek_sambutan'] }}</p>
            <div class="mt-8 pt-6 border-t border-slate-100">
                <h4 class="font-extrabold text-base md:text-xl text-slate-900">{{ $settings['kepsek_nama'] }}</h4>
                <p class="text-xs md:text-sm font-semibold text-blue-600 mt-1">Kepala {{ $settings['nama_sekolah'] }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    PROGRAM / EKSPLORASI LUAR KELAS
════════════════════════════════════════════ --}}
<section id="program" class="py-16 md:py-20 bg-slate-50 border-t border-slate-100 w-full overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14">
            <span class="text-blue-600 font-bold tracking-wider uppercase text-xs md:text-sm">Kurikulum Merdeka</span>
            <h2 class="mt-2 text-2xl md:text-4xl font-extrabold text-slate-900">Eksplorasi Luar Kelas</h2>
            <p class="mt-3 text-sm md:text-lg text-slate-500">Pengalaman langsung membentuk daya ingat yang lebih tajam.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 overflow-hidden">
                <div class="h-48 md:h-56 bg-slate-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1566127444979-b3d2b654e3d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Museum" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold text-slate-700">Sejarah Lokal</div>
                </div>
                <div class="p-5 md:p-7">
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Kunjungan Museum</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Menanamkan pemahaman sejarah perjuangan secara langsung.</p>
                </div>
            </div>
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 overflow-hidden">
                <div class="h-48 md:h-56 bg-slate-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1529390079861-591de354faf5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Organisasi" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold text-slate-700">Organisasi</div>
                </div>
                <div class="p-5 md:p-7">
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Peran Siswi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Mendorong partisipasi perempuan dalam organisasi kesiswaan.</p>
                </div>
            </div>
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 overflow-hidden">
                <div class="h-48 md:h-56 bg-slate-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Diskusi" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold text-slate-700">Akademik</div>
                </div>
                <div class="p-5 md:p-7">
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Kajian Sosial</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Ruang dialektika untuk membedah masalah sosial kontemporer.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    JADWAL PPDB — dari DB
════════════════════════════════════════════ --}}
<section id="jadwal" class="py-16 md:py-20 bg-white w-full">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-blue-600 font-bold tracking-wider uppercase text-xs md:text-sm">Timeline</span>
            <h2 class="mt-2 text-2xl md:text-4xl font-extrabold text-slate-900">Jadwal PPDB {{ $settings['tahun_ajaran'] }}</h2>
        </div>
        <div class="max-w-3xl mx-auto space-y-4">
            @forelse($jadwals as $jadwal)
            <div class="flex items-center gap-5 p-5 rounded-2xl transition
                {{ $jadwal->status == 'aktif'   ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/20' : '' }}
                {{ $jadwal->status == 'selesai' ? 'bg-white border border-slate-200 opacity-60' : '' }}
                {{ $jadwal->status == 'belum'   ? 'bg-white border border-slate-200' : '' }}">
                <div class="w-12 h-12 {{ $jadwal->status == 'aktif' ? 'bg-white/20' : 'bg-slate-100' }} rounded-xl flex items-center justify-center font-extrabold text-lg {{ $jadwal->status == 'aktif' ? 'text-white' : 'text-slate-600' }} shrink-0">
                    {{ $jadwal->tahap }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold {{ $jadwal->status == 'aktif' ? 'text-blue-100' : 'text-slate-400' }} uppercase">Tahap {{ $jadwal->tahap }}</p>
                    <h4 class="font-extrabold text-base {{ $jadwal->status == 'aktif' ? 'text-white' : 'text-slate-800' }} truncate">{{ $jadwal->nama_tahap }}</h4>
                    <p class="text-xs {{ $jadwal->status == 'aktif' ? 'text-blue-100' : 'text-slate-500' }} mt-0.5">
                        {{ $jadwal->tanggal_mulai?->format('d M Y') }}
                        @if($jadwal->tanggal_selesai && $jadwal->tanggal_selesai != $jadwal->tanggal_mulai)
                            — {{ $jadwal->tanggal_selesai?->format('d M Y') }}
                        @endif
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold shrink-0
                    {{ $jadwal->status == 'aktif'   ? 'bg-white text-blue-600' : '' }}
                    {{ $jadwal->status == 'selesai' ? 'bg-slate-200 text-slate-600' : '' }}
                    {{ $jadwal->status == 'belum'   ? 'bg-slate-100 text-slate-500' : '' }}">
                    {{ strtoupper($jadwal->status) }}
                </span>
            </div>
            @empty
            <div class="text-center py-10 text-slate-400 text-sm">Jadwal PPDB belum tersedia.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    TESTIMONI ALUMNI
════════════════════════════════════════════ --}}
<section class="py-16 md:py-20 bg-blue-600 text-white relative overflow-hidden w-full">
    <div class="absolute -right-10 -top-10 w-96 h-96 bg-blue-500 rounded-full opacity-50 blur-[50px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-10 md:mb-14">
            <h2 class="text-2xl md:text-4xl font-extrabold mb-2">Jejak Langkah Alumni</h2>
            <p class="text-blue-200 text-sm md:text-base">Pengalaman mereka yang telah berhasil.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 md:p-8 rounded-2xl">
                <p class="text-blue-50 text-sm italic mb-5">"Fasilitas debat sangat membantu saya lulus dan beradaptasi di kampus."</p>
                <div class="flex items-center gap-3 border-t border-white/20 pt-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold shrink-0">R</div>
                    <div><h4 class="font-bold text-sm">Rangga Pramana</h4><p class="text-[10px] text-blue-200">Mahasiswa Ilmu Politik UI</p></div>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 md:p-8 rounded-2xl">
                <p class="text-blue-50 text-sm italic mb-5">"Ekstrakurikuler jurnalistik membentuk cara berpikir kritis saya setiap hari."</p>
                <div class="flex items-center gap-3 border-t border-white/20 pt-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold shrink-0">A</div>
                    <div><h4 class="font-bold text-sm">Anisa Putri</h4><p class="text-[10px] text-blue-200">Jurnalis Media Nasional</p></div>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 md:p-8 rounded-2xl">
                <p class="text-blue-50 text-sm italic mb-5">"Disiplin dan tanggung jawab di sekolah membuat saya mudah beradaptasi di lingkungan baru."</p>
                <div class="flex items-center gap-3 border-t border-white/20 pt-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold shrink-0">B</div>
                    <div><h4 class="font-bold text-sm">Bima Santoso</h4><p class="text-[10px] text-blue-200">Taruna Akpol</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    CEK STATUS
════════════════════════════════════════════ --}}
<section id="cek-status" class="py-16 md:py-20 bg-slate-50 w-full">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <span class="text-blue-600 font-bold tracking-wider uppercase text-xs md:text-sm">Portal Pendaftar</span>
        <h2 class="mt-2 text-2xl md:text-4xl font-extrabold text-slate-900 mb-3">Cek Status Pendaftaran</h2>
        <p class="text-slate-500 text-sm mb-8">Masukkan NISN kamu untuk melihat status verifikasi berkas dan hasil seleksi.</p>
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
            <form method="POST" action="{{ route('public.cek-status') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2 text-left">Nomor Induk Siswa Nasional (NISN)</label>
                    <input type="text" name="nisn" placeholder="Contoh: 0081234567" required
                        class="w-full px-5 py-4 border-2 border-slate-200 rounded-2xl text-base font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-center tracking-widest">
                    @error('nisn')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-4 rounded-2xl font-extrabold hover:from-blue-700 hover:to-blue-600 transition shadow-lg shadow-blue-500/30">
                    Cek Status Sekarang
                </button>
            </form>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    MADING DIGITAL / BERITA — dari DB
════════════════════════════════════════════ --}}
@if($artikels->count() > 0)
<section id="berita" class="py-16 md:py-20 bg-white w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10 gap-4">
            <div>
                <span class="text-blue-600 font-bold tracking-wider uppercase text-xs md:text-sm">Mading Digital</span>
                <h2 class="mt-1 text-2xl md:text-3xl font-extrabold text-slate-900">Berita & Pengumuman</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($artikels as $a)
            <a href="{{ route('public.artikel', $a->slug) }}" class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-lg border border-slate-100 transition block group">
                <div class="h-44 bg-slate-200 rounded-xl mb-4 overflow-hidden relative">
                    @if($a->foto_cover)
                        <img src="{{ asset('storage/'.$a->foto_cover) }}" alt="{{ $a->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-100">
                            <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $a->kategori }}</span>
                </div>
                <h3 class="font-bold text-slate-900 mb-1 line-clamp-2 text-sm md:text-base">{{ $a->judul }}</h3>
                <p class="text-slate-500 text-xs">{{ $a->penulis }} • {{ $a->published_at?->format('d M Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════
    LOKASI & MAPS — embed dari settings DB
════════════════════════════════════════════ --}}
<section class="py-12 md:py-16 bg-slate-50 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-blue-900 rounded-2xl md:rounded-3xl overflow-hidden shadow-xl flex flex-col lg:flex-row">
            <div class="lg:w-1/3 p-7 md:p-12 text-white flex flex-col justify-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-blue-500 rounded-full opacity-20 blur-[80px] pointer-events-none"></div>
                <span class="text-blue-300 font-bold tracking-wider uppercase text-xs mb-2">Kunjungi Kami</span>
                <h2 class="text-xl md:text-3xl font-extrabold mb-4">Lokasi Kampus Utama</h2>
                <p class="text-blue-100 text-xs md:text-sm mb-6 leading-relaxed">Terletak di pusat strategis yang mudah dijangkau, dengan lingkungan yang aman dan asri.</p>
                <div class="flex items-start gap-3 mb-6">
                    <div class="w-9 h-9 rounded-full bg-blue-800 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-white text-xs">Alamat Lengkap</p>
                        <p class="text-blue-200 text-xs mt-1">{{ $settings['alamat'] }}</p>
                    </div>
                </div>
                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-white text-blue-900 font-bold text-xs shadow-md hover:bg-blue-50 transition w-full md:w-max">
                    Buka di Google Maps
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
            <div class="lg:w-2/3 h-52 md:h-80 lg:h-auto relative bg-slate-700">
                <div class="absolute inset-0 flex items-center justify-center text-slate-400 text-sm z-0">Memuat peta...</div>
                <iframe src="{{ $settings['maps_embed'] }}" class="absolute inset-0 w-full h-full border-0 z-10" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

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

echo "\n========================================\n";
echo "Selesai! $success file berhasil ditulis.\n";
echo "========================================\n";
echo "Jalankan: php artisan view:clear && php artisan cache:clear\n";