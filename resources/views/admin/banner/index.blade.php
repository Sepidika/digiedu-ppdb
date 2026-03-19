@extends('layouts.admin')
@section('title','Banner')
@section('page-title','Manajemen Banner')
@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800">Manajemen Banner / Slider</h2>
        <p class="text-sm text-slate-500 mt-1">Atur gambar hero halaman depan website.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-4">
            @forelse($banners as $b)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="relative h-36 bg-slate-200 overflow-hidden">
                    <img src="{{ asset('storage/'.$b->file) }}" class="w-full h-full object-cover">
                    <span class="absolute top-2 left-2 {{ $b->aktif?'bg-green-500':'bg-slate-500' }} text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $b->aktif?'AKTIF':'NONAKTIF' }}</span>
                    <span class="absolute top-2 right-2 bg-white/90 text-slate-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Urutan {{ $b->urutan }}</span>
                </div>
                <div class="p-4 flex justify-between items-center">
                    <div><p class="font-bold text-sm text-slate-800">{{ $b->judul }}</p><p class="text-xs text-slate-500">{{ $b->updated_at->format('d M Y') }}</p></div>
                    <form method="POST" action="{{ route('admin.banner.destroy', $b) }}" onsubmit="return confirm('Hapus banner?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded-lg font-bold text-xs hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-slate-400 text-sm font-semibold text-center py-8">Belum ada banner.</p>
            @endforelse
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Upload Banner Baru</h3>
            <form method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">File Gambar *</label>
                    <div class="w-full h-40 border-2 border-dashed border-blue-300 rounded-xl bg-blue-50 flex flex-col items-center justify-center text-center p-4 hover:bg-blue-100 cursor-pointer relative">
                        <svg class="w-8 h-8 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-xs font-bold text-blue-800">Klik untuk pilih gambar</p>
                        <p class="text-[10px] text-blue-600">Rekomendasi: 1920x600px</p>
                        <input type="file" name="file" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Judul Banner *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Banner Utama Hero" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition">Upload Banner</button>
            </form>
        </div>
    </div>
</div>
@endsection