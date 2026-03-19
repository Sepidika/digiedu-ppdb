@extends('layouts.admin')
@section('title','Edit Artikel')
@section('page-title','Edit Artikel')
@section('content')
<div class="fade-in max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.artikel.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-extrabold text-slate-800">Edit Artikel</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.artikel.update', $artikel) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Judul *</label>
                    <input type="text" name="judul" value="{{ old('judul',$artikel->judul) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach(['Pengumuman','Esai / Jurnal Siswa','Kegiatan Sekolah'] as $k)
                        <option value="{{ $k }}" {{ $artikel->kategori==$k?'selected':'' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis',$artikel->penulis) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="published" {{ $artikel->status=='published'?'selected':'' }}>Published</option>
                        <option value="draft" {{ $artikel->status=='draft'?'selected':'' }}>Draft</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Ganti Foto Cover</label>
                    <input type="file" name="foto_cover" accept="image/*" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                    @if($artikel->foto_cover)
                        <img src="{{ asset('storage/'.$artikel->foto_cover) }}" class="mt-2 h-16 rounded-lg object-cover">
                    @endif
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Isi Artikel *</label>
                    <textarea name="isi" rows="8" required class="w-full px-4 py-3 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none leading-relaxed">{{ old('isi',$artikel->isi) }}</textarea>
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.artikel.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection