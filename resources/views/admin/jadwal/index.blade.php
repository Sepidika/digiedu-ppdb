@extends('layouts.admin')
@section('title','Jadwal PPDB')
@section('page-title','Jadwal PPDB')
@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800">Jadwal PPDB {{ date('Y') }}/{{ date('Y')+1 }}</h2>
        <p class="text-sm text-slate-500 mt-1">Atur tanggal dan timeline proses penerimaan peserta didik baru.</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-4xl">
        <form method="POST" action="{{ route('admin.jadwal.update') }}" class="space-y-4">
            @csrf
            @foreach($jadwals as $jadwal)
            <div class="flex flex-col md:flex-row md:items-center gap-4 p-4 {{ $jadwal->status=='aktif' ? 'bg-green-50 border border-green-200' : 'bg-slate-50 border border-slate-200' }} rounded-2xl">
                <div class="w-10 h-10 {{ $jadwal->status=='aktif' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }} rounded-xl flex items-center justify-center shrink-0 font-extrabold text-sm">{{ $jadwal->tahap }}</div>
                <div class="flex-1">
                    <p class="text-xs font-bold {{ $jadwal->status=='aktif' ? 'text-green-600' : 'text-slate-500' }} uppercase">Tahap {{ $jadwal->tahap }}</p>
                    <h4 class="font-extrabold text-slate-800">{{ $jadwal->nama_tahap }}</h4>
                </div>
                <div class="flex gap-3 items-center flex-wrap">
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block mb-1">Mulai</label>
                        <input type="date" name="jadwal[{{ $jadwal->id }}][tanggal_mulai]" value="{{ $jadwal->tanggal_mulai?->format('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    @if($jadwal->tahap < 4)
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block mb-1">Selesai</label>
                        <input type="date" name="jadwal[{{ $jadwal->id }}][tanggal_selesai]" value="{{ $jadwal->tanggal_selesai?->format('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    @endif
                    <div class="mt-4">
                        <select name="jadwal[{{ $jadwal->id }}][status]" class="px-3 py-2 border border-slate-300 rounded-lg text-xs font-bold outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="belum" {{ $jadwal->status=='belum'?'selected':'' }}>Belum</option>
                            <option value="aktif" {{ $jadwal->status=='aktif'?'selected':'' }}>Aktif</option>
                            <option value="selesai" {{ $jadwal->status=='selesai'?'selected':'' }}>Selesai</option>
                        </select>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="pt-4 flex justify-end border-t border-slate-100">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection