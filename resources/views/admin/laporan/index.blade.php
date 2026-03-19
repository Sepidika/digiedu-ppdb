@extends('layouts.admin')
@section('title','Laporan & Statistik')
@section('page-title','Laporan & Statistik PPDB')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Laporan & Statistik PPDB</h2>
            <p class="text-sm text-slate-500 mt-1">Analisis data pendaftaran secara visual.</p>
        </div>
        <a href="{{ route('admin.laporan.pdf') }}" class="bg-green-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-green-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Export PDF
        </a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Tren Pendaftaran Harian</h3>
            <canvas id="chart-harian" height="120"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Distribusi per Jalur</h3>
            <canvas id="chart-jalur" height="120"></canvas>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Perbandingan Jurusan</h3>
            <canvas id="chart-jurusan" height="120"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Rekap Akhir</h3>
            <div class="space-y-3">
                @foreach(['Total Pendaftar'=>[$rekap['total'],'text-slate-800'],'Diterima'=>[$rekap['diterima'],'text-green-700'],'Ditolak'=>[$rekap['ditolak'],'text-red-600'],'Belum Diproses'=>[$rekap['menunggu'],'text-amber-600'],'Diterima MIPA'=>[$rekap['diterima_mipa'],'text-blue-700'],'Diterima IPS'=>[$rekap['diterima_ips'],'text-purple-700']] as $label=>[$val,$color])
                <div class="flex justify-between items-center py-2 border-b border-slate-100 last:border-0">
                    <span class="text-sm text-slate-600">{{ $label }}</span>
                    <span class="font-extrabold {{ $color }}">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
new Chart(document.getElementById('chart-harian'), {
    type: 'bar',
    data: { labels: @json($chart_harian->pluck('label')), datasets: [{ data: @json($chart_harian->pluck('count')), backgroundColor: '#2563eb', borderRadius: 6 }] },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
});
new Chart(document.getElementById('chart-jalur'), {
    type: 'pie',
    data: { labels: @json(array_keys($jalur_data)), datasets: [{ data: @json(array_values($jalur_data)), backgroundColor: ['#2563eb','#7c3aed','#0891b2'], borderWidth: 0 }] },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
new Chart(document.getElementById('chart-jurusan'), {
    type: 'bar',
    data: { labels: ['MIPA','IPS'], datasets: [{ data: [{{ $rekap['diterima_mipa'] }},{{ $rekap['diterima_ips'] }}], backgroundColor: ['#2563eb','#7c3aed'], borderRadius: 8 }] },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
});
</script>
@endpush