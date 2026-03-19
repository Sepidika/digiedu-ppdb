<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('seo_title', $settings['nama_sekolah'] . ' - PPDB ' . $settings['tahun_ajaran'])</title>
    <meta name="description" content="@yield('seo_description', 'PPDB ' . $settings['tahun_ajaran'] . ' - ' . $settings['nama_sekolah'] . '. Pendaftaran online, cek status, dan informasi lengkap.')">
    <meta name="keywords" content="@yield('seo_keywords', 'PPDB, ' . $settings['nama_sekolah'] . ', pendaftaran siswa baru, Banyuwangi')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('seo_title', $settings['nama_sekolah'] . ' - PPDB ' . $settings['tahun_ajaran'])">
    <meta property="og:description" content="@yield('seo_description', 'PPDB ' . $settings['tahun_ajaran'] . ' - ' . $settings['nama_sekolah'])">
    <meta property="og:image" content="@yield('seo_image', asset('logo.png'))">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ $settings['nama_sekolah'] }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('seo_title', $settings['nama_sekolah'])">
    <meta name="twitter:description" content="@yield('seo_description', 'PPDB ' . $settings['tahun_ajaran'])">
    <meta name="twitter:image" content="@yield('seo_image', asset('logo.png'))">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; overflow-x: hidden; }
        .float-anim { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .fade-in { animation: fadeIn 0.6s ease-in-out; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body class="relative text-slate-800 w-full overflow-x-hidden">

{{-- Tombol WA Melayang --}}
<div class="fixed bottom-4 right-4 md:bottom-6 md:right-6 z-[100] group flex items-center">
    <div class="absolute right-14 md:right-16 bg-white px-3 py-1 md:px-4 md:py-2 rounded-xl shadow-lg border border-slate-100 text-xs md:text-sm font-bold text-slate-700 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0 whitespace-nowrap pointer-events-none">
        Tanya PPDB? Chat Kami!
        <div class="absolute right-[-5px] top-1/2 -translate-y-1/2 w-2 h-2 bg-white transform rotate-45 border-r border-t border-slate-100"></div>
    </div>
    <a href="https://wa.me/62{{ $settings['no_wa_admin'] }}" target="_blank"
        class="relative bg-[#25D366] text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-[0_10px_20px_rgba(37,211,102,0.3)] hover:scale-110 transition-all duration-300">
        <span class="absolute inset-0 rounded-full bg-[#25D366] animate-ping opacity-50"></span>
        <svg class="w-6 h-6 md:w-7 md:h-7 z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
</div>

{{-- Background Blobs --}}
<div class="absolute top-[-5%] left-[-10%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] rounded-full bg-blue-300 opacity-20 blur-[80px] -z-10 pointer-events-none"></div>
<div class="absolute top-[15%] right-[-10%] w-[250px] md:w-[400px] h-[250px] md:h-[400px] rounded-full bg-cyan-300 opacity-20 blur-[80px] -z-10 pointer-events-none"></div>

{{-- Navbar --}}
<nav class="fixed w-full z-50 bg-white/80 backdrop-blur-lg border-b border-white/20 shadow-sm transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-20 items-center">
            <a href="{{ route('public.index') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">D</div>
                <span class="font-extrabold text-xl md:text-2xl text-slate-800 tracking-tight">DigiEdu<span class="text-blue-600">.</span></span>
            </a>
            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('public.index') }}#profil" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Profil</a>
                <a href="{{ route('public.index') }}#program" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Program</a>
                <a href="{{ route('public.index') }}#jadwal" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Jadwal PPDB</a>
                <a href="{{ route('public.artikel-list') }}" class="text-slate-600 hover:text-blue-600 font-semibold transition text-sm">Berita</a>
                <a href="{{ route('public.index') }}#cek-status" class="bg-slate-900 text-white px-6 py-2.5 rounded-full font-bold hover:bg-blue-600 transition shadow-lg text-sm">Cek Status</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-slate-600 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 absolute w-full shadow-lg left-0 top-16 z-50">
        <div class="px-4 pt-2 pb-6 space-y-1 flex flex-col">
            <a href="{{ route('public.index') }}#profil"     class="mobile-menu-link text-slate-600 font-semibold block px-3 py-3 rounded-lg hover:bg-slate-50 text-sm">Profil</a>
            <a href="{{ route('public.index') }}#program"    class="mobile-menu-link text-slate-600 font-semibold block px-3 py-3 rounded-lg hover:bg-slate-50 text-sm">Program</a>
            <a href="{{ route('public.index') }}#jadwal"     class="mobile-menu-link text-slate-600 font-semibold block px-3 py-3 rounded-lg hover:bg-slate-50 text-sm">Jadwal PPDB</a>
            <a href="{{ route('public.artikel-list') }}"     class="mobile-menu-link text-slate-600 font-semibold block px-3 py-3 rounded-lg hover:bg-slate-50 text-sm">Berita</a>
            <a href="{{ route('public.index') }}#cek-status" class="mobile-menu-link bg-blue-600 text-white font-bold text-center block px-3 py-3 mt-2 rounded-xl shadow-md text-sm">Cek Status Pendaftaran</a>
        </div>
    </div>
</nav>

{{-- Content --}}
@yield('content')

{{-- Footer --}}
<footer class="bg-slate-900 text-slate-300 relative w-full overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-cyan-400 to-blue-600"></div>
    <div class="absolute bottom-0 right-[-10%] w-96 h-96 bg-blue-600 rounded-full opacity-10 blur-[100px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center text-white font-bold text-lg">D</div>
                    <span class="font-extrabold text-xl text-white">DigiEdu<span class="text-blue-400">.</span></span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">{{ $settings['nama_sekolah'] }} — Mencetak generasi kritis, berbudaya, dan siap menghadapi tantangan global.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-5 uppercase text-xs tracking-wider">Navigasi</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('public.index') }}"            class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="{{ route('public.index') }}#profil"     class="hover:text-blue-400 transition">Profil Sekolah</a></li>
                    <li><a href="{{ route('public.index') }}#jadwal"     class="hover:text-blue-400 transition">Jadwal PPDB</a></li>
                    <li><a href="{{ route('public.index') }}#cek-status" class="text-cyan-400 font-semibold hover:text-cyan-300 transition">Cek Status</a></li>
                    <li><a href="{{ route('admin.login') }}"             class="hover:text-blue-400 transition">Portal Admin</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-5 uppercase text-xs tracking-wider">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $settings['alamat'] }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ $settings['email_ppdb'] }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>+62 {{ $settings['no_wa_admin'] }}</span>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-5 uppercase text-xs tracking-wider">Jam Operasional</h4>
                <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700/50">
                    <p class="text-sm text-slate-400 flex justify-between mb-2"><span>Senin - Jumat</span><span class="text-white font-semibold">07.00 - 15.00</span></p>
                    <p class="text-sm text-slate-400 flex justify-between"><span>Sabtu (Eskul)</span><span class="text-white font-semibold">08.00 - 12.00</span></p>
                </div>
                <div class="flex gap-3 mt-5">
                    <a href="{{ $settings['instagram_url'] }}" target="_blank" class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="{{ $settings['youtube_url'] }}" target="_blank" class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-red-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-slate-500">
            <p>© {{ date('Y') }} {{ $settings['nama_sekolah'] }}. Hak cipta dilindungi.</p>
            <a href="{{ route('admin.login') }}" class="hover:text-white transition">Panel Admin →</a>
        </div>
    </div>
</footer>

<script>
    const btn  = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    document.querySelectorAll('.mobile-menu-link').forEach(l => l.addEventListener('click', () => menu.classList.add('hidden')));
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 20) {
            nav.classList.remove('bg-white/80'); nav.classList.add('bg-white/98', 'shadow-md');
        } else {
            nav.classList.add('bg-white/80'); nav.classList.remove('bg-white/98', 'shadow-md');
        }
    });
</script>
@stack('scripts')
</body>
</html>