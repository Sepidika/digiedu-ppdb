<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - DigiEdu PPDB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Tambahan Alpine.js untuk Dropdown --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            <span class="font-extrabold text-lg text-white uppercase tracking-tighter">SMAN 1 WONGSOREJO<span class="text-blue-500">.</span></span>
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
        <a href="{{ route('admin.log.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.log.*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <span class="font-medium text-sm">Log Aktivitas</span>
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
            
            {{-- DROPDOWN LONCENG NOTIFIKASI --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="relative text-slate-400 hover:text-blue-600 transition p-2 rounded-xl hover:bg-slate-50">
                    <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @if($jml > 0)
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                    @endif
                </button>

                <div x-show="open" @click.away="open = false" style="display: none;" 
                     class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 overflow-hidden transform origin-top-right transition-all">
                    <div class="p-4 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pendaftar Terbaru</span>
                        <span class="bg-blue-600 text-white text-[9px] px-2 py-0.5 rounded-full font-bold">{{ $jml }}</span>
                    </div>
                    <div class="max-h-64 overflow-y-auto custom-scrollbar">
                        @php $barus = \App\Models\Pendaftar::where('status','Menunggu')->latest()->take(5)->get() @endphp
                        @forelse($barus as $b)
                            <a href="{{ route('admin.verifikasi.index', ['aktif' => $b->id]) }}" class="flex items-center gap-3 p-4 hover:bg-blue-50/50 border-b border-slate-50 transition">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xs uppercase">{{ substr($b->nama,0,2) }}</div>
                                <div>
                                    <p class="text-xs font-black text-slate-800 uppercase leading-none">{{ $b->nama }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase">{{ $b->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-slate-400 text-xs italic font-bold">Semua berkas sudah terverifikasi.</div>
                        @endforelse
                    </div>
                    <a href="{{ route('admin.verifikasi.index') }}" class="block p-3 text-center bg-slate-50 text-[10px] font-black text-blue-600 hover:bg-slate-100 uppercase tracking-widest">Lihat Semua Antrean</a>
                </div>
            </div>

            <div class="flex items-center gap-3 pl-4 border-l border-slate-200 p-2 rounded-xl">
                <div class="text-right hidden md:block">
                    <p class="text-[14px] font-bold text-slate-800 leading-none">{{ auth('admin')->user()->nama }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight mt-1">{{ auth('admin')->user()->role_label }}</p>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->nama) }}&background=eff6ff&color=2563eb&bold=true" class="w-9 h-9 md:w-10 md:h-10 rounded-xl border border-slate-200 shadow-sm">
            </div>
        </div>
    </header>
    
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
</script>
@stack('scripts')
</body>
</html>