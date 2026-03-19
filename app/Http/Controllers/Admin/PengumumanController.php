<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $diterima   = Pendaftar::where('status', 'Diterima')->count();
        $ditolak    = Pendaftar::where('status', 'Ditolak')->count();
        $menunggu   = Pendaftar::where('status', 'Menunggu')->count();
        $pendaftars = Pendaftar::whereIn('status', ['Diterima', 'Ditolak'])->latest()->paginate(20);

        return view('admin.pengumuman.index', compact('diterima', 'ditolak', 'menunggu', 'pendaftars'));
    }

    public function publish()
    {
        // Menyimpan timestamp publikasi ke tabel pengaturan
        Pengaturan::set('pengumuman_published', now()->toDateTimeString());

        return back()->with('success', 'Pengumuman resmi PPDB SMAN 1 Wongsorejo berhasil dipublikasikan!');
    }

    public function kirimNotif(Request $request, $id)
    {
        $p = Pendaftar::findOrFail($id);

        // 1. Bersihkan nomor WA (Hapus karakter non-angka dan ubah 0 jadi 62)
        $nomorRaw = preg_replace('/[^0-9]/', '', $p->no_wa);
        $nomorWa = str_starts_with($nomorRaw, '0') ? '62' . substr($nomorRaw, 1) : $nomorRaw;

        // 2. Siapkan Template Pesan - Pakai NISN & Bold WhatsApp Style
        if ($p->status == 'Diterima') {
            $statusPesan = "*SELAMAT!* Putra/Putri Anda dinyatakan *LULUS* seleksi PPDB SMAN 1 Wongsorejo.";
            $instruksi   = "Silakan lakukan daftar ulang ke sekolah dengan membawa Kartu Peserta.";
        } else {
            $statusPesan = "Mohon maaf, putra/putri Anda dinyatakan *BELUM LULUS* seleksi PPDB tahun ini.";
            $instruksi   = "Tetap semangat dan terima kasih telah mendaftar.";
        }

        $pesan = "Halo Bapak/Ibu Wali dari *{$p->nama}*,\n\n" .
                 "Informasi resmi Panitia PPDB SMAN 1 Wongsorejo:\n" .
                 "{$statusPesan}\n\n" .
                 "Cek status resmi melalui website dengan NISN Anda:\n" .
                 "Link: " . url('/cek-status') . "\n" .
                 "NISN: *{$p->nisn}*\n\n" .
                 "{$instruksi}\n\n" .
                 "Terima kasih.";

        // 3. Redirect langsung ke WhatsApp API
        return redirect("https://wa.me/{$nomorWa}?text=" . urlencode($pesan));
    }
}