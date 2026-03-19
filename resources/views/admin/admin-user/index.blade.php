@extends('layouts.admin')
@section('title','Manajemen Admin')
@section('page-title','Manajemen Admin & Role')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Manajemen Admin & Role</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola akun dan hak akses operator sistem.</p>
        </div>
        <a href="{{ route('admin.admin-user.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg> Tambah Admin
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[750px]">
                <thead><tr class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-200">
                    <th class="px-5 py-3 font-extrabold">Admin</th>
                    <th class="px-5 py-3 font-extrabold">Email</th>
                    <th class="px-5 py-3 font-extrabold">Role</th>
                    <th class="px-5 py-3 font-extrabold">Terakhir Login</th>
                    <th class="px-5 py-3 font-extrabold text-center">Status</th>
                    <th class="px-5 py-3 font-extrabold text-center">Aksi</th>
                </tr></thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @foreach($admins as $a)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($a->nama) }}&background=eff6ff&color=2563eb" class="w-8 h-8 rounded-full">
                                <div><p class="font-bold text-slate-800">{{ $a->nama }}</p><p class="text-[10px] text-slate-500">{{ $a->no_wa }}</p></div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $a->email }}</td>
                        <td class="px-5 py-3"><span class="px-2 py-0.5 {{ $a->role=='super_admin'?'bg-blue-100 text-blue-700':'bg-slate-100 text-slate-700' }} rounded-full text-[10px] font-extrabold">{{ $a->role_label }}</span></td>
                        <td class="px-5 py-3 text-slate-500 text-xs">{{ $a->last_login_at?->diffForHumans() ?? 'Belum pernah' }}</td>
                        <td class="px-5 py-3 text-center"><span class="px-2 py-0.5 {{ $a->status=='aktif'?'bg-green-100 text-green-700':'bg-slate-200 text-slate-600' }} rounded-full text-[10px] font-extrabold">{{ ucfirst($a->status) }}</span></td>
                        <td class="px-5 py-3 text-center">
                            @if($a->id == auth('admin')->id())
                                <span class="text-slate-400 text-xs font-bold bg-slate-100 px-3 py-1 rounded-lg">Akun Saya</span>
                            @else
                                <div class="flex gap-1 justify-center">
                                    <a href="{{ route('admin.admin-user.edit', $a) }}" class="text-slate-600 bg-white border border-slate-300 hover:bg-blue-50 px-3 py-1 rounded-lg font-bold text-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.admin-user.destroy', $a) }}" onsubmit="return confirm('Hapus akun {{ addslashes($a->nama) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-lg font-bold text-xs">Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">{{ $admins->links() }}</div>
    </div>
</div>
@endsection