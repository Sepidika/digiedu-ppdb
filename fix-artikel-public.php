<?php
/**
 * Fix: Halaman list semua artikel publik
 */

$files = [];

// ============================================================
// 1. Tambah method artikelList di PublicController
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

    public function artikelList(Request $request)
    {
        $settings  = $this->getSettings();
        $kategori  = $request->get('kategori');
        $query     = Artikel::where('status', 'published');
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        $artikels  = $query->latest('published_at')->paginate(9);
        $kategoris = ['Pengumuman', 'Esai / Jurnal Siswa', 'Kegiatan Sekolah'];

        return view('public.artikel-list', compact('settings', 'artikels', 'kategoris', 'kategori'));
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
            'nama_sekolah'    => Pengaturan::get('nama_sekolah',    'DigiEdu School Banyuwangi'),
            'email_ppdb'      => Pengaturan::get('email_ppdb',      'info@digiedu.sch.id'),
            'no_wa_admin'     => Pengaturan::get('no_wa_admin',     '81234567890'),
            'alamat'          => Pengaturan::get('alamat',          'Jl. Jenderal Sudirman No. 45, Banyuwangi, Jawa Timur 68411'),
            'kuota_mipa'      => Pengaturan::get('kuota_mipa',      '150'),
            'kuota_ips'       => Pengaturan::get('kuota_ips',       '150'),
            'tahun_ajaran'    => Pengaturan::get('tahun_ajaran',    '2026/2027'),
            'gelombang_aktif' => Pengaturan::get('gelombang_aktif', 'Gelombang 1'),
            'kepsek_nama'     => Pengaturan::get('kepsek_nama',     'Dr. Kepala Sekolah, M.Pd.'),
            'kepsek_sambutan' => Pengaturan::get('kepsek_sambutan', 'Kami merancang kurikulum tidak hanya untuk mencetak siswa cerdas secara akademik, tetapi juga siswa yang peduli terhadap sejarah dan budaya bangsa.'),
            'kepsek_foto'     => Pengaturan::get('kepsek_foto',     ''),
            'maps_embed'      => Pengaturan::get('maps_embed',      'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126362.47461971701!2d114.2885918731307!3d-8.214088904576135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1451910248e35%3A0xc6e462c8282ea8e0!2sBanyuwangi!5e0!3m2!1sen!2sid!4v1700000000000'),
            'instagram_url'   => Pengaturan::get('instagram_url',   '#'),
            'youtube_url'     => Pengaturan::get('youtube_url',     '#'),
            'akreditasi'      => Pengaturan::get('akreditasi',      'A'),
        ];
    }
}
PHP;

// ============================================================
// 2. Tambah route artikel list
// ============================================================
$web = file_get_contents('routes/web.php');
if (!str_contains($web, 'artikelList')) {
    $web .= "\nRoute::get('/berita', [App\Http\Controllers\PublicController::class, 'artikelList'])->name('public.artikel-list');\n";
    file_put_contents('routes/web.php', $web);
    echo "✅ Route /berita ditambahkan\n";
} else {
    echo "⏭️  Route sudah ada\n";
}

// ============================================================
// 3. View list artikel
// ============================================================
$files['resources/views/public/artikel-list.blade.php'] = <<<'BLADE'
@extends('public.layout')
@section('title', 'Berita & Pengumuman')

@section('content')
<div class="pt-28 pb-16 min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-10 pt-6">
            <span class="text-blue-600 font-bold tracking-wider uppercase text-xs">Mading Digital</span>
            <h1 class="mt-2 text-3xl md:text-4xl font-extrabold text-slate-900">Berita & Pengumuman</h1>
            <p class="mt-3 text-slate-500 text-sm">Informasi terkini seputar kegiatan dan PPDB {{ $settings['nama_sekolah'] }}</p>
        </div>

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap justify-center gap-2 mb-10">
            <a href="{{ route('public.artikel-list') }}"
                class="px-4 py-2 rounded-full text-xs font-bold transition
                {{ !$kategori ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                Semua
            </a>
            @foreach($kategoris as $k)
            <a href="{{ route('public.artikel-list', ['kategori' => $k]) }}"
                class="px-4 py-2 rounded-full text-xs font-bold transition
                {{ $kategori === $k ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ $k }}
            </a>
            @endforeach
        </div>

        {{-- Grid Artikel --}}
        @if($artikels->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach($artikels as $a)
            <a href="{{ route('public.artikel', $a->slug) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg border border-slate-100 transition group block">
                <div class="h-44 bg-slate-200 relative overflow-hidden">
                    @if($a->foto_cover)
                        <img src="{{ asset('storage/'.$a->foto_cover) }}" alt="{{ $a->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-100">
                            <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold text-white
                        {{ $a->kategori === 'Pengumuman' ? 'bg-blue-600' : ($a->kategori === 'Kegiatan Sekolah' ? 'bg-cyan-600' : 'bg-violet-600') }}">
                        {{ $a->kategori }}
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-2 line-clamp-2 text-sm md:text-base">{{ $a->judul }}</h3>
                    <p class="text-slate-500 text-xs line-clamp-2 mb-3">{{ Str::limit(strip_tags($a->isi), 100) }}</p>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <span class="text-xs text-slate-400">{{ $a->penulis }}</span>
                        <span class="text-xs text-slate-400">{{ $a->published_at?->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($artikels->hasPages())
        <div class="flex justify-center">
            <div class="flex items-center gap-2">
                @if($artikels->onFirstPage())
                    <span class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-400 text-sm font-semibold cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $artikels->previousPageUrl() }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">← Prev</a>
                @endif

                @foreach($artikels->getUrlRange(1, $artikels->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="px-4 py-2 rounded-xl text-sm font-bold transition
                        {{ $page == $artikels->currentPage() ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($artikels->hasMorePages())
                    <a href="{{ $artikels->nextPageUrl() }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Next →</a>
                @else
                    <span class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-400 text-sm font-semibold cursor-not-allowed">Next →</span>
                @endif
            </div>
        </div>
        @endif

        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="text-slate-500 font-semibold">Belum ada artikel untuk kategori ini.</p>
            <a href="{{ route('public.artikel-list') }}" class="mt-4 inline-block text-blue-600 font-bold hover:underline text-sm">Lihat semua artikel</a>
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

echo "\n========================================\n";
echo "Selesai! $success file ditulis.\n";
echo "========================================\n";