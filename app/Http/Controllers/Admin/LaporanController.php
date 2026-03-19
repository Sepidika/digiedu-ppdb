<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $rekap = [
            'total'         => Pendaftar::count(),
            'diterima'      => Pendaftar::where('status', 'Diterima')->count(),
            'ditolak'       => Pendaftar::where('status', 'Ditolak')->count(),
            'menunggu'      => Pendaftar::where('status', 'Menunggu')->count(),
            'diterima_mipa' => Pendaftar::where('status', 'Diterima')->where('jurusan', 'MIPA')->count(),
            'diterima_ips'  => Pendaftar::where('status', 'Diterima')->where('jurusan', 'IPS')->count(),
        ];

        $chart_harian = collect(range(6, 0))->map(fn($i) => [
            'label' => now()->subDays($i)->format('d M'),
            'count' => Pendaftar::whereDate('created_at', now()->subDays($i))->count(),
        ]);

        $jalur_data = [
            'Zonasi'            => Pendaftar::where('jalur', 'Zonasi')->count(),
            'Prestasi Akademik' => Pendaftar::where('jalur', 'Prestasi Akademik')->count(),
            'Afirmasi'          => Pendaftar::where('jalur', 'Afirmasi')->count(),
        ];

        return view('admin.laporan.index', compact('rekap', 'chart_harian', 'jalur_data'));
    }

    public function exportPdf()
    {
        $pendaftars = Pendaftar::orderBy('status')->orderBy('jurusan')->get();
        $rekap = [
            'total'         => Pendaftar::count(),
            'diterima'      => Pendaftar::where('status', 'Diterima')->count(),
            'ditolak'       => Pendaftar::where('status', 'Ditolak')->count(),
            'menunggu'      => Pendaftar::where('status', 'Menunggu')->count(),
            'diterima_mipa' => Pendaftar::where('status', 'Diterima')->where('jurusan', 'MIPA')->count(),
            'diterima_ips'  => Pendaftar::where('status', 'Diterima')->where('jurusan', 'IPS')->count(),
        ];
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pendaftars', 'rekap'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-ppdb-' . date('Ymd') . '.pdf');
    }
}