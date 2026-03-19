@extends('layouts.admin')
@section('title','Tambah Admin')
@section('page-title','Tambah Akun Admin')
@section('content')
<div class="fade-in max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.admin-user.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-extrabold text-slate-800">Tambah Akun Admin Baru</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.admin-user.store') }}" class="space-y-5">
            @csrf
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4"><ul class="text-sm text-red-700 list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap *</label><input type="text" name="nama" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Email *</label><input type="email" name="email" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Password *</label><input type="password" name="password" required placeholder="Min. 8 karakter" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Konfirmasi Password *</label><input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Role *</label>
                    <select name="role" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="super_admin">Super Admin</option>
                        <option value="operator_verifikasi">Operator Verifikasi</option>
                        <option value="operator_konten">Operator Konten</option>
                        <option value="viewer">Viewer</option>
                    </select>
                </div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">No. WhatsApp</label><input type="text" name="no_wa" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.admin-user.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg> Buat Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection