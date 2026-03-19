<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'     => Pendaftar::count(),
            'menunggu'  => Pendaftar::where('status', 'Menunggu')->count(),
            'diterima'  => Pendaftar::where('status', 'Diterima')->count(),
            'sisa_mipa' => 150 - Pendaftar::where('jurusan', 'MIPA')->where('status', 'Diterima')->count(),
        ];

        $pendaftar_terbaru = Pendaftar::latest()->take(5)->get();

        $chart_data = collect(range(6, 0))->map(function ($i) {
            $date = now()->subDays($i);
            return [
                'label' => $date->format('d M'),
                // Perbaikan: Gunakan toDateString agar akurat membandingkan tanggal saja
                'count' => Pendaftar::whereDate('created_at', $date->toDateString())->count()
            ];
        });

        $jalur_data = [
            'Zonasi'            => Pendaftar::where('jalur', 'Zonasi')->count(),
            'Prestasi Akademik' => Pendaftar::where('jalur', 'Prestasi Akademik')->count(),
            'Afirmasi'          => Pendaftar::where('jalur', 'Afirmasi')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'pendaftar_terbaru', 'chart_data', 'jalur_data'));
    }
}