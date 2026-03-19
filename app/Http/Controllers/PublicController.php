<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Banner;
use App\Models\Galeri;
use App\Models\Pendaftar;
use App\Models\Pengaturan;
use App\Models\JadwalPpdb;
use Illuminate\Http\Request;
use App\Models\Testimoni;

class PublicController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        $banners  = Banner::where('aktif', true)->orderBy('urutan')->get();
        $artikels = Artikel::where('status', 'published')->latest('published_at')->take(3)->get();
        $galeris  = Galeri::latest()->take(8)->get();
        $jadwals  = JadwalPpdb::orderBy('tahap')->get();
        $testimonials = Testimoni::where('aktif', true)->orderBy('urutan')->take(3)->get();
        $stats = [
            'total'    => Pendaftar::count(),
            'diterima' => Pendaftar::where('status', 'Diterima')->count(),
            'pendidik' => Pengaturan::get('jumlah_pendidik',  '50'),
            'alumni'   => Pengaturan::get('jumlah_alumni',    '2000'),
            'eskul'    => Pengaturan::get('jumlah_eskul',     '35'),
            'prestasi' => Pengaturan::get('jumlah_prestasi',  '150'),
        ];

        return view('public.index', compact(
            'settings', 'banners', 'artikels', 'galeris', 'jadwals', 'stats', 'testimonials'
        ));
    }

    public function artikelList(Request $request)
    {
        $settings  = $this->getSettings();
        $kategori  = $request->get('kategori');
        $query     = Artikel::where('status', 'published');
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        $artikels  = $query->latest('published_at')->paginate(9);
        $kategoris = ['Pengumuman', 'Esai / Jurnal Siswa', 'Kegiatan Sekolah'];

        return view('public.artikel-list', compact('settings', 'artikels', 'kategoris', 'kategori'));
    }

    public function cekStatus(Request $request)
    {
        $request->validate(['nisn' => 'required|string'], ['nisn.required' => 'NISN wajib diisi.']);
        
        // PROTEKSI: Cek apakah Admin sudah klik tombol PUBLISH
        if (!Pengaturan::get('pengumuman_published')) {
            return back()->with('info', 'Mohon bersabar, hasil seleksi belum resmi diumumkan.');
        }

        $pendaftar = Pendaftar::where('nisn', $request->nisn)->first();
        
        if (!$pendaftar) {
            return back()->with('error', 'Data NISN tidak ditemukan.');
        }

        // Filter: Jangan tampilkan hasil kalau status masih Menunggu
        if ($pendaftar->status == 'Menunggu') {
            return back()->with('info', 'Berkas Anda masih dalam tahap verifikasi panitia.');
        }

        $settings = $this->getSettings();
        return view('public.cek-status', compact('pendaftar', 'settings'));
    }

    public function artikel(Artikel $artikel)
    {
        if ($artikel->status !== 'published') abort(404);
        $lainnya  = Artikel::where('status', 'published')->where('id', '!=', $artikel->id)->latest('published_at')->take(3)->get();
        $settings = $this->getSettings();
        return view('public.artikel', compact('artikel', 'lainnya', 'settings'));
    }

    private function getSettings(): array
    {
        return [
            'nama_sekolah'    => Pengaturan::get('nama_sekolah',    'DigiEdu School Banyuwangi'),
            'email_ppdb'      => Pengaturan::get('email_ppdb',      'info@digiedu.sch.id'),
            'no_wa_admin'     => Pengaturan::get('no_wa_admin',     '81234567890'),
            'alamat'          => Pengaturan::get('alamat',          'Jl. Jenderal Sudirman No. 45, Banyuwangi, Jawa Timur 68411'),
            'kuota_mipa'      => Pengaturan::get('kuota_mipa',      '150'),
            'kuota_ips'       => Pengaturan::get('kuota_ips',       '150'),
            'tahun_ajaran'    => Pengaturan::get('tahun_ajaran',    '2026/2027'),
            'gelombang_aktif' => Pengaturan::get('gelombang_aktif', 'Gelombang 1'),
            'kepsek_nama'     => Pengaturan::get('kepsek_nama',     'Dr. Kepala Sekolah, M.Pd.'),
            'kepsek_sambutan' => Pengaturan::get('kepsek_sambutan', 'Kami merancang kurikulum tidak hanya untuk mencetak siswa cerdas secara akademik, tetapi juga siswa yang peduli terhadap sejarah dan budaya bangsa.'),
            'kepsek_foto'     => Pengaturan::get('kepsek_foto',     ''),
            'maps_embed'      => Pengaturan::get('maps_embed',      'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126362.47461971701!2d114.2885918731307!3d-8.214088904576135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1451910248e35%3A0xc6e462c8282ea8e0!2sBanyuwangi!5e0!3m2!1sen!2sid!4v1700000000000'),
            'instagram_url'   => Pengaturan::get('instagram_url',   '#'),
            'youtube_url'     => Pengaturan::get('youtube_url',     '#'),
            'akreditasi'      => Pengaturan::get('akreditasi',      'A'),
        ];
    }

    public function daftar()
    {
        $settings = $this->getSettings(); 
        return view('public.daftar', compact('settings'));
    }

    public function storeDaftar(Request $request)
    {
        // Validasi NISN Unik agar tidak dobel daftar
        $request->validate([
            'nisn' => 'required|unique:pendaftars,nisn',
            'nama' => 'required',
            'no_wa' => 'required',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar!'
        ]);

        $foto_kk     = $request->file('foto_kk') ? $request->file('foto_kk')->store('berkas', 'public') : null;
        $foto_ijazah = $request->file('foto_ijazah') ? $request->file('foto_ijazah')->store('berkas', 'public') : null;
        $foto_rapor  = $request->file('foto_rapor') ? $request->file('foto_rapor')->store('berkas', 'public') : null;
        $foto_siswa  = $request->file('foto_siswa') ? $request->file('foto_siswa')->store('berkas', 'public') : null;

        $lastPendaftar = Pendaftar::latest('id')->first();
        $nextId = $lastPendaftar ? $lastPendaftar->id + 1 : 1;
        $no_reg = 'PPDB-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        Pendaftar::create([
            'no_reg'        => $no_reg,
            'nama'          => $request->nama,
            'nisn'          => $request->nisn,
            'nik'           => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'asal_sekolah'  => $request->asal_sekolah,
            'jalur'         => $request->jalur,
            'jurusan'       => $request->jurusan,
            'nama_wali'     => $request->nama_wali,
            'no_wa'         => $request->no_wa,
            'nilai_rata'    => $request->nilai_rata,
            'foto_kk'       => $foto_kk,
            'foto_ijazah'   => $foto_ijazah,
            'foto_rapor'    => $foto_rapor,
            'foto_siswa'    => $foto_siswa,
            'status'        => 'Menunggu',
        ]);

        return redirect()->route('public.daftar')->with('sukses', 'Pendaftaran Berhasil! No Reg: ' . $no_reg);
    }

    public function cetakKartu($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        // Security: Hanya yang Lulus yang bisa cetak kartu via publik
        if ($pendaftar->status !== 'Diterima') abort(403);

        $settings  = $this->getSettings();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('public.cetak-kartu', compact('pendaftar', 'settings'));
        return $pdf->download('Kartu_PPDB_' . $pendaftar->nama . '.pdf');
    }
}