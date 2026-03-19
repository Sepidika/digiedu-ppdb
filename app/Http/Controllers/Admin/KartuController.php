<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Pengaturan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KartuController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil list pendaftar dengan fitur pencarian & paginasi
        $pendaftars = Pendaftar::when($request->search, fn($q) =>
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('nisn', 'like', '%' . $request->search . '%')
        )->latest()->paginate(20)->withQueryString();

        // 2. LOGIKA DINAMIS: Ambil data berdasarkan ID di URL, kalau gak ada baru ambil yang pertama
        $preview = $request->id 
            ? Pendaftar::find($request->id) 
            : Pendaftar::first();

        // 3. Jaga-jaga kalau ID yang dicari gak ada atau database kosong
        if (!$preview && $pendaftars->count() > 0) {
            $preview = $pendaftars->first();
        }

        return view('admin.kartu.index', compact('pendaftars', 'preview'));
    }

    public function cetak($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        return view('admin.kartu.preview', compact('pendaftar'));
    }

    public function cetakSemua()
    {
        $pendaftars = Pendaftar::all();
        return view('admin.kartu.semua', compact('pendaftars'));
    }

    public function exportPdf($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $settings  = Pengaturan::all()->pluck('value', 'key');
        
        $pdf = Pdf::loadView('admin.kartu.pdf', compact('pendaftar', 'settings'))
                   ->setPaper('a5', 'portrait');
                   
        return $pdf->download('kartu-' . $pendaftar->no_reg . '.pdf');
    }
}