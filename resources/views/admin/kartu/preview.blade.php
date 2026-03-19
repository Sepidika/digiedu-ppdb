@extends('layouts.admin')
@section('title','Preview Kartu')
@section('page-title','Preview Kartu Peserta')
@section('content')

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        
        #kartu-print, #kartu-print * {
            visibility: visible;
        }
        
        #kartu-print {
            position: absolute;
            left: 50%;
            top: 2cm; 
            transform: translateX(-50%);
            width: 10.5cm; /* Nah, ini ukuran standar lebar plastik ID Card ujian */
            border: 2px solid #cbd5e1 !important; 
            border-radius: 12px !important; /* Sedikit dikurangi lengkungannya biar pas dipotong */
            margin: 0;
            padding: 0;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>

<div class="fade-in max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kartu.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-extrabold text-slate-800">Kartu: {{ $pendaftar->nama }}</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="border-2 border-slate-200 rounded-2xl overflow-hidden mb-4" id="kartu-print">
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-4 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white font-bold text-xl">D</div>
                <div><p class="text-white font-extrabold">DigiEdu School</p><p class="text-blue-200 text-xs">Kartu Peserta PPDB {{ date('Y') }}/{{ date('Y')+1 }}</p></div>
            </div>
            <div class="p-6 grid grid-cols-3 gap-4">
                <div class="col-span-1 flex flex-col items-center">
                    @if($pendaftar->foto_siswa)
                        <img src="{{ asset('storage/'.$pendaftar->foto_siswa) }}" class="w-24 h-28 object-cover rounded-xl border-2 border-slate-300 mb-2">
                    @else
                        <div class="w-24 h-28 bg-slate-200 rounded-xl border-2 border-slate-300 flex items-center justify-center text-slate-400 text-xs mb-2">Foto 3x4</div>
                    @endif
                    <div class="w-20 h-20 bg-slate-100 rounded border flex items-center justify-center text-[10px] text-slate-400">QR Code</div>
                </div>
                <div class="col-span-2 space-y-2 text-sm">
                    <div><p class="text-[10px] text-slate-400 uppercase font-bold">No. Peserta</p><p class="font-extrabold text-slate-900 text-lg tracking-widest">{{ $pendaftar->no_reg }}</p></div>
                    <div><p class="text-[10px] text-slate-400 uppercase font-bold">Nama Lengkap</p><p class="font-bold text-slate-800">{{ $pendaftar->nama }}</p></div>
                    <div><p class="text-[10px] text-slate-400 uppercase font-bold">Asal Sekolah</p><p class="font-semibold text-slate-700 text-xs">{{ $pendaftar->asal_sekolah }}</p></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div><p class="text-[10px] text-slate-400 uppercase font-bold">Jalur</p><p class="font-semibold text-blue-700 text-xs">{{ $pendaftar->jalur }}</p></div>
                        <div><p class="text-[10px] text-slate-400 uppercase font-bold">Jurusan</p><p class="font-semibold text-blue-700 text-xs">{{ $pendaftar->jurusan }}</p></div>
                    </div>
                </div>
            </div>
        </div>
        <button onclick="window.print()" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak / Print
        </button>
    </div>
</div>
@endsection