@extends('layouts.admin')
@section('title','Mading & Artikel')
@section('page-title','Mading & Artikel')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Mading & Artikel</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola konten berita dan esai siswa.</p>
        </div>
        <a href="{{ route('admin.artikel.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-extrabold shadow-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Buat Artikel
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead><tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                    <th class="px-5 py-3 font-extrabold">Cover</th>
                    <th class="px-5 py-3 font-extrabold w-[35%]">Judul</th>
                    <th class="px-5 py-3 font-extrabold">Kategori & Penulis</th>
                    <th class="px-5 py-3 font-extrabold text-center">Status</th>
                    <th class="px-5 py-3 font-extrabold text-right">Aksi</th>
                </tr></thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($artikels as $a)
                    <tr class="hover:bg-slate-50 {{ $a->status=='draft'?'opacity-60':'' }}">
                        <td class="px-5 py-3">
                            <div class="w-20 h-14 rounded-lg bg-slate-200 overflow-hidden">
                                @if($a->foto_cover)
                                    <img src="{{ asset('storage/'.$a->foto_cover) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-400 font-bold">No Image</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-3"><h4 class="font-extrabold text-slate-800 text-sm line-clamp-2">{{ $a->judul }}</h4></td>
                        <td class="px-5 py-3">
                            <span class="text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded font-bold text-[10px]">{{ $a->kategori }}</span><br>
                            <span class="text-[10px] text-slate-500 font-semibold">{{ $a->penulis }} • {{ $a->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if($a->status=='published')
                                <span class="px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-[10px] font-extrabold">Published</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-slate-200 text-slate-700 text-[10px] font-extrabold">Draft</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right space-x-1">
                            <a href="{{ route('admin.artikel.edit', $a) }}" class="text-slate-600 bg-white border border-slate-300 hover:bg-slate-100 px-3 py-1.5 rounded-lg font-bold text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.artikel.destroy', $a) }}" class="inline" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg font-bold text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada artikel.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">{{ $artikels->links() }}</div>
    </div>
</div>
@endsection