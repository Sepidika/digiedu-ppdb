@extends('layouts.admin')
@section('title','Galeri')
@section('page-title','Galeri Foto & Video')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Galeri Foto & Video</h2>
            <p class="text-sm text-slate-500 mt-1">Dokumentasi kegiatan sekolah.</p>
        </div>
        <button onclick="document.getElementById('modal-upload').classList.remove('hidden')" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Upload Foto
        </button>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($galeris as $g)
        <div class="group relative bg-slate-200 rounded-2xl overflow-hidden aspect-square">
            <img src="{{ asset('storage/'.$g->file) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                <div><p class="text-white font-bold text-xs">{{ $g->judul }}</p><p class="text-slate-300 text-[10px]">{{ $g->kategori }}</p></div>
            </div>
            <form method="POST" action="{{ route('admin.galeri.destroy', $g) }}" onsubmit="return confirm('Hapus file ini?')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                @csrf @method('DELETE')
                <button type="submit" class="w-7 h-7 bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold">✕</button>
            </form>
        </div>
        @empty
        <div class="col-span-4 py-16 text-center text-slate-400"><p class="font-semibold">Belum ada foto/video.</p></div>
        @endforelse
        <div class="border-2 border-dashed border-slate-300 rounded-2xl aspect-square flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition" onclick="document.getElementById('modal-upload').classList.remove('hidden')">
            <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <p class="text-xs font-bold text-slate-400">Tambah Foto</p>
        </div>
    </div>
    <div id="modal-upload" class="fixed inset-0 bg-slate-900/70 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Upload Foto / Video</h3>
                <button onclick="document.getElementById('modal-upload').classList.add('hidden')" class="text-slate-400 hover:text-red-500">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">File *</label>
                    <input type="file" name="file" accept="image/*,video/mp4" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Judul *</label>
                    <input type="text" name="judul" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Kategori *</label>
                    <select name="kategori" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Kegiatan Akademik">Kegiatan Akademik</option>
                        <option value="Ekstrakurikuler">Ekstrakurikuler</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Fasilitas">Fasilitas</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modal-upload').classList.add('hidden')" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection