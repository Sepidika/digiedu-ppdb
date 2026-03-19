<?php
/**
 * DigiEdu PPDB - Blade Views Writer
 * Jalankan: php write-views.php
 * Letakkan file ini di ROOT project Laravel
 */

$views = [];

// ============================================================
// layouts/admin.blade.php
// ============================================================
$views['resources/views/layouts/admin.blade.php'] = <<<'BLADE'
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - DigiEdu PPDB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: "Plus Jakarta Sans", sans-serif; background-color: #f8fafc; }
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="text-slate-800 antialiased flex h-screen w-full overflow-hidden">
<div id="mobile-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 z-40 hidden md:hidden"></div>
<aside id="sidebar" class="fixed md:static inset-y-0 left-0 w-72 bg-slate-900 text-slate-300 flex flex-col z-50 shadow-2xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 h-full shrink-0">
    <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center text-white font-bold text-xl">D</div>
            <span class="font-extrabold text-2xl text-white">DigiEdu<span class="text-blue-500">.</span></span>
        </div>
        <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white bg-slate-800 p-1.5 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1 custom-scrollbar">
        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Menu Utama PPDB</p>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span class="font-medium text-sm">Dashboard</span>
        </a>
        <a href="{{ route('admin.pendaftar.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.pendaftar.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="font-medium text-sm">Master Data Pendaftar</span>
        </a>
        <a href="{{ route('admin.verifikasi.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.verifikasi.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium text-sm">Verifikasi Berkas</span>
            </div>
            @php $jml = \App\Models\Pendaftar::where('status','Menunggu')->count() @endphp
            @if($jml > 0)<span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $jml }}</span>@endif
        </a>
        <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.pengumuman.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-sm">Pengumuman Seleksi</span>
        </a>
        <a href="{{ route('admin.kartu.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.kartu.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"></path></svg>
            <span class="font-medium text-sm">Cetak Kartu Peserta</span>
        </a>
        <a href="{{ route('admin.jadwal.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.jadwal.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="font-medium text-sm">Jadwal PPDB</span>
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span class="font-medium text-sm">Laporan & Statistik</span>
        </a>
        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-5">Manajemen Konten</p>
        <a href="{{ route('admin.artikel.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.artikel.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            <span class="font-medium text-sm">Mading & Artikel</span>
        </a>
        <a href="{{ route('admin.galeri.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.galeri.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="font-medium text-sm">Galeri Foto & Video</span>
        </a>
        <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.banner.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
            <span class="font-medium text-sm">Manajemen Banner</span>
        </a>
        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-5">Sistem & Keamanan</p>
        <a href="{{ route('admin.admin-user.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.admin-user.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="font-medium text-sm">Manajemen Admin</span>
        </a>
        <a href="{{ route('admin.log.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.log.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <span class="font-medium text-sm">Log Aktivitas</span>
        </a>
        <a href="{{ route('admin.backup.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.backup.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
            <span class="font-medium text-sm">Backup & Export</span>
        </a>
        <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.pengaturan.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="font-medium text-sm">Pengaturan Sistem</span>
        </a>
    </div>
    <div class="p-4 border-t border-slate-800 shrink-0">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-red-600 text-slate-300 hover:text-white transition-all font-bold text-sm border border-slate-700">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar Sistem
            </button>
        </form>
    </div>
</aside>
<main class="flex-1 flex flex-col h-screen min-w-0 bg-slate-50 relative">
    <header class="h-16 md:h-20 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-6 shadow-sm shrink-0 z-10">
        <div class="flex items-center gap-3 min-w-0">
            <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-blue-600 bg-slate-100 p-1.5 rounded-lg border border-slate-200 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-lg md:text-xl font-extrabold text-slate-800 truncate">@yield('page-title','Dashboard')</h2>
        </div>
        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('admin.verifikasi.index') }}" class="relative text-slate-400 hover:text-blue-600 transition">
                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                @if(\App\Models\Pendaftar::where('status','Menunggu')->count() > 0)
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                @endif
            </a>
            <div class="flex items-center gap-3 pl-4 border-l border-slate-200 p-2 rounded-xl">
                <div class="text-right hidden md:block">
                    <p class="text-[14px] font-bold text-slate-800">{{ auth('admin')->user()->nama }}</p>
                    <p class="text-xs text-slate-500">{{ auth('admin')->user()->role_label }}</p>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->nama) }}&background=eff6ff&color=2563eb" class="w-9 h-9 md:w-10 md:h-10 rounded-full border border-slate-200">
            </div>
        </div>
    </header>
    @if(session('success'))
    <div id="flash-success" class="mx-4 md:mx-6 mt-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-semibold text-sm flex items-center justify-between fade-in">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-green-400 hover:text-green-700">✕</button>
    </div>
    @endif
    @if(session('error'))
    <div id="flash-error" class="mx-4 md:mx-6 mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-semibold text-sm flex items-center justify-between fade-in">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-red-400 hover:text-red-700">✕</button>
    </div>
    @endif
    @if(session('info'))
    <div id="flash-info" class="mx-4 md:mx-6 mt-4 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl font-semibold text-sm flex items-center justify-between fade-in">
        <span>{{ session('info') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-blue-400 hover:text-blue-700">✕</button>
    </div>
    @endif
    <div class="flex-1 overflow-y-auto overflow-x-hidden p-4 md:p-6 lg:p-8 custom-scrollbar">
        @yield('content')
    </div>
</main>
<script>
function toggleSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('mobile-overlay');
    if (s.classList.contains('-translate-x-full')) { s.classList.remove('-translate-x-full'); o.classList.remove('hidden'); }
    else { s.classList.add('-translate-x-full'); o.classList.add('hidden'); }
}
setTimeout(() => {
    ['flash-success','flash-error','flash-info'].forEach(id => { const el = document.getElementById(id); if(el) el.remove(); });
}, 4000);
</script>
@stack('scripts')
</body>
</html>
BLADE;

// ============================================================
// admin/auth/login.blade.php
// ============================================================
$views['resources/views/admin/auth/login.blade.php'] = <<<'BLADE'
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - DigiEdu PPDB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: "Plus Jakarta Sans", sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4">D</div>
        <h1 class="text-3xl font-extrabold text-white">DigiEdu<span class="text-blue-400">.</span></h1>
        <p class="text-slate-400 text-sm mt-1">Panel Admin PPDB</p>
    </div>
    <div class="bg-white rounded-3xl shadow-2xl p-8">
        <h2 class="text-xl font-extrabold text-slate-800 mb-1">Selamat Datang Kembali</h2>
        <p class="text-slate-500 text-sm mb-6">Masuk untuk mengelola sistem PPDB.</p>
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm font-semibold">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Email Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@digiedu.sch.id"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Password</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded">
                <label class="text-sm font-medium text-slate-600">Ingat saya</label>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-3.5 rounded-xl font-extrabold text-sm hover:from-blue-700 hover:to-blue-600 transition shadow-lg">
                Masuk ke Panel Admin
            </button>
        </form>
    </div>
    <p class="text-center text-slate-500 text-xs mt-6">© {{ date('Y') }} DigiEdu School.</p>
</div>
</body>
</html>
BLADE;

// ============================================================
// admin/dashboard.blade.php
// ============================================================
$views['resources/views/admin/dashboard.blade.php'] = <<<'BLADE'
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
                        <td class="px-6 py-3 text-center"><a href="{{ route('admin.verifikasi.index') }}" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-blue-700">Verifikasi</a></td>
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
BLADE;

// ============================================================
// admin/pendaftar/index.blade.php
// ============================================================
$views['resources/views/admin/pendaftar/index.blade.php'] = <<<'BLADE'
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
BLADE;

// ============================================================
// admin/pendaftar/create.blade.php
// ============================================================
$views['resources/views/admin/pendaftar/create.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Tambah Pendaftar')
@section('page-title','Tambah Data Pendaftar')
@section('content')
<div class="fade-in max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.pendaftar.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Tambah Pendaftar Baru</h2>
            <p class="text-xs text-slate-500">Isi data biodata siswa secara manual.</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.pendaftar.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <ul class="text-sm text-red-700 font-semibold space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif
            <div>
                <h4 class="text-sm font-extrabold text-slate-800 border-b border-slate-200 pb-2 mb-4">A. Data Pribadi</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin')=='Laki-Laki'?'selected':'' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">NISN *</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-extrabold text-slate-800 border-b border-slate-200 pb-2 mb-4">B. Akademik & Orang Tua</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Asal Sekolah *</label>
                        <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jalur *</label>
                        <select name="jalur" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="Zonasi" {{ old('jalur')=='Zonasi'?'selected':'' }}>Zonasi</option>
                            <option value="Prestasi Akademik" {{ old('jalur')=='Prestasi Akademik'?'selected':'' }}>Prestasi Akademik</option>
                            <option value="Afirmasi" {{ old('jalur')=='Afirmasi'?'selected':'' }}>Afirmasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jurusan *</label>
                        <select name="jurusan" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="MIPA" {{ old('jurusan')=='MIPA'?'selected':'' }}>MIPA</option>
                            <option value="IPS" {{ old('jurusan')=='IPS'?'selected':'' }}>IPS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nilai Rata-rata</label>
                        <input type="number" step="0.01" name="nilai_rata" value="{{ old('nilai_rata') }}" min="0" max="100" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Orang Tua / Wali *</label>
                        <input type="text" name="nama_wali" value="{{ old('nama_wali') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">No. WA Wali *</label>
                        <input type="text" name="no_wa" value="{{ old('no_wa') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-extrabold text-slate-800 border-b border-slate-200 pb-2 mb-4">C. Upload Dokumen</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach(['foto_kk'=>'Kartu Keluarga','foto_ijazah'=>'Ijazah / SKL','foto_rapor'=>'Nilai Rapor','foto_siswa'=>'Foto Siswa 3x4'] as $field=>$label)
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">{{ $label }}</label>
                        <input type="file" name="{{ $field }}" accept="image/*" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.pendaftar.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/pendaftar/edit.blade.php
// ============================================================
$views['resources/views/admin/pendaftar/edit.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Edit Pendaftar')
@section('page-title','Edit Biodata Pendaftar')
@section('content')
<div class="fade-in max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.pendaftar.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Edit: {{ $pendaftar->nama }}</h2>
            <p class="text-xs text-slate-500">{{ $pendaftar->no_reg }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.pendaftar.update', $pendaftar) }}" class="space-y-5">
            @csrf @method('PUT')
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <ul class="text-sm text-red-700 font-semibold space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap *</label>
                    <input type="text" name="nama" value="{{ old('nama',$pendaftar->nama) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Laki-Laki" {{ $pendaftar->jenis_kelamin=='Laki-Laki'?'selected':'' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ $pendaftar->jenis_kelamin=='Perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">NISN</label>
                    <input type="text" value="{{ $pendaftar->nisn }}" readonly class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-bold bg-slate-50 text-slate-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir',$pendaftar->tempat_lahir) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir',$pendaftar->tanggal_lahir?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jalur</label>
                    <select name="jalur" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach(['Zonasi','Prestasi Akademik','Afirmasi'] as $j)
                        <option value="{{ $j }}" {{ $pendaftar->jalur==$j?'selected':'' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jurusan</label>
                    <select name="jurusan" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="MIPA" {{ $pendaftar->jurusan=='MIPA'?'selected':'' }}>MIPA</option>
                        <option value="IPS" {{ $pendaftar->jurusan=='IPS'?'selected':'' }}>IPS</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nilai Rata-rata</label>
                    <input type="number" step="0.01" name="nilai_rata" value="{{ old('nilai_rata',$pendaftar->nilai_rata) }}" min="0" max="100" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Menunggu" {{ $pendaftar->status=='Menunggu'?'selected':'' }}>Menunggu</option>
                        <option value="Diterima" {{ $pendaftar->status=='Diterima'?'selected':'' }}>Diterima</option>
                        <option value="Ditolak" {{ $pendaftar->status=='Ditolak'?'selected':'' }}>Ditolak</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Nama Wali</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali',$pendaftar->nama_wali) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">No. WA Wali</label>
                    <input type="text" name="no_wa" value="{{ old('no_wa',$pendaftar->no_wa) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Catatan Admin</label>
                    <textarea name="catatan_admin" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">{{ old('catatan_admin',$pendaftar->catatan_admin) }}</textarea>
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.pendaftar.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/verifikasi/index.blade.php
// ============================================================
$views['resources/views/admin/verifikasi/index.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Verifikasi Berkas')
@section('page-title','Verifikasi Dokumen Pendaftar')
@section('content')
<div class="fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 border-b border-slate-200 pb-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Verifikasi Dokumen Pendaftar</h2>
            <p class="text-xs font-semibold text-slate-500">Cek keaslian berkas pendaftar satu per satu.</p>
        </div>
        <div class="bg-amber-100 border border-amber-200 text-amber-700 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 shrink-0">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
            {{ $antrean->count() }} Antrean Tersisa
        </div>
    </div>
    @if($antrean->isEmpty())
    <div class="bg-green-50 border border-green-200 rounded-2xl p-10 text-center">
        <svg class="w-16 h-16 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h3 class="text-xl font-extrabold text-green-700 mb-2">Semua Berkas Sudah Diverifikasi!</h3>
        <p class="text-green-600 font-medium">Tidak ada antrean verifikasi saat ini.</p>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex flex-col max-h-[500px] lg:h-[calc(100vh-16rem)]">
            <h3 class="font-extrabold text-slate-800 mb-3 text-[10px] uppercase tracking-wide">Antrean ({{ $antrean->count() }})</h3>
            <div class="flex flex-row lg:flex-col overflow-x-auto lg:overflow-y-auto space-x-2 lg:space-x-0 lg:space-y-2 hide-scroll">
                @foreach($antrean as $item)
                <a href="?aktif={{ $item->id }}" class="shrink-0 w-48 lg:w-full p-3 rounded-xl cursor-pointer transition border {{ $aktif && $aktif->id==$item->id ? 'bg-blue-50 border-blue-300 shadow-sm' : 'hover:bg-slate-50 border-slate-200' }}">
                    <p class="font-{{ $aktif && $aktif->id==$item->id ? 'extrabold text-blue-900' : 'bold text-slate-700' }} text-xs truncate">{{ $item->nama }}</p>
                    <p class="text-[10px] font-semibold {{ $aktif && $aktif->id==$item->id ? 'text-blue-600' : 'text-slate-500' }} mt-0.5">{{ $item->no_reg }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @if($aktif)
        <div class="lg:col-span-4 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-extrabold text-2xl mb-3 mx-auto border-4 border-white shadow-md">{{ substr($aktif->nama,0,1) }}</div>
            <h3 class="font-extrabold text-lg text-center text-slate-800">{{ $aktif->nama }}</h3>
            <p class="text-center text-xs font-semibold text-slate-500 mt-2 mb-5 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg mx-auto w-max">{{ $aktif->asal_sekolah }}</p>
            <div class="space-y-3 text-sm flex-1 border-t border-slate-100 pt-5">
                <div class="flex justify-between"><span class="text-slate-500 text-xs">NISN</span><span class="font-extrabold text-slate-800 bg-slate-100 px-2 py-0.5 rounded text-xs">{{ $aktif->nisn }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500 text-xs">Jalur & Jurusan</span><span class="font-extrabold text-blue-600 bg-blue-50 px-2 py-0.5 rounded text-xs">{{ $aktif->jalur }} - {{ $aktif->jurusan }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500 text-xs">Nilai</span><span class="font-extrabold text-slate-800 bg-slate-100 px-2 py-0.5 rounded text-xs">{{ $aktif->nilai_rata ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500 text-xs">Wali</span><span class="font-semibold text-slate-700 text-xs">{{ $aktif->nama_wali }}</span></div>
            </div>
            <div class="mt-6 space-y-2">
                <form method="POST" action="{{ route('admin.verifikasi.setuju', $aktif->id) }}">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-extrabold text-sm transition shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Setujui Berkas
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.verifikasi.tolak', $aktif->id) }}" class="space-y-2">
                    @csrf
                    <textarea name="catatan_admin" rows="2" placeholder="Alasan penolakan wajib diisi..." required class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-red-400 outline-none resize-none"></textarea>
                    <button type="submit" class="w-full bg-white border-2 border-red-200 text-red-600 hover:bg-red-50 py-3 rounded-xl font-extrabold text-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Tolak Berkas
                    </button>
                </form>
            </div>
        </div>
        <div class="lg:col-span-5 bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col min-h-[400px]">
            <h3 class="font-extrabold text-slate-800 mb-3 text-[10px] uppercase tracking-wide">Dokumen Asli</h3>
            <div class="flex gap-2 mb-4 flex-wrap">
                @foreach(['foto_kk'=>'Kartu Keluarga','foto_ijazah'=>'Ijazah','foto_rapor'=>'Nilai Rapor'] as $field=>$label)
                @if($aktif->$field)
                    <a href="{{ asset('storage/'.$aktif->$field) }}" target="_blank" class="flex-1 min-w-[100px] p-2 border-2 border-blue-500 bg-blue-50 rounded-xl text-center text-xs font-extrabold text-blue-800 hover:bg-blue-100">{{ $label }}</a>
                @else
                    <span class="flex-1 min-w-[100px] p-2 border-2 border-slate-200 bg-slate-50 rounded-xl text-center text-xs font-bold text-slate-400">{{ $label }} (Belum Upload)</span>
                @endif
                @endforeach
            </div>
            <div class="flex-1 bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center p-4">
                @if($aktif->foto_kk)
                    <img src="{{ asset('storage/'.$aktif->foto_kk) }}" alt="Dokumen" class="max-w-full max-h-full object-contain rounded-lg">
                @else
                    <div class="text-center text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="font-semibold text-sm">Belum ada dokumen diupload</p>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
BLADE;

// ============================================================
// admin/pengumuman/index.blade.php
// ============================================================
$views['resources/views/admin/pengumuman/index.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Pengumuman Seleksi')
@section('page-title','Pengumuman Hasil Seleksi')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Pengumuman Hasil Seleksi</h2>
            <p class="text-sm text-slate-500 mt-1">Publikasi status kelulusan peserta PPDB.</p>
        </div>
        <form method="POST" action="{{ route('admin.pengumuman.publish') }}">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-green-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                Publish Pengumuman
            </button>
        </form>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div><p class="text-xs font-bold text-green-600 uppercase">Diterima</p><h3 class="text-3xl font-extrabold text-green-800">{{ $diterima }}</h3></div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div><p class="text-xs font-bold text-red-600 uppercase">Tidak Diterima</p><h3 class="text-3xl font-extrabold text-red-800">{{ $ditolak }}</h3></div>
        </div>
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div><p class="text-xs font-bold text-amber-600 uppercase">Belum Diproses</p><h3 class="text-3xl font-extrabold text-amber-800">{{ $menunggu }}</h3></div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50"><h3 class="font-extrabold text-slate-800">Daftar Hasil Seleksi</h3></div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[700px]">
                <thead><tr class="text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-100">
                    <th class="px-5 py-3 font-extrabold">Nama Siswa</th>
                    <th class="px-5 py-3 font-extrabold">NISN</th>
                    <th class="px-5 py-3 font-extrabold">Jalur</th>
                    <th class="px-5 py-3 font-extrabold">Nilai</th>
                    <th class="px-5 py-3 font-extrabold text-center">Status</th>
                    <th class="px-5 py-3 font-extrabold text-center">Notif WA</th>
                </tr></thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($pendaftars as $p)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-bold">{{ $p->nama }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $p->nisn }}</td>
                        <td class="px-5 py-3 font-bold text-blue-600">{{ $p->jalur }} - {{ $p->jurusan }}</td>
                        <td class="px-5 py-3 font-bold">{{ $p->nilai_rata ?? '-' }}</td>
                        <td class="px-5 py-3 text-center">{!! $p->status_badge !!}</td>
                        <td class="px-5 py-3 text-center">
                            <form method="POST" action="{{ route('admin.pengumuman.notif', $p->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-[#25D366] text-white px-3 py-1 rounded-lg text-[10px] font-bold hover:opacity-90">Kirim WA</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada data seleksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">{{ $pendaftars->links() }}</div>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/kartu/index.blade.php
// ============================================================
$views['resources/views/admin/kartu/index.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Cetak Kartu Peserta')
@section('page-title','Cetak Kartu Peserta PPDB')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Cetak Kartu Peserta PPDB</h2>
            <p class="text-sm text-slate-500 mt-1">Generate kartu ujian per siswa.</p>
        </div>
        <a href="{{ route('admin.kartu.semua') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Semua
        </a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if($preview)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Preview Kartu Peserta</h3>
            <div class="border-2 border-slate-200 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white font-bold text-xl">D</div>
                    <div><p class="text-white font-extrabold">DigiEdu School</p><p class="text-blue-200 text-xs">Kartu Peserta PPDB {{ date('Y') }}/{{ date('Y')+1 }}</p></div>
                </div>
                <div class="p-6 grid grid-cols-3 gap-4">
                    <div class="col-span-1 flex flex-col items-center">
                        @if($preview->foto_siswa)
                            <img src="{{ asset('storage/'.$preview->foto_siswa) }}" class="w-24 h-28 object-cover rounded-xl border-2 border-slate-300 mb-2">
                        @else
                            <div class="w-24 h-28 bg-slate-200 rounded-xl border-2 border-slate-300 flex items-center justify-center text-slate-400 text-xs text-center mb-2">Foto 3x4</div>
                        @endif
                        <div class="w-20 h-20 bg-slate-100 rounded border flex items-center justify-center text-[10px] text-slate-400">QR Code</div>
                    </div>
                    <div class="col-span-2 space-y-2 text-sm">
                        <div><p class="text-[10px] text-slate-400 uppercase font-bold">No. Peserta</p><p class="font-extrabold text-slate-900 tracking-widest">{{ $preview->no_reg }}</p></div>
                        <div><p class="text-[10px] text-slate-400 uppercase font-bold">Nama</p><p class="font-bold text-slate-800">{{ $preview->nama }}</p></div>
                        <div><p class="text-[10px] text-slate-400 uppercase font-bold">Asal Sekolah</p><p class="font-semibold text-slate-700 text-xs">{{ $preview->asal_sekolah }}</p></div>
                        <div class="grid grid-cols-2 gap-2">
                            <div><p class="text-[10px] text-slate-400 uppercase font-bold">Jalur</p><p class="font-semibold text-blue-700 text-xs">{{ $preview->jalur }}</p></div>
                            <div><p class="text-[10px] text-slate-400 uppercase font-bold">Jurusan</p><p class="font-semibold text-blue-700 text-xs">{{ $preview->jurusan }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.kartu.cetak', $preview->id) }}" class="mt-4 w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition flex items-center justify-center gap-2 block text-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak / Download PDF
            </a>
        </div>
        @endif
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Pilih Siswa untuk Cetak</h3>
            <form method="GET" class="relative mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NISN..."
                    class="w-full pl-9 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar">
                @forelse($pendaftars as $p)
                <div class="flex items-center justify-between p-3 hover:bg-slate-50 border border-slate-200 rounded-xl">
                    <div>
                        <p class="font-bold text-sm text-slate-800">{{ $p->nama }}</p>
                        <p class="text-[10px] text-slate-500">{{ $p->nisn }} • {{ $p->jalur }} {{ $p->jurusan }}</p>
                    </div>
                    <a href="{{ route('admin.kartu.cetak', $p->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-blue-700">Cetak</a>
                </div>
                @empty
                <p class="text-center text-slate-400 py-4 text-sm">Tidak ada data.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/kartu/preview.blade.php
// ============================================================
$views['resources/views/admin/kartu/preview.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Preview Kartu')
@section('page-title','Preview Kartu Peserta')
@section('content')
<div class="fade-in max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kartu.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-extrabold text-slate-800">Kartu: {{ $pendaftar->nama }}</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="border-2 border-slate-200 rounded-2xl overflow-hidden mb-4" id="kartu-print">
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-4 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white font-bold text-xl">D</div>
                <div><p class="text-white font-extrabold">DigiEdu School</p><p class="text-blue-200 text-xs">Kartu Peserta PPDB {{ date('Y') }}/{{ date('Y')+1 }}</p></div>
            </div>
            <div class="p-6 grid grid-cols-3 gap-4">
                <div class="col-span-1 flex flex-col items-center">
                    @if($pendaftar->foto_siswa)
                        <img src="{{ asset('storage/'.$pendaftar->foto_siswa) }}" class="w-24 h-28 object-cover rounded-xl border-2 border-slate-300 mb-2">
                    @else
                        <div class="w-24 h-28 bg-slate-200 rounded-xl border-2 border-slate-300 flex items-center justify-center text-slate-400 text-xs mb-2">Foto 3x4</div>
                    @endif
                    <div class="w-20 h-20 bg-slate-100 rounded border flex items-center justify-center text-[10px] text-slate-400">QR Code</div>
                </div>
                <div class="col-span-2 space-y-2 text-sm">
                    <div><p class="text-[10px] text-slate-400 uppercase font-bold">No. Peserta</p><p class="font-extrabold text-slate-900 text-lg tracking-widest">{{ $pendaftar->no_reg }}</p></div>
                    <div><p class="text-[10px] text-slate-400 uppercase font-bold">Nama Lengkap</p><p class="font-bold text-slate-800">{{ $pendaftar->nama }}</p></div>
                    <div><p class="text-[10px] text-slate-400 uppercase font-bold">Asal Sekolah</p><p class="font-semibold text-slate-700 text-xs">{{ $pendaftar->asal_sekolah }}</p></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div><p class="text-[10px] text-slate-400 uppercase font-bold">Jalur</p><p class="font-semibold text-blue-700 text-xs">{{ $pendaftar->jalur }}</p></div>
                        <div><p class="text-[10px] text-slate-400 uppercase font-bold">Jurusan</p><p class="font-semibold text-blue-700 text-xs">{{ $pendaftar->jurusan }}</p></div>
                    </div>
                </div>
            </div>
        </div>
        <button onclick="window.print()" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak / Print
        </button>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/jadwal/index.blade.php
// ============================================================
$views['resources/views/admin/jadwal/index.blade.php'] = <<<'BLADE'
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
BLADE;

// ============================================================
// admin/laporan/index.blade.php
// ============================================================
$views['resources/views/admin/laporan/index.blade.php'] = <<<'BLADE'
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
BLADE;

// ============================================================
// admin/artikel/index.blade.php
// ============================================================
$views['resources/views/admin/artikel/index.blade.php'] = <<<'BLADE'
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
BLADE;

// ============================================================
// admin/artikel/create.blade.php
// ============================================================
$views['resources/views/admin/artikel/create.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Buat Artikel')
@section('page-title','Buat Artikel Baru')
@section('content')
<div class="fade-in max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.artikel.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-extrabold text-slate-800">Buat Artikel Baru</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.artikel.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <ul class="text-sm text-red-700 font-semibold list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Foto Cover</label>
                    <div class="w-full h-40 border-2 border-dashed border-blue-300 rounded-xl bg-blue-50 flex flex-col items-center justify-center text-center p-4 hover:bg-blue-100 cursor-pointer relative">
                        <svg class="w-8 h-8 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <p class="text-xs font-bold text-blue-800">Klik untuk upload</p>
                        <p class="text-[10px] text-blue-600">JPG/PNG, Maks: 2MB</p>
                        <input type="file" name="foto_cover" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <div class="mt-4">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="published">Terbit (Publish)</option>
                            <option value="draft">Simpan Draft</option>
                        </select>
                    </div>
                </div>
                <div class="lg:col-span-2 space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Judul Artikel *</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Judul artikel..." class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Kategori *</label>
                            <select name="kategori" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Esai / Jurnal Siswa">Esai / Jurnal Siswa</option>
                                <option value="Kegiatan Sekolah">Kegiatan Sekolah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Penulis *</label>
                            <input type="text" name="penulis" value="{{ old('penulis','Tim Jurnalistik PPDB') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Isi Artikel *</label>
                        <textarea name="isi" rows="8" required placeholder="Ketik isi artikel di sini..." class="w-full px-4 py-3 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none leading-relaxed">{{ old('isi') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.artikel.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/artikel/edit.blade.php
// ============================================================
$views['resources/views/admin/artikel/edit.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Edit Artikel')
@section('page-title','Edit Artikel')
@section('content')
<div class="fade-in max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.artikel.index') }}" class="w-9 h-9 rounded-full bg-white border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-extrabold text-slate-800">Edit Artikel</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form method="POST" action="{{ route('admin.artikel.update', $artikel) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Judul *</label>
                    <input type="text" name="judul" value="{{ old('judul',$artikel->judul) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        @foreach(['Pengumuman','Esai / Jurnal Siswa','Kegiatan Sekolah'] as $k)
                        <option value="{{ $k }}" {{ $artikel->kategori==$k?'selected':'' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis',$artikel->penulis) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="published" {{ $artikel->status=='published'?'selected':'' }}>Published</option>
                        <option value="draft" {{ $artikel->status=='draft'?'selected':'' }}>Draft</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Ganti Foto Cover</label>
                    <input type="file" name="foto_cover" accept="image/*" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                    @if($artikel->foto_cover)
                        <img src="{{ asset('storage/'.$artikel->foto_cover) }}" class="mt-2 h-16 rounded-lg object-cover">
                    @endif
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Isi Artikel *</label>
                    <textarea name="isi" rows="8" required class="w-full px-4 py-3 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none leading-relaxed">{{ old('isi',$artikel->isi) }}</textarea>
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.artikel.index') }}" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/galeri/index.blade.php
// ============================================================
$views['resources/views/admin/galeri/index.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Galeri')
@section('page-title','Galeri Foto & Video')
@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Galeri Foto & Video</h2>
            <p class="text-sm text-slate-500 mt-1">Dokumentasi kegiatan sekolah.</p>
        </div>
        <button onclick="document.getElementById('modal-upload').classList.remove('hidden')" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Upload Foto
        </button>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($galeris as $g)
        <div class="group relative bg-slate-200 rounded-2xl overflow-hidden aspect-square">
            <img src="{{ asset('storage/'.$g->file) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                <div><p class="text-white font-bold text-xs">{{ $g->judul }}</p><p class="text-slate-300 text-[10px]">{{ $g->kategori }}</p></div>
            </div>
            <form method="POST" action="{{ route('admin.galeri.destroy', $g) }}" onsubmit="return confirm('Hapus file ini?')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                @csrf @method('DELETE')
                <button type="submit" class="w-7 h-7 bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold">✕</button>
            </form>
        </div>
        @empty
        <div class="col-span-4 py-16 text-center text-slate-400"><p class="font-semibold">Belum ada foto/video.</p></div>
        @endforelse
        <div class="border-2 border-dashed border-slate-300 rounded-2xl aspect-square flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition" onclick="document.getElementById('modal-upload').classList.remove('hidden')">
            <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <p class="text-xs font-bold text-slate-400">Tambah Foto</p>
        </div>
    </div>
    <div id="modal-upload" class="fixed inset-0 bg-slate-900/70 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Upload Foto / Video</h3>
                <button onclick="document.getElementById('modal-upload').classList.add('hidden')" class="text-slate-400 hover:text-red-500">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">File *</label>
                    <input type="file" name="file" accept="image/*,video/mp4" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Judul *</label>
                    <input type="text" name="judul" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Kategori *</label>
                    <select name="kategori" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Kegiatan Akademik">Kegiatan Akademik</option>
                        <option value="Ekstrakurikuler">Ekstrakurikuler</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Fasilitas">Fasilitas</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modal-upload').classList.add('hidden')" class="px-5 py-2.5 text-slate-600 font-semibold hover:bg-slate-100 border border-slate-200 rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md text-sm">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/banner/index.blade.php
// ============================================================
$views['resources/views/admin/banner/index.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Banner')
@section('page-title','Manajemen Banner')
@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800">Manajemen Banner / Slider</h2>
        <p class="text-sm text-slate-500 mt-1">Atur gambar hero halaman depan website.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-4">
            @forelse($banners as $b)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="relative h-36 bg-slate-200 overflow-hidden">
                    <img src="{{ asset('storage/'.$b->file) }}" class="w-full h-full object-cover">
                    <span class="absolute top-2 left-2 {{ $b->aktif?'bg-green-500':'bg-slate-500' }} text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $b->aktif?'AKTIF':'NONAKTIF' }}</span>
                    <span class="absolute top-2 right-2 bg-white/90 text-slate-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Urutan {{ $b->urutan }}</span>
                </div>
                <div class="p-4 flex justify-between items-center">
                    <div><p class="font-bold text-sm text-slate-800">{{ $b->judul }}</p><p class="text-xs text-slate-500">{{ $b->updated_at->format('d M Y') }}</p></div>
                    <form method="POST" action="{{ route('admin.banner.destroy', $b) }}" onsubmit="return confirm('Hapus banner?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded-lg font-bold text-xs hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-slate-400 text-sm font-semibold text-center py-8">Belum ada banner.</p>
            @endforelse
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Upload Banner Baru</h3>
            <form method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">File Gambar *</label>
                    <div class="w-full h-40 border-2 border-dashed border-blue-300 rounded-xl bg-blue-50 flex flex-col items-center justify-center text-center p-4 hover:bg-blue-100 cursor-pointer relative">
                        <svg class="w-8 h-8 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-xs font-bold text-blue-800">Klik untuk pilih gambar</p>
                        <p class="text-[10px] text-blue-600">Rekomendasi: 1920x600px</p>
                        <input type="file" name="file" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Judul Banner *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Banner Utama Hero" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition">Upload Banner</button>
            </form>
        </div>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/admin-user/index.blade.php
// ============================================================
$views['resources/views/admin/admin-user/index.blade.php'] = <<<'BLADE'
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
BLADE;

// ============================================================
// admin/admin-user/create.blade.php
// ============================================================
$views['resources/views/admin/admin-user/create.blade.php'] = <<<'BLADE'
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
BLADE;

// ============================================================
// admin/admin-user/edit.blade.php
// ============================================================
$views['resources/views/admin/admin-user/edit.blade.php'] = <<<'BLADE'
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
BLADE;

// ============================================================
// admin/log/index.blade.php
// ============================================================
$views['resources/views/admin/log/index.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Log Aktivitas')
@section('page-title','Log Aktivitas Sistem')
@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800">Log Aktivitas Sistem</h2>
        <p class="text-sm text-slate-500 mt-1">Rekam jejak semua aktivitas admin.</p>
    </div>
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 text-blue-700 font-semibold text-sm flex items-center gap-3">
        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <p class="font-extrabold">Aktifkan Log Otomatis</p>
            <p class="font-medium mt-1">Jalankan: <code class="bg-blue-100 px-2 py-0.5 rounded text-xs">composer require spatie/laravel-activitylog</code> untuk log semua aktivitas admin secara otomatis.</p>
        </div>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/backup/index.blade.php
// ============================================================
$views['resources/views/admin/backup/index.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Backup & Export')
@section('page-title','Backup & Export Data')
@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800">Backup & Export Data</h2>
        <p class="text-sm text-slate-500 mt-1">Unduh dan amankan seluruh data PPDB.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center text-center gap-3">
            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
            <div><h3 class="font-extrabold text-slate-800">Export Excel</h3><p class="text-xs text-slate-500 mt-1">Data pendaftar dalam .xlsx</p><p class="text-[10px] text-amber-600 mt-1 font-semibold">Perlu: maatwebsite/excel</p></div>
            <a href="{{ route('admin.backup.excel') }}" class="w-full mt-2 bg-green-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-green-700 transition text-center block">Download Excel</a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center text-center gap-3">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-600"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></div>
            <div><h3 class="font-extrabold text-slate-800">Export PDF</h3><p class="text-xs text-slate-500 mt-1">Laporan rekap PPDB .pdf</p><p class="text-[10px] text-amber-600 mt-1 font-semibold">Perlu: barryvdh/laravel-dompdf</p></div>
            <a href="{{ route('admin.backup.pdf') }}" class="w-full mt-2 bg-red-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-red-700 transition text-center block">Download PDF</a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center text-center gap-3">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg></div>
            <div><h3 class="font-extrabold text-slate-800">Backup Database</h3><p class="text-xs text-slate-500 mt-1">Backup semua tabel .sql</p><p class="text-[10px] text-amber-600 mt-1 font-semibold">Perlu: spatie/laravel-backup</p></div>
            <form method="POST" action="{{ route('admin.backup.jalankan') }}" class="w-full mt-2">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition">Jalankan Backup</button>
            </form>
        </div>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// admin/pengaturan/index.blade.php
// ============================================================
$views['resources/views/admin/pengaturan/index.blade.php'] = <<<'BLADE'
@extends('layouts.admin')
@section('title','Pengaturan')
@section('page-title','Pengaturan Sistem')
@section('content')
<div class="fade-in">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800">Pengaturan Sistem</h2>
        <p class="text-sm text-slate-500 mt-1">Ubah identitas profil sekolah dan konfigurasi PPDB.</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-10 max-w-4xl">
        <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="space-y-6">
            @csrf
            <div class="border-b border-slate-100 pb-8">
                <h3 class="text-base font-extrabold text-slate-800 mb-5">Informasi Instansi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2"><label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Sekolah</label><input type="text" name="nama_sekolah" value="{{ $settings['nama_sekolah'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Email Resmi PPDB</label><input type="email" name="email_ppdb" value="{{ $settings['email_ppdb'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">No. WA Admin</label><div class="flex"><span class="bg-slate-100 border border-slate-300 border-r-0 px-4 py-3 rounded-l-xl text-sm font-bold text-slate-500">+62</span><input type="text" name="no_wa_admin" value="{{ $settings['no_wa_admin'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-r-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div></div>
                    <div class="md:col-span-2"><label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Alamat Lengkap</label><textarea name="alamat" rows="2" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">{{ $settings['alamat'] }}</textarea></div>
                </div>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-slate-800 mb-5">Kuota & Konfigurasi PPDB</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kuota MIPA</label><input type="number" name="kuota_mipa" value="{{ $settings['kuota_mipa'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-extrabold focus:ring-2 focus:ring-blue-500 outline-none text-blue-700 bg-blue-50"></div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kuota IPS</label><input type="number" name="kuota_ips" value="{{ $settings['kuota_ips'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-extrabold focus:ring-2 focus:ring-blue-500 outline-none text-purple-700 bg-purple-50"></div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tahun Ajaran</label><input type="text" name="tahun_ajaran" value="{{ $settings['tahun_ajaran'] }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none"></div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Gelombang Aktif</label>
                        <select name="gelombang_aktif" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                            @foreach(['Gelombang 1','Gelombang 2','Gelombang 3'] as $g)
                            <option value="{{ $g }}" {{ $settings['gelombang_aktif']==$g?'selected':'' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-7 py-3 rounded-xl font-extrabold hover:bg-blue-700 transition shadow-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
BLADE;

// ============================================================
// TULIS SEMUA FILE
// ============================================================
$success = 0;
$fail = 0;

foreach ($views as $path => $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    if (file_put_contents($path, $content) !== false) {
        echo "✅ $path\n";
        $success++;
    } else {
        echo "❌ GAGAL: $path\n";
        $fail++;
    }
}

echo "\n";
echo "========================================\n";
echo "Selesai! $success file berhasil ditulis.\n";
if ($fail > 0) echo "$fail file GAGAL.\n";
echo "========================================\n";
echo "Sekarang jalankan: php artisan storage:link\n";
echo "Lalu buka: http://digiedu-ppdb.test/admin/login\n";
echo "Login: admin@digiedu.sch.id | password123\n";
