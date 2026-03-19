@extends('public.layout')
@section('title', $artikel->judul)
@section('seo_title', $artikel->judul . ' - ' . $settings['nama_sekolah'])
@section('seo_description', Str::limit(strip_tags($artikel->isi), 160))
@section('seo_image', $artikel->foto_cover ? asset('storage/'.$artikel->foto_cover) : asset('logo.png'))

@section('content')
<div class="pt-28 pb-16 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-slate-400 font-semibold mb-6">
            <a href="{{ route('public.index') }}" class="hover:text-blue-600">Beranda</a>
            <span>/</span>
            <span class="text-slate-600">{{ $artikel->judul }}</span>
        </div>

        {{-- Cover --}}
        @if($artikel->foto_cover)
        <div class="h-64 md:h-96 rounded-3xl overflow-hidden mb-8 shadow-xl">
            <img src="{{ asset('storage/'.$artikel->foto_cover) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
        </div>
        @endif

        {{-- Meta --}}
        <div class="flex items-center gap-3 mb-4">
            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">{{ $artikel->kategori }}</span>
            <span class="text-slate-400 text-xs">{{ $artikel->penulis }}</span>
            <span class="text-slate-400 text-xs">•</span>
            <span class="text-slate-400 text-xs">{{ $artikel->published_at?->format('d M Y') }}</span>
        </div>

        {{-- Judul --}}
        <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-8 leading-tight">{{ $artikel->judul }}</h1>

        {{-- Isi --}}
        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-base">
            {!! nl2br(e($artikel->isi)) !!}
        </div>

        {{-- Artikel lainnya --}}
        @if($lainnya->count() > 0)
        <div class="mt-16 pt-8 border-t border-slate-100">
            <h3 class="text-lg font-extrabold text-slate-900 mb-6">Artikel Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($lainnya as $a)
                <a href="{{ route('public.artikel', $a->slug) }}" class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md border border-slate-100 transition block">
                    <div class="h-32 bg-slate-200 rounded-xl mb-3 overflow-hidden">
                        @if($a->foto_cover)
                            <img src="{{ asset('storage/'.$a->foto_cover) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <h4 class="font-bold text-sm text-slate-800 line-clamp-2">{{ $a->judul }}</h4>
                    <p class="text-xs text-slate-400 mt-1">{{ $a->published_at?->format('d M Y') }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection