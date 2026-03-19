@extends('layouts.admin')
@section('title','Buat Artikel')
@section('page-title','Buat Artikel Baru')
@section('content')
<div class="fade-in max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.artikel.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-extrabold text-slate-800">Buat Artikel Baru</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.artikel.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <ul class="text-sm text-red-700 font-semibold list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Foto Cover</label>
                    <div class="w-full h-40 border-2 border-dashed border-blue-300 rounded-xl bg-blue-50 flex flex-col items-center justify-center text-center p-4 hover:bg-blue-100 cursor-pointer relative">
                        <svg class="w-8 h-8 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <p class="text-xs font-bold text-blue-800">Klik untuk upload</p>
                        <p class="text-[10px] text-blue-600">JPG/PNG, Maks: 2MB</p>
                        <input type="file" name="foto_cover" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <div class="mt-4">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="published">Terbit (Publish)</option>
                            <option value="draft">Simpan Draft</option>
                        </select>
                    </div>
                </div>
                <div class="lg:col-span-2 space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Judul Artikel *</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Judul artikel..." class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Kategori *</label>
                            <select name="kategori" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Esai / Jurnal Siswa">Esai / Jurnal Siswa</option>
                                <option value="Kegiatan Sekolah">Kegiatan Sekolah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Penulis *</label>
                            <input type="text" name="penulis" value="{{ old('penulis','Tim Jurnalistik PPDB') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Isi Artikel *</label>
                        <textarea name="isi" rows="8" required placeholder="Ketik isi artikel di sini..." class="w-full px-4 py-3 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none leading-relaxed">{{ old('isi') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.artikel.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection