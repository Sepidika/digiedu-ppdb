@extends('layouts.admin')
@section('title','Tambah Pendaftar')
@section('page-title','Tambah Data Pendaftar')
@section('content')
<div class="fade-in max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.pendaftar.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Tambah Pendaftar Baru</h2>
            <p class="text-xs text-slate-500">Isi data biodata siswa secara manual.</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.pendaftar.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <ul class="text-sm text-red-700 font-semibold space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif
            <div>
                <h4 class="text-sm font-extrabold text-slate-800 border-b border-slate-200 pb-2 mb-4">A. Data Pribadi</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin')=='Laki-Laki'?'selected':'' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">NISN *</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-extrabold text-slate-800 border-b border-slate-200 pb-2 mb-4">B. Akademik & Orang Tua</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Asal Sekolah *</label>
                        <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jalur *</label>
                        <select name="jalur" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="Zonasi" {{ old('jalur')=='Zonasi'?'selected':'' }}>Zonasi</option>
                            <option value="Prestasi Akademik" {{ old('jalur')=='Prestasi Akademik'?'selected':'' }}>Prestasi Akademik</option>
                            <option value="Afirmasi" {{ old('jalur')=='Afirmasi'?'selected':'' }}>Afirmasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jurusan *</label>
                        <select name="jurusan" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="MIPA" {{ old('jurusan')=='MIPA'?'selected':'' }}>MIPA</option>
                            <option value="IPS" {{ old('jurusan')=='IPS'?'selected':'' }}>IPS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nilai Rata-rata</label>
                        <input type="number" step="0.01" name="nilai_rata" value="{{ old('nilai_rata') }}" min="0" max="100" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Orang Tua / Wali *</label>
                        <input type="text" name="nama_wali" value="{{ old('nama_wali') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">No. WA Wali *</label>
                        <input type="text" name="no_wa" value="{{ old('no_wa') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-extrabold text-slate-800 border-b border-slate-200 pb-2 mb-4">C. Upload Dokumen</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach(['foto_kk'=>'Kartu Keluarga','foto_ijazah'=>'Ijazah / SKL','foto_rapor'=>'Nilai Rapor','foto_siswa'=>'Foto Siswa 3x4'] as $field=>$label)
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">{{ $label }}</label>
                        <input type="file" name="{{ $field }}" accept="image/*" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.pendaftar.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection