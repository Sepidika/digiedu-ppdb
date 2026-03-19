@extends('layouts.admin')
@section('title','Master Data Pendaftar')
@section('page-title','Master Data Pendaftar')
@section('content')
<div class="fade-in">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Master Data Pendaftar</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola biodata seluruh siswa pendaftar.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.pendaftar.create') }}" class="bg-white border border-slate-300 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Tambah
            </a>
            <a href="{{ route('admin.backup.excel') }}" class="bg-green-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-green-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg> Export Excel
            </a>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <form method="GET" action="{{ route('admin.pendaftar.index') }}" class="p-4 border-b border-slate-100 flex flex-col lg:flex-row gap-4 bg-slate-50/50">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NISN..."
                    class="w-full pl-9 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="flex gap-3">
                <select name="jurusan" onchange="this.form.submit()" class="px-3 py-2.5 border border-slate-300 rounded-xl text-sm font-bold text-slate-600 bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua Jurusan</option>
                    <option value="MIPA" {{ request('jurusan')=='MIPA'?'selected':'' }}>MIPA</option>
                    <option value="IPS" {{ request('jurusan')=='IPS'?'selected':'' }}>IPS</option>
                </select>
                <select name="status" onchange="this.form.submit()" class="px-3 py-2.5 border border-slate-300 rounded-xl text-sm font-bold text-slate-600 bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="Diterima" {{ request('status')=='Diterima'?'selected':'' }}>Diterima</option>
                    <option value="Menunggu" {{ request('status')=='Menunggu'?'selected':'' }}>Menunggu</option>
                    <option value="Ditolak" {{ request('status')=='Ditolak'?'selected':'' }}>Ditolak</option>
                </select>
                @if(request('search') || request('jurusan') || request('status'))
                    <a href="{{ route('admin.pendaftar.index') }}" class="px-3 py-2.5 bg-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-300">Reset</a>
                @endif
            </div>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[900px]">
                <thead><tr class="text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-100">
                    <th class="px-5 py-3 font-extrabold">NISN / Reg</th>
                    <th class="px-5 py-3 font-extrabold">Data Diri</th>
                    <th class="px-5 py-3 font-extrabold">Asal Sekolah</th>
                    <th class="px-5 py-3 font-extrabold">Jalur & Jurusan</th>
                    <th class="px-5 py-3 font-extrabold">Status</th>
                    <th class="px-5 py-3 font-extrabold text-center">Aksi</th>
                </tr></thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($pendaftars as $p)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3"><span class="font-extrabold text-slate-800">{{ $p->nisn }}</span><br><span class="text-[10px] text-slate-400">{{ $p->no_reg }}</span></td>
                        <td class="px-5 py-3"><span class="font-bold text-slate-800">{{ $p->nama }}</span><br><span class="text-[10px] text-slate-500">{{ $p->tempat_lahir }}, {{ $p->tanggal_lahir?->format('d M Y') }} • {{ $p->jenis_kelamin=='Laki-Laki'?'L':'P' }}</span></td>
                        <td class="px-5 py-3 text-slate-600">{{ $p->asal_sekolah }}</td>
                        <td class="px-5 py-3 font-bold text-blue-600">{{ $p->jalur }} - {{ $p->jurusan }}</td>
                        <td class="px-5 py-3">{!! $p->status_badge !!}</td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.pendaftar.edit', $p) }}" class="text-slate-600 bg-white border border-slate-300 hover:bg-blue-50 hover:text-blue-700 px-3 py-1.5 rounded-lg font-bold text-xs transition">Edit</a>
                                <form method="POST" action="{{ route('admin.pendaftar.destroy', $p) }}" onsubmit="return confirm('Hapus data {{ addslashes($p->nama) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg font-bold text-xs transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">Belum ada data pendaftar. <a href="{{ route('admin.pendaftar.create') }}" class="text-blue-600 font-bold hover:underline">Tambah sekarang?</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
            <p class="text-sm font-bold text-slate-500">Menampilkan {{ $pendaftars->firstItem() ?? 0 }}–{{ $pendaftars->lastItem() ?? 0 }} dari {{ $pendaftars->total() }} data</p>
            {{ $pendaftars->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection