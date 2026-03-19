@extends('layouts.admin')
@section('title','Verifikasi Berkas')
@section('page-title','Verifikasi Dokumen Pendaftar')
@section('content')
<div class="fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 border-b border-slate-200 pb-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Verifikasi Dokumen Pendaftar</h2>
            <p class="text-xs font-semibold text-slate-500">Cek keaslian berkas pendaftar satu per satu.</p>
        </div>
        <div class="bg-amber-100 border border-amber-200 text-amber-700 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 shrink-0">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
            {{ $antrean->count() }} Antrean Tersisa
        </div>
    </div>
    
    @if($antrean->isEmpty())
    <div class="bg-green-50 border border-green-200 rounded-2xl p-10 text-center">
        <svg class="w-16 h-16 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h3 class="text-xl font-extrabold text-green-700 mb-2">Semua Berkas Sudah Diverifikasi!</h3>
        <p class="text-green-600 font-medium">Tidak ada antrean verifikasi saat ini.</p>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex flex-col max-h-[500px] lg:h-[calc(100vh-16rem)]">
            <h3 class="font-extrabold text-slate-800 mb-3 text-[10px] uppercase tracking-wide">Antrean ({{ $antrean->count() }})</h3>
            <div class="flex flex-row lg:flex-col overflow-x-auto lg:overflow-y-auto space-x-2 lg:space-x-0 lg:space-y-2 hide-scroll">
                @foreach($antrean as $item)
                <a href="?aktif={{ $item->id }}" class="shrink-0 w-48 lg:w-full p-3 rounded-xl cursor-pointer transition border {{ $aktif && $aktif->id==$item->id ? 'bg-blue-50 border-blue-300 shadow-sm' : 'hover:bg-slate-50 border-slate-200' }}">
                    <p class="font-{{ $aktif && $aktif->id==$item->id ? 'extrabold text-blue-900' : 'bold text-slate-700' }} text-xs truncate">{{ $item->nama }}</p>
                    <p class="text-[10px] font-semibold {{ $aktif && $aktif->id==$item->id ? 'text-blue-600' : 'text-slate-500' }} mt-0.5">{{ $item->no_reg }}</p>
                </a>
                @endforeach
            </div>
        </div>

        @if($aktif)
        <div class="lg:col-span-4 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col">
            @if($aktif->foto_siswa)
                <img src="{{ asset('storage/'.$aktif->foto_siswa) }}" alt="Foto {{ $aktif->nama }}" class="w-20 h-20 rounded-full object-cover mb-3 mx-auto border-4 border-white shadow-md">
            @else
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-extrabold text-3xl mb-3 mx-auto border-4 border-white shadow-md">{{ substr($aktif->nama,0,1) }}</div>
            @endif
            <h3 class="font-extrabold text-lg text-center text-slate-800">{{ $aktif->nama }}</h3>
            <p class="text-center text-xs font-semibold text-slate-500 mt-2 mb-5 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg mx-auto w-max">{{ $aktif->asal_sekolah }}</p>
            
            <div class="space-y-3 text-sm flex-1 border-t border-slate-100 pt-5">
                <div class="flex justify-between"><span class="text-slate-500 text-xs">NISN</span><span class="font-extrabold text-slate-800 bg-slate-100 px-2 py-0.5 rounded text-xs">{{ $aktif->nisn }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500 text-xs">Jalur & Jurusan</span><span class="font-extrabold text-blue-600 bg-blue-50 px-2 py-0.5 rounded text-xs">{{ $aktif->jalur }} - {{ $aktif->jurusan }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500 text-xs">Nilai</span><span class="font-extrabold text-slate-800 bg-slate-100 px-2 py-0.5 rounded text-xs">{{ $aktif->nilai_rata ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500 text-xs">Wali</span><span class="font-semibold text-slate-700 text-xs">{{ $aktif->nama_wali }}</span></div>
            </div>
            
            <div class="mt-6 space-y-2">
                <form method="POST" action="{{ route('admin.verifikasi.setuju', $aktif->id) }}">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-extrabold text-sm transition shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Setujui Berkas
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.verifikasi.tolak', $aktif->id) }}" class="space-y-2">
                    @csrf
                    <textarea name="catatan_admin" rows="2" placeholder="Alasan penolakan wajib diisi..." required class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-red-400 outline-none resize-none"></textarea>
                    <button type="submit" class="w-full bg-white border-2 border-red-200 text-red-600 hover:bg-red-50 py-3 rounded-xl font-extrabold text-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Tolak Berkas
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-5 bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col min-h-[400px]">
            <h3 class="font-extrabold text-slate-800 mb-3 text-[10px] uppercase tracking-wide">Dokumen Asli</h3>
            
            <div class="flex gap-2 mb-4 flex-wrap">
                @foreach(['foto_kk'=>'Kartu Keluarga','foto_ijazah'=>'Ijazah','foto_rapor'=>'Nilai Rapor'] as $field=>$label)
                    @if($aktif->$field)
                        <a href="{{ asset('storage/'.$aktif->$field) }}" target="_blank" onclick="event.preventDefault(); document.getElementById('preview-box').src = this.href;" class="flex-1 min-w-[100px] p-2 border-2 border-blue-500 bg-blue-50 rounded-xl text-center text-xs font-extrabold text-blue-800 hover:bg-blue-100 cursor-pointer transition">{{ $label }}</a>
                    @else
                        <span class="flex-1 min-w-[100px] p-2 border-2 border-slate-200 bg-slate-50 rounded-xl text-center text-xs font-bold text-slate-400">{{ $label }} (Belum)</span>
                    @endif
                @endforeach
            </div>

            <div class="flex-1 bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center p-2 relative overflow-hidden group">
                @php
                    // Set default gambar yang pertama kali muncul (KK -> Ijazah -> Rapor)
                    $defaultDoc = $aktif->foto_kk ?? ($aktif->foto_ijazah ?? $aktif->foto_rapor);
                @endphp

                @if($defaultDoc)
                    <img id="preview-box" src="{{ asset('storage/'.$defaultDoc) }}" alt="Preview Dokumen" class="max-w-full max-h-full object-contain rounded-lg transition-all duration-300">
                    
                    <a href="{{ asset('storage/'.$defaultDoc) }}" target="_blank" onclick="this.href = document.getElementById('preview-box').src;" class="absolute top-4 right-4 bg-white/90 backdrop-blur p-2.5 rounded-xl shadow-lg border border-slate-200 text-slate-600 hover:text-blue-600 hover:scale-105 transition opacity-0 group-hover:opacity-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                @else
                    <div class="text-center text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="font-semibold text-sm">Belum ada dokumen diupload</p>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    @endif
</div>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#16a34a',
        timer: 3000
    });
</script>
@endif
@endsection