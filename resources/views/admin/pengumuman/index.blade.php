@extends('layouts.admin')
@section('title','Pengumuman Seleksi')
@section('page-title','Pengumuman Hasil Seleksi')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Pengumuman Hasil Seleksi</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium">Publikasi status kelulusan peserta PPDB ke halaman publik.</p>
        </div>
        <form method="POST" action="{{ route('admin.pengumuman.publish') }}">
            @csrf
            <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-xl text-sm font-black shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition flex items-center gap-2 uppercase">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                Publish Pengumuman
            </button>
        </form>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white border-b-4 border-emerald-500 rounded-2xl p-6 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shrink-0"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Diterima</p><h3 class="text-3xl font-black text-slate-800">{{ $diterima }}</h3></div>
        </div>
        <div class="bg-white border-b-4 border-red-500 rounded-2xl p-6 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 shrink-0"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tidak Lulus</p><h3 class="text-3xl font-black text-slate-800">{{ $ditolak }}</h3></div>
        </div>
        <div class="bg-white border-b-4 border-amber-500 rounded-2xl p-6 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 shrink-0"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Antrean</p><h3 class="text-3xl font-black text-slate-800">{{ $menunggu }}</h3></div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-100 bg-slate-50/30 flex justify-between items-center">
            <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest">Daftar Hasil Seleksi Final</h3>
            <span class="text-[10px] font-bold text-slate-400">Total: {{ $pendaftars->total() }} Data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[700px]">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.15em] border-b border-slate-100 bg-slate-50/20">
                        <th class="px-8 py-4 font-black">Nama Siswa</th>
                        <th class="px-5 py-4 font-black">NISN</th>
                        <th class="px-5 py-4 font-black">Jalur / Jurusan</th>
                        <th class="px-5 py-4 font-black text-center">Rata-rata</th>
                        <th class="px-5 py-4 font-black text-center">Status</th>
                        <th class="px-8 py-4 font-black text-center">Notifikasi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    @forelse($pendaftars as $p)
                    <tr class="hover:bg-slate-50/50 transition duration-200">
                        <td class="px-8 py-4">
                            <p class="font-black text-slate-800 uppercase text-xs">{{ $p->nama }}</p>
                            <p class="text-[10px] text-slate-400 font-bold tracking-tight mt-0.5">{{ $p->no_reg }}</p>
                        </td>
                        <td class="px-5 py-4 font-bold text-slate-500 text-xs tracking-widest">{{ $p->nisn }}</td>
                        <td class="px-5 py-4">
                            <span class="text-[10px] font-black text-blue-600 uppercase tracking-tighter">{{ $p->jalur }}</span>
                            <p class="text-[9px] font-bold text-slate-400 uppercase">{{ $p->jurusan }}</p>
                        </td>
                        <td class="px-5 py-4 text-center font-black text-slate-700">{{ $p->nilai_rata ?? '-' }}</td>
                        <td class="px-5 py-4 text-center">{!! $p->status_badge !!}</td>
                        <td class="px-8 py-4 text-center">
                            <form method="POST" action="{{ route('admin.pengumuman.notif', $p->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="group bg-[#25D366] text-white pl-3 pr-4 py-2 rounded-xl text-[10px] font-black hover:bg-[#1da851] transition-all flex items-center gap-2 mx-auto shadow-md shadow-emerald-50">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884 0 2.225.569 3.844 1.594 5.397l-.474 2.65 2.736-.723-.663-.221z"/></svg>
                                    KIRIM WA
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-20 text-center text-slate-400 font-bold italic text-xs uppercase tracking-widest">Belum ada data hasil seleksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100 bg-slate-50/20">{{ $pendaftars->links() }}</div>
    </div>
</div>
@endsection