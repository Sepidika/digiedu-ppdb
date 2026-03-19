@extends('layouts.admin')
@section('title','Cetak Kartu Peserta')
@section('page-title','Cetak Kartu Peserta PPDB')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Cetak Kartu Peserta PPDB</h2>
            <p class="text-sm text-slate-500 mt-1">Generate kartu ujian per siswa.</p>
        </div>
        <a href="{{ route('admin.kartu.semua') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Semua
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if($preview)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Preview Kartu Peserta</h3>
            <div class="border-2 border-slate-200 rounded-2xl overflow-hidden shadow-inner bg-slate-50">
                <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white font-bold text-xl uppercase border border-white/30">D</div>
                    <div>
                        <p class="text-white font-extrabold text-sm tracking-tight">DigiEdu School</p>
                        <p class="text-blue-100 text-[10px] font-bold">Kartu Peserta PPDB {{ date('Y') }}/{{ date('Y')+1 }}</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-3 gap-4 bg-white">
                    <div class="col-span-1 flex flex-col items-center">
                        @if($preview->foto_siswa)
                            <img src="{{ asset('storage/'.$preview->foto_siswa) }}" class="w-24 h-28 object-cover rounded-xl border-2 border-slate-100 mb-2 shadow-sm">
                        @else
                            <div class="w-24 h-28 bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-400 text-[10px] text-center mb-2 px-2">Foto 3x4 Belum Tersedia</div>
                        @endif
                        <div class="w-20 h-20 bg-slate-50 rounded border border-slate-200 flex flex-col items-center justify-center text-[8px] text-slate-400 grayscale opacity-50">
                            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            QR CODE
                        </div>
                    </div>
                    <div class="col-span-2 space-y-3 text-sm">
                        <div><p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">No. Peserta</p><p class="font-black text-slate-900 text-base tracking-tighter">{{ $preview->no_reg }}</p></div>
                        <div><p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Nama Lengkap</p><p class="font-extrabold text-slate-800 uppercase leading-tight">{{ $preview->nama }}</p></div>
                        <div><p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Asal Sekolah</p><p class="font-bold text-slate-600 text-xs">{{ $preview->asal_sekolah }}</p></div>
                        <div class="grid grid-cols-2 gap-2 border-t border-slate-50 pt-2">
                            <div><p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Jalur</p><p class="font-black text-blue-600 text-[11px]">{{ $preview->jalur }}</p></div>
                            <div><p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Jurusan</p><p class="font-black text-blue-600 text-[11px]">{{ $preview->jurusan }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                <a href="{{ route('admin.kartu.cetak', $preview->id) }}" target="_blank" class="w-full bg-blue-600 text-white py-3.5 rounded-2xl font-black text-sm hover:bg-blue-700 transition flex items-center justify-center gap-2 shadow-lg shadow-blue-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    CETAK KARTU SEKARANG
                </a>
                <a href="{{ route('admin.kartu.pdf', $preview->id) }}" class="w-full bg-emerald-100 text-emerald-700 py-3.5 rounded-2xl font-black text-sm hover:bg-emerald-200 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    DOWNLOAD FORMAT PDF
                </a>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Pilih Siswa untuk Preview</h3>
            <form method="GET" action="{{ route('admin.kartu.index') }}" class="relative mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NISN..."
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>

            <div class="space-y-3 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                @forelse($pendaftars as $p)
                {{-- LINK UPDATE: Tambahkan parameter id ke URL index --}}
                <div class="group flex items-center justify-between p-4 border rounded-2xl transition-all {{ request('id', $preview->id ?? '') == $p->id ? 'bg-blue-50 border-blue-200 ring-1 ring-blue-500' : 'bg-white border-slate-100 hover:border-blue-300 hover:shadow-md' }}">
                    <a href="{{ route('admin.kartu.index', ['id' => $p->id, 'search' => request('search')]) }}" class="flex-1 cursor-pointer">
                        <p class="font-black text-sm {{ request('id', $preview->id ?? '') == $p->id ? 'text-blue-700' : 'text-slate-800' }} uppercase">{{ $p->nama }}</p>
                        <p class="text-[10px] font-bold text-slate-400 mt-0.5 tracking-tight">{{ $p->nisn }} • {{ $p->jalur }} ({{ $p->jurusan }})</p>
                    </a>
                    <div class="flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.kartu.cetak', $p->id) }}" target="_blank" class="p-2 bg-white border border-slate-200 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-slate-400 font-bold italic">Siswa tidak ditemukan.</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-6">
                {{ $pendaftars->links() }}
            </div>
        </div>
    </div>
</div>
@endsection