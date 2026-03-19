@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard Overview')
@section('content')
<div class="fade-in">
    <div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-3xl p-6 md:p-10 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -mt-10 -mr-10 pointer-events-none"></div>
        <h1 class="text-2xl md:text-3xl font-extrabold mb-3">Selamat Datang, {{ auth('admin')->user()->nama }}! 👋</h1>
        <p class="text-blue-50 text-sm max-w-2xl">
            @if($stats['menunggu'] > 0)
                Terdapat <strong>{{ $stats['menunggu'] }} berkas</strong> menunggu verifikasi.
            @else
                Semua berkas sudah terverifikasi 🎉
            @endif
        </p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:-translate-y-1 transition">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div><p class="text-[10px] font-bold text-slate-500 uppercase">Total Pendaftar</p><h3 class="text-2xl font-extrabold text-slate-800">{{ $stats['total'] }}</h3></div>
        </div>
        <a href="{{ route('admin.verifikasi.index') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:-translate-y-1 transition cursor-pointer">
            <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div><p class="text-[10px] font-bold text-slate-500 uppercase">Menunggu Cek</p><h3 class="text-2xl font-extrabold text-slate-800">{{ $stats['menunggu'] }}</h3></div>
        </a>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:-translate-y-1 transition">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div><p class="text-[10px] font-bold text-slate-500 uppercase">Diterima</p><h3 class="text-2xl font-extrabold text-slate-800">{{ $stats['diterima'] }}</h3></div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:-translate-y-1 transition">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div><p class="text-[10px] font-bold text-slate-500 uppercase">Sisa Kuota MIPA</p><h3 class="text-2xl font-extrabold text-slate-800">{{ $stats['sisa_mipa'] }}</h3></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Grafik Pendaftar 7 Hari Terakhir</h3>
            <canvas id="chart-dashboard" height="100"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Distribusi Jalur</h3>
            <canvas id="chart-jalur" height="180"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-extrabold text-slate-800">Pendaftar Terbaru</h3>
            <a href="{{ route('admin.pendaftar.index') }}" class="text-blue-600 text-sm font-bold hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[600px]">
                <thead><tr class="text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-3 font-extrabold">Nama</th>
                    <th class="px-6 py-3 font-extrabold">Asal Sekolah</th>
                    <th class="px-6 py-3 font-extrabold">Jalur</th>
                    <th class="px-6 py-3 font-extrabold text-center">Aksi</th>
                </tr></thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($pendaftar_terbaru as $s)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3"><span class="font-bold text-slate-800">{{ $s->nama }}</span><br><span class="text-[10px] text-slate-400">{{ $s->nisn }}</span></td>
                        <td class="px-6 py-3 text-slate-600">{{ $s->asal_sekolah }}</td>
                        <td class="px-6 py-3 font-bold text-blue-600">{{ $s->jalur }} - {{ $s->jurusan }}</td>
                        <td class="px-6 py-3 text-center"><a href="{{ route('admin.verifikasi.index', ['aktif' => $s->id]) }}" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-blue-700">Verifikasi</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada pendaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('chart-dashboard'), {
    type: 'line',
    data: {
        labels: @json($chart_data->pluck('label')),
        datasets: [{ label: 'Pendaftar', data: @json($chart_data->pluck('count')), borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,0.08)', borderWidth: 2.5, tension: 0.4, fill: true }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
});
new Chart(document.getElementById('chart-jalur'), {
    type: 'doughnut',
    data: {
        labels: @json(array_keys($jalur_data)),
        datasets: [{ data: @json(array_values($jalur_data)), backgroundColor: ['#2563eb','#7c3aed','#0891b2'], borderWidth: 0 }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
});
</script>
@endpush