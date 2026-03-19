@extends('layouts.admin')
@section('title', 'Log Aktivitas Sistem')
@section('page-title', 'Log Aktivitas Sistem')

@section('content')
<div class="fade-in">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="font-black text-slate-800 text-lg">Rekam Jejak Aktivitas</h3>
                <p class="text-xs text-slate-500">Memantau detail perubahan data oleh admin/panitia secara real-time.</p>
            </div>
            <a href="{{ route('admin.log.export') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-emerald-700 transition shadow-sm">Export Log</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-500 text-[10px] uppercase tracking-widest border-b border-slate-100">
                        <th class="px-6 py-4 font-black">Waktu</th>
                        <th class="px-6 py-4 font-black">Admin (Pelaku)</th>
                        <th class="px-6 py-4 font-black">Aksi</th>
                        <th class="px-6 py-4 font-black">Data Terkait</th>
                        <th class="px-6 py-4 font-black">Detail Perubahan (Old ➔ New)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-slate-700 font-bold italic">{{ $log->created_at->translatedFormat('d M Y') }}</span><br>
                            <span class="text-[10px] text-slate-400 font-medium">{{ $log->created_at->format('H:i:s') }} WIB</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-xs shadow-md shadow-blue-100">
                                    {{ substr($log->causer->nama ?? 'SY', 0, 2) }}
                                </div>
                                <div>
                                    <span class="font-black text-slate-700 block text-xs uppercase">{{ $log->causer->nama ?? 'System' }}</span>
                                    <span class="text-[9px] text-blue-500 font-bold">{{ $log->causer->role_label ?? 'Automated' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($log->description == 'Data pendaftar ini telah di-created')
                                <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-lg text-[9px] font-black tracking-tighter">CREATED</span>
                            @elseif($log->description == 'Data pendaftar ini telah di-updated')
                                <span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-lg text-[9px] font-black tracking-tighter">UPDATED</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-lg text-[9px] font-black tracking-tighter uppercase">{{ $log->description }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase">ID #{{ $log->subject_id }}</span><br>
                            <span class="font-black text-slate-800 text-[10px]">{{ $log->log_name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if(isset($log->properties['attributes']))
                                <div class="grid grid-cols-1 gap-2 max-w-xs">
                                    @foreach($log->properties['attributes'] as $key => $value)
                                        <div class="bg-slate-50 p-2 rounded-lg border border-slate-100">
                                            <p class="text-[9px] font-black text-slate-400 uppercase leading-none mb-1">{{ str_replace('_', ' ', $key) }}</p>
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                @if(isset($log->properties['old'][$key]))
                                                    <span class="text-[10px] text-red-500 font-bold line-through opacity-70">{{ $log->properties['old'][$key] ?? 'NULL' }}</span>
                                                    <svg class="w-2 h-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                                @endif
                                                <span class="text-[10px] text-emerald-600 font-black bg-emerald-50 px-1 rounded">{{ $value ?? 'NULL' }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-slate-300 italic text-[10px]">Tidak ada detail perubahan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-bold italic text-sm">Belum ada jejak aktivitas yang terekam sistem.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50/50 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection