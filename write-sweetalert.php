<?php
/**
 * DigiEdu PPDB - SweetAlert2 Writer
 * Jalankan: php write-sweetalert.php
 */

// Tambah SweetAlert2 CDN + script ke layout admin
$layoutPath = 'resources/views/layouts/admin.blade.php';
$layout = file_get_contents($layoutPath);

// Cek apakah sudah ada SweetAlert2
if (str_contains($layout, 'sweetalert2')) {
    echo "ℹ️  SweetAlert2 sudah ada di layout.\n";
} else {
    // Tambah CDN setelah tag chart.js
    $layout = str_replace(
        '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>',
        '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>' . "\n" .
        '    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>',
        $layout
    );
    echo "✅ SweetAlert2 CDN ditambahkan ke layout.\n";
}

// Tambah script konfirmasi hapus sebelum @stack('scripts')
$sweetalertScript = <<<'JS'

<script>
// SweetAlert2 - Konfirmasi Hapus Global
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[onsubmit]').forEach(function (form) {
        const originalOnsubmit = form.getAttribute('onsubmit');
        if (originalOnsubmit && originalOnsubmit.includes('confirm')) {
            // Ambil pesan dari onsubmit
            const match = originalOnsubmit.match(/confirm\(['"](.+?)['"]\)/);
            const message = match ? match[1] : 'Yakin ingin menghapus data ini?';

            form.removeAttribute('onsubmit');
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    borderRadius: '1rem',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    });
});
</script>
JS;

if (!str_contains($layout, 'SweetAlert2 - Konfirmasi Hapus Global')) {
    $layout = str_replace(
        '@stack(\'scripts\')',
        $sweetalertScript . "\n@stack('scripts')",
        $layout
    );
    echo "✅ Script konfirmasi hapus SweetAlert2 ditambahkan.\n";
} else {
    echo "ℹ️  Script konfirmasi sudah ada.\n";
}

file_put_contents($layoutPath, $layout);

// Tambah juga notifikasi flash SweetAlert2 (success/error/info muncul sebagai toast)
$toastScript = <<<'BLADE'

@if(session('success') || session('error') || session('info'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    });
    @endif
    @if(session('error'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
    });
    @endif
    @if(session('info'))
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: '{{ session('info') }}',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
    });
    @endif
});
</script>
@endif
BLADE;

// Ganti flash message HTML biasa dengan SweetAlert2 toast
// Hapus flash div yang lama, ganti dengan toast script
$layout = file_get_contents($layoutPath);

// Hapus flash div HTML biasa
$layout = preg_replace(
    '/@if\(session\(\'success\'\)\)\s*<div id="flash-success".*?<\/div>\s*@endif/s',
    '',
    $layout
);
$layout = preg_replace(
    '/@if\(session\(\'error\'\)\)\s*<div id="flash-error".*?<\/div>\s*@endif/s',
    '',
    $layout
);
$layout = preg_replace(
    '/@if\(session\(\'info\'\)\)\s*<div id="flash-info".*?<\/div>\s*@endif/s',
    '',
    $layout
);

// Tambah toast sebelum @yield('content')
if (!str_contains($layout, 'Swal.fire({')) {
    $layout = str_replace(
        '<div class="flex-1 overflow-y-auto overflow-x-hidden p-4 md:p-6 lg:p-8 custom-scrollbar">',
        $toastScript . "\n    " . '<div class="flex-1 overflow-y-auto overflow-x-hidden p-4 md:p-6 lg:p-8 custom-scrollbar">',
        $layout
    );
    echo "✅ Flash message diupgrade ke SweetAlert2 Toast.\n";
}

file_put_contents($layoutPath, $layout);

echo "\n========================================\n";
echo "Selesai! Semua SweetAlert2 sudah terpasang:\n";
echo "  • Konfirmasi hapus otomatis di semua form delete\n";
echo "  • Flash message sebagai toast di pojok kanan atas\n";
echo "========================================\n";
echo "Refresh browser dan coba klik tombol Hapus!\n";
