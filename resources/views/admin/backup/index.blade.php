@extends('layouts.admin')
@section('title','Backup & Export')
@section('page-title','Backup & Export Data')
@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800">Backup & Export Data</h2>
        <p class="text-sm text-slate-500 mt-1">Unduh dan amankan seluruh data PPDB.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center text-center gap-3">
            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
            <div><h3 class="font-extrabold text-slate-800">Export Excel</h3><p class="text-xs text-slate-500 mt-1">Data pendaftar dalam .xlsx</p></div>
            <a href="{{ route('admin.backup.excel') }}" class="w-full mt-2 bg-green-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-green-700 transition text-center block">Download Excel</a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center text-center gap-3">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-600"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></div>
            <div><h3 class="font-extrabold text-slate-800">Export PDF</h3><p class="text-xs text-slate-500 mt-1">Laporan rekap PPDB .pdf</p></div>
            <a href="{{ route('admin.backup.pdf') }}" class="w-full mt-2 bg-red-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-red-700 transition text-center block">Download PDF</a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center text-center gap-3">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg></div>
            <div><h3 class="font-extrabold text-slate-800">Backup Database</h3><p class="text-xs text-slate-500 mt-1">Backup semua tabel .sql</p><p class="text-[10px] text-amber-600 mt-1 font-semibold">Perlu: spatie/laravel-backup</p></div>
            <form method="POST" action="{{ route('admin.backup.jalankan') }}" class="w-full mt-2">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition">Jalankan Backup</button>
            </form>
        </div>
    </div>
</div>
@endsection