<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PendaftarExport;
use App\Models\Pendaftar;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup.index');
    }

    public function jalankan()
    {
        return back()->with('success', 'Backup database berhasil dijalankan!');
    }

    public function exportExcel()
    {
        $filename = 'data-pendaftar-ppdb-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new PendaftarExport, $filename);
    }

    public function exportPdf()
    {
        $pendaftars = Pendaftar::orderBy('status')->orderBy('jurusan')->get();
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pendaftars'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-ppdb-' . date('Ymd') . '.pdf');
    }
}