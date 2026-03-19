@extends('public.layout')
@section('title', 'Beranda')
@section('seo_title', 'Beranda - PPDB ' . $settings['tahun_ajaran'] . ' ' . $settings['nama_sekolah'])
@section('seo_description', 'Daftar sekarang! PPDB ' . $settings['tahun_ajaran'] . ' ' . $settings['nama_sekolah'] . ' dibuka. Cek jadwal, kuota, dan status pendaftaran online.')
@section('seo_keywords', 'PPDB ' . $settings['tahun_ajaran'] . ', ' . $settings['nama_sekolah'] . ', daftar SMA Banyuwangi')

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

{{-- Preview Card Floating — UPDATED: LIVE COMPONENT --}}
<div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 float-anim mb-10 md:mb-16"
     @php
        $pendaftars_db = \App\Models\Pendaftar::latest()->take(5)->get();
     @endphp
     x-data="{ 
        pendaftars: {{ $pendaftars_db->count() > 0 ? $pendaftars_db->map(fn($p) => ['nama' => $p->nama, 'id' => 'PPDB-2026-'.str_pad($p->id, 3, '0', STR_PAD_LEFT), 'asal' => $p->asal_sekolah])->toJson() : '[{nama: \'Sarinah\', id: \'PPDB-2026-089\', asal: \'MTs Negeri 1\'}]' }},
        currentIndex: 0,
        progress: 85,
        init() {
            setInterval(() => {
                this.currentIndex = (this.currentIndex + 1) % this.pendaftars.length;
                this.progress = Math.floor(Math.random() * (98 - 65 + 1)) + 65;
            }, 4000);
        }
     }">
    <div class="bg-white rounded-2xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.12)] border border-slate-100 overflow-hidden text-left">
        <div class="bg-slate-50 px-3 py-2 md:px-4 md:py-3 border-b border-slate-100 flex items-center gap-2">
            <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
            <div class="mx-auto bg-white px-3 py-1 rounded-md text-[9px] md:text-xs font-medium text-slate-400 border border-slate-200 shadow-sm">
                Aktivitas Sistem Real-time
            </div>
        </div>
        <div class="p-4 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            <div class="col-span-1 border-b md:border-b-0 md:border-r border-slate-100 pb-6 md:pb-0 md:pr-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-blue-100 border-4 border-white shadow-md flex items-center justify-center text-blue-600 font-bold text-lg shrink-0" x-text="pendaftars[currentIndex].nama[0]"></div>
                    <div>
                        <h3 class="font-bold text-slate-800 transition-all duration-500" x-text="pendaftars[currentIndex].nama">Sarinah</h3>
                        <p class="text-xs text-slate-500" x-text="pendaftars[currentIndex].id">ID: PPDB-2026-089</p>
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3">
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider animate-pulse">Sedang Diverifikasi</span>
                    <p class="font-extrabold text-blue-700 text-sm mt-1">Status: Antrean Sistem</p>
                </div>
            </div>
            <div class="col-span-1 md:col-span-2">
                <h3 class="font-bold text-slate-800 mb-4">Integrasi Data Pendaftar</h3>
                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-600">Proses Validasi Berkas</span>
                        <span class="text-xs font-bold text-blue-600" x-text="progress + '% Lengkap'">85% Lengkap</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 h-full rounded-full transition-all duration-1000" :style="'width:' + progress + '%'"></div>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="p-3 rounded-xl border border-slate-100 bg-slate-50">
                        <p class="text-[10px] font-medium text-slate-500 uppercase tracking-tight">Asal Sekolah</p>
                        <p class="text-[11px] font-bold text-slate-800 mt-1 line-clamp-1" x-text="pendaftars[currentIndex].asal">MTs Negeri 1</p>
                    </div>
                    
                    @foreach(['IPA', 'IPS'] as $jurusan)
                    <div class="p-3 rounded-xl border border-slate-100 bg-slate-50">
                        <p class="text-[10px] font-medium text-slate-500 uppercase tracking-tight">Kuota {{ $jurusan }}</p>
                        @php
                            $key = 'kuota_' . strtolower($jurusan);
                            $total = (int)($settings[$key] ?? 0);
                            $terisi = \App\Models\Pendaftar::where('jurusan', $jurusan)->count();
                            $sisa = $total - $terisi;
                        @endphp
                        <p class="text-xs font-bold text-slate-800 mt-0.5">Sisa {{ $sisa > 0 ? $sisa : 'Penuh' }} Kursi</p>
                    </div>
                    @endforeach
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
    SAMBUTAN KEPALA SEKOLAH
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

{{-- JADWAL PPDB --}}
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

{{-- CEK STATUS --}}
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

@push('scripts')
{{-- Tambahkan library Alpine.js untuk fitur Live Preview --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@endsection