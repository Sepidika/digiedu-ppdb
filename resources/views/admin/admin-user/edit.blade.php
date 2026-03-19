@extends('layouts.admin')
@section('title','Edit Admin')
@section('page-title','Edit Akun Admin')
@section('content')
<div class="fade-in max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.admin-user.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-extrabold text-slate-800">Edit: {{ $adminUser->nama }}</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.admin-user.update', $adminUser) }}" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap *</label><input type="text" name="nama" value="{{ old('nama',$adminUser->nama) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Email</label><input type="text" value="{{ $adminUser->email }}" readonly class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold bg-slate-50 text-slate-500 cursor-not-allowed"></div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Password Baru (kosongkan jika tidak diubah)</label><input type="password" name="password" placeholder="Min. 8 karakter" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Konfirmasi Password</label><input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Role *</label>
                    <select name="role" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach(['super_admin'=>'Super Admin','operator_verifikasi'=>'Operator Verifikasi','operator_konten'=>'Operator Konten','viewer'=>'Viewer'] as $val=>$label)
                        <option value="{{ $val }}" {{ $adminUser->role==$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Status *</label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="aktif" {{ $adminUser->status=='aktif'?'selected':'' }}>Aktif</option>
                        <option value="nonaktif" {{ $adminUser->status=='nonaktif'?'selected':'' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="md:col-span-2"><label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">No. WhatsApp</label><input type="text" name="no_wa" value="{{ old('no_wa',$adminUser->no_wa) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.admin-user.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection