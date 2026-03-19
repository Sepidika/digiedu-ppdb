@extends('layouts.admin')
@section('title','Testimoni')
@section('page-title','Testimoni Alumni')
@section('content')
<div class="fade-in">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Testimoni Alumni</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola kutipan testimoni yang tampil di halaman publik.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-semibold">✓ {{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- FORM TAMBAH --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Tambah Testimoni</h3>
            <form method="POST" action="{{ route('admin.testimoni.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama</label>
                    <input type="text" name="nama" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Profesi / Keterangan</label>
                    <input type="text" name="profesi" placeholder="cth: Mahasiswa Teknik ITS" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Isi Testimoni</label>
                    <textarea name="isi" rows="3" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" required></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Foto (opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full text-sm">
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Urutan</label>
                        <input type="number" name="urutan" value="0" min="0" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex items-center gap-2 pt-5">
                        <input type="checkbox" name="aktif" value="1" checked id="aktif_new" class="w-4 h-4 accent-blue-600">
                        <label for="aktif_new" class="text-sm font-semibold text-slate-600">Aktif</label>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition">Tambah</button>
            </form>
        </div>

        {{-- DAFTAR TESTIMONI --}}
        <div class="lg:col-span-2 space-y-4">
            @forelse($testimonials as $t)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 overflow-hidden shrink-0 flex items-center justify-center text-blue-600 font-bold text-lg">
                        @if($t->foto)
                            <img src="{{ Storage::url($t->foto) }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($t->nama, 0, 1)) }}
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-slate-800 text-sm">{{ $t->nama }}</h4>
                            <span class="text-[10px] px-2 py-0.5 rounded-full {{ $t->aktif ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-500' }} font-bold">{{ $t->aktif ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                        <p class="text-xs text-blue-600 font-semibold mb-2">{{ $t->profesi }}</p>
                        <p class="text-sm text-slate-600 italic">"{{ $t->isi }}"</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    {{-- Form Edit --}}
                    <form method="POST" action="{{ route('admin.testimoni.update', $t) }}" enctype="multipart/form-data" class="flex-1 grid grid-cols-2 gap-2">
                        @csrf @method('PUT')
                        <input type="text" name="nama" value="{{ $t->nama }}" class="px-3 py-2 border border-slate-200 rounded-lg text-xs focus:ring-1 focus:ring-blue-500 outline-none">
                        <input type="text" name="profesi" value="{{ $t->profesi }}" class="px-3 py-2 border border-slate-200 rounded-lg text-xs focus:ring-1 focus:ring-blue-500 outline-none">
                        <textarea name="isi" rows="2" class="col-span-2 px-3 py-2 border border-slate-200 rounded-lg text-xs focus:ring-1 focus:ring-blue-500 outline-none">{{ $t->isi }}</textarea>
                        <div class="flex items-center gap-2">
                            <input type="number" name="urutan" value="{{ $t->urutan }}" min="0" class="w-16 px-2 py-2 border border-slate-200 rounded-lg text-xs outline-none">
                            <input type="checkbox" name="aktif" value="1" {{ $t->aktif ? 'checked' : '' }} class="accent-blue-600">
                            <span class="text-xs text-slate-500">Aktif</span>
                        </div>
                        <button type="submit" class="px-3 py-2 bg-slate-800 text-white rounded-lg text-xs font-bold hover:bg-slate-700 transition">Simpan</button>
                    </form>
                    {{-- Hapus --}}
                    <form method="POST" action="{{ route('admin.testimoni.destroy', $t) }}" onsubmit="return confirm('Hapus testimoni ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-red-400 hover:text-red-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-slate-100 p-10 text-center text-slate-400 text-sm">Belum ada testimoni. Tambahkan via form di sebelah kiri.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection