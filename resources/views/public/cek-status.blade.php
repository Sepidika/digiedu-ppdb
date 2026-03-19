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
            <div class="p-6 {{ $pendaftar->status == 'Diterima' ? 'bg-gradient-to-r from-green-500 to-emerald-400' : ($pendaftar->status == 'Ditolak' ? 'bg-gradient-to-r from-red-500 to-rose-400' : 'bg-gradient-to-r from-amber-500 to-yellow-400') }} text-white text-center">
                <div class="mb-3 flex justify-center">
                    @if($pendaftar->foto_siswa)
                    <img src="{{ asset('storage/' . $pendaftar->foto_siswa) }}" 
                    class="w-20 h-20 rounded-full object-cover border-4 border-white/30 shadow-lg">
                    @else
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center text-3xl font-extrabold border-4 border-white/30">
                    {{ substr($pendaftar->nama, 0, 1) }}
                </div>
            @endif
        </div>
                <h2 class="text-xl font-extrabold">{{ $pendaftar->nama }}</h2>
                <p class="text-white/80 text-sm mt-1">{{ $pendaftar->no_reg }}</p>
                <div class="mt-4 inline-block bg-white/20 backdrop-blur px-6 py-2 rounded-full font-extrabold text-sm">
                    @if($pendaftar->status == 'Diterima')
                        ✅ DITERIMA
                    @elseif($pendaftar->status == 'Ditolak')
                        ❌ BERKAS DITOLAK
                    @else
                        ⏳ MENUNGGU VERIFIKASI
                    @endif
                </div>
                @if($pendaftar->status == 'Diterima')
                <div class="mt-3">
                    <a href="{{ route('public.cetak-kartu', $pendaftar->id) }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-white text-green-600 px-6 py-2 rounded-full font-bold shadow-md hover:bg-green-50 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Kartu Pendaftaran
                    </a>
                </div>
                @endif
            </div>

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
            <p class="text-slate-500 text-sm mb-6">Pastikan NISN yang dimasukkan sudah benar.</p>
        </div>
        @endif

        <div class="mt-6 text-center">
            <a href="{{ route('public.index') }}#cek-status" class="text-blue-600 font-bold hover:underline text-sm">← Cek NISN Lain</a>
        </div>
    </div>
</div>
@endsection