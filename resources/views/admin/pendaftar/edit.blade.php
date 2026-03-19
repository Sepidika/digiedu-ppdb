@extends('layouts.admin')
@section('title','Edit Pendaftar')
@section('page-title','Edit Biodata Pendaftar')
@section('content')
<div class="fade-in max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.pendaftar.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Edit: {{ $pendaftar->nama }}</h2>
            <p class="text-xs text-slate-500">{{ $pendaftar->no_reg }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.pendaftar.update', $pendaftar) }}" class="space-y-5">
            @csrf @method('PUT')
            
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <ul class="text-sm text-red-700 font-semibold space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap *</label>
                    <input type="text" name="nama" value="{{ old('nama',$pendaftar->nama) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Laki-Laki" {{ $pendaftar->jenis_kelamin=='Laki-Laki'?'selected':'' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ $pendaftar->jenis_kelamin=='Perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">NISN</label>
                    <input type="text" value="{{ $pendaftar->nisn }}" readonly class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-bold bg-slate-50 text-slate-500 cursor-not-allowed">
                </div>

                {{-- INI INPUT YANG TADI HILANG --}}
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Asal Sekolah *</label>
                    <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah',$pendaftar->asal_sekolah) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan nama sekolah asal">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir',$pendaftar->tempat_lahir) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir',$pendaftar->tanggal_lahir?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jalur</label>
                    <select name="jalur" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach(['Zonasi','Prestasi Akademik','Afirmasi'] as $j)
                        <option value="{{ $j }}" {{ $pendaftar->jalur==$j?'selected':'' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jurusan</label>
                    <select name="jurusan" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="MIPA" {{ $pendaftar->jurusan=='MIPA'?'selected':'' }}>MIPA</option>
                        <option value="IPS" {{ $pendaftar->jurusan=='IPS'?'selected':'' }}>IPS</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nilai Rata-rata</label>
                    <input type="number" step="0.01" name="nilai_rata" value="{{ old('nilai_rata',$pendaftar->nilai_rata) }}" min="0" max="100" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Menunggu" {{ $pendaftar->status=='Menunggu'?'selected':'' }}>Menunggu</option>
                        <option value="Diterima" {{ $pendaftar->status=='Diterima'?'selected':'' }}>Diterima</option>
                        <option value="Ditolak" {{ $pendaftar->status=='Ditolak'?'selected':'' }}>Ditolak</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Wali</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali',$pendaftar->nama_wali) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">No. WA Wali</label>
                    <input type="text" name="no_wa" value="{{ old('no_wa',$pendaftar->no_wa) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Catatan Admin</label>
                    <textarea name="catatan_admin" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">{{ old('catatan_admin',$pendaftar->catatan_admin) }}</textarea>
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.pendaftar.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection