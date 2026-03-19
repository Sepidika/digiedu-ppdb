<?php
/**
 * DigiEdu PPDB - Pagination Writer
 * Jalankan: php write-pagination.php
 */

$tailwind = <<<'BLADE'
@if ($paginator->hasPages())
<nav class="flex items-center justify-between">
    <div class="text-sm font-bold text-slate-500">
        Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
    </div>
    <div class="flex gap-1.5">

        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 font-bold text-sm cursor-not-allowed">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 text-slate-600 hover:bg-slate-50 font-bold text-sm transition">&laquo;</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-400 font-bold text-sm">...</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold text-sm shadow-md">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 font-bold text-sm transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 text-slate-600 hover:bg-slate-50 font-bold text-sm transition">&raquo;</a>
        @else
            <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 font-bold text-sm cursor-not-allowed">&raquo;</span>
        @endif

    </div>
</nav>
@endif
BLADE;

file_put_contents('resources/views/vendor/pagination/tailwind.blade.php', $tailwind);
echo "✅ Pagination Tailwind berhasil diperbarui!\n";

// Set pagination default ke tailwind di AppServiceProvider
$appServiceProvider = file_get_contents('app/Providers/AppServiceProvider.php');

if (!str_contains($appServiceProvider, 'Paginator::useBootstrap')) {
    $appServiceProvider = str_replace(
        'use Illuminate\Support\ServiceProvider;',
        "use Illuminate\Support\ServiceProvider;\nuse Illuminate\Pagination\Paginator;",
        $appServiceProvider
    );
    $appServiceProvider = str_replace(
        'public function boot(): void
    {
        //
    }',
        "public function boot(): void\n    {\n        Paginator::useTailwind();\n    }",
        $appServiceProvider
    );
    file_put_contents('app/Providers/AppServiceProvider.php', $appServiceProvider);
    echo "✅ AppServiceProvider diupdate — pagination default: Tailwind!\n";
} else {
    echo "ℹ️  AppServiceProvider sudah diset sebelumnya.\n";
}

echo "\nSelesai! Refresh browser untuk melihat hasilnya.\n";
