@extends('layouts.admin')
@section('title','Pengaturan')
@section('page-title','Pengaturan Sistem')
@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800">Pengaturan Sistem</h2>
        <p class="text-sm text-slate-500 mt-1">Ubah identitas profil sekolah dan konfigurasi PPDB.</p>
    </div>

    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-semibold">
        ✓ {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
        @csrf

        {{-- INFORMASI INSTANSI --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <h3 class="text-base font-extrabold text-slate-800 mb-5 pb-3 border-b border-slate-100">Informasi Instansi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" value="{{ $settings['nama_sekolah'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Email Resmi PPDB</label>
                    <input type="email" name="email_ppdb" value="{{ $settings['email_ppdb'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">No. WA Admin</label>
                    <div class="flex">
                        <span class="bg-slate-100 border border-slate-300 border-r-0 px-4 py-3 rounded-l-xl text-sm font-bold text-slate-500">+62</span>
                        <input type="text" name="no_wa_admin" value="{{ $settings['no_wa_admin'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-r-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">{{ $settings['alamat'] }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Embed Google Maps (iframe src)</label>
                    <input type="text" name="maps_embed" value="{{ $settings['maps_embed'] }}" placeholder="https://www.google.com/maps/embed?pb=..." class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    <p class="text-xs text-slate-400 mt-1">Ambil dari Google Maps → Share → Embed a map → salin URL src-nya saja.</p>
                </div>
            </div>
        </div>

        {{-- KUOTA & KONFIGURASI PPDB --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <h3 class="text-base font-extrabold text-slate-800 mb-5 pb-3 border-b border-slate-100">Kuota & Konfigurasi PPDB</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kuota MIPA</label>
                    <input type="number" name="kuota_mipa" value="{{ $settings['kuota_mipa'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-extrabold focus:ring-2 focus:ring-blue-500 outline-none text-blue-700 bg-blue-50">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kuota IPS</label>
                    <input type="number" name="kuota_ips" value="{{ $settings['kuota_ips'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-extrabold focus:ring-2 focus:ring-blue-500 outline-none text-purple-700 bg-purple-50">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" value="{{ $settings['tahun_ajaran'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Gelombang Aktif</label>
                    <select name="gelombang_aktif" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach(['Gelombang 1','Gelombang 2','Gelombang 3'] as $g)
                        <option value="{{ $g }}" {{ $settings['gelombang_aktif']==$g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- STATISTIK SEKOLAH --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <h3 class="text-base font-extrabold text-slate-800 mb-1 pb-3 border-b border-slate-100">Statistik Sekolah</h3>
            <p class="text-xs text-slate-400 mb-5">Ditampilkan di halaman publik sebagai angka keunggulan sekolah.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jumlah Pendidik</label>
                    <input type="number" name="jumlah_pendidik" value="{{ $settings['jumlah_pendidik'] }}" min="0" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-extrabold focus:ring-2 focus:ring-blue-500 outline-none text-emerald-700 bg-emerald-50">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jumlah Alumni</label>
                    <input type="number" name="jumlah_alumni" value="{{ $settings['jumlah_alumni'] }}" min="0" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-extrabold focus:ring-2 focus:ring-blue-500 outline-none text-blue-700 bg-blue-50">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jumlah Eskul</label>
                    <input type="number" name="jumlah_eskul" value="{{ $settings['jumlah_eskul'] }}" min="0" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-extrabold focus:ring-2 focus:ring-blue-500 outline-none text-purple-700 bg-purple-50">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jumlah Prestasi</label>
                    <input type="number" name="jumlah_prestasi" value="{{ $settings['jumlah_prestasi'] }}" min="0" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-extrabold focus:ring-2 focus:ring-blue-500 outline-none text-amber-700 bg-amber-50">
                </div>
            </div>
        </div>

        {{-- PROFIL KEPALA SEKOLAH --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <h3 class="text-base font-extrabold text-slate-800 mb-5 pb-3 border-b border-slate-100">Profil Kepala Sekolah</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Kepala Sekolah</label>
                    <input type="text" name="kepsek_nama" value="{{ $settings['kepsek_nama'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Foto Kepala Sekolah</label>
                    <input type="file" name="kepsek_foto" accept="image/*" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    @if($settings['kepsek_foto'])
                    <div class="mt-2 flex items-center gap-3">
                        <img src="{{ Storage::url($settings['kepsek_foto']) }}" class="w-12 h-12 rounded-full object-cover border-2 border-slate-200">
                        <span class="text-xs text-slate-400">Foto saat ini</span>
                    </div>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Sambutan Kepala Sekolah</label>
                    <textarea name="kepsek_sambutan" rows="5" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">{{ $settings['kepsek_sambutan'] }}</textarea>
                    <p class="text-xs text-slate-400 mt-1">Ditampilkan di halaman Tentang Kami / halaman publik.</p>
                </div>
            </div>
        </div>

        {{-- TOMBOL SIMPAN --}}
        <div class="flex justify-end pb-8">
            <button type="submit" class="bg-blue-600 text-white px-7 py-3 rounded-xl font-extrabold hover:bg-blue-700 transition shadow-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection