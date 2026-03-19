<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
class PengaturanController extends Controller
{
    public function index()
    {
        $settings = [
            'nama_sekolah'    => Pengaturan::get('nama_sekolah', 'DigiEdu School Banyuwangi'),
            'email_ppdb'      => Pengaturan::get('email_ppdb', 'info@digiedu.sch.id'),
            'no_wa_admin'     => Pengaturan::get('no_wa_admin', '81234567890'),
            'alamat'          => Pengaturan::get('alamat', 'Jl. Jenderal Sudirman No. 45'),
            'kuota_mipa'      => Pengaturan::get('kuota_mipa', 150),
            'kuota_ips'       => Pengaturan::get('kuota_ips', 150),
            'tahun_ajaran'    => Pengaturan::get('tahun_ajaran', '2026/2027'),
            'gelombang_aktif' => Pengaturan::get('gelombang_aktif', 'Gelombang 1'),
            // Profil Kepsek
            'kepsek_nama'     => Pengaturan::get('kepsek_nama', ''),
            'kepsek_sambutan' => Pengaturan::get('kepsek_sambutan', ''),
            'kepsek_foto'     => Pengaturan::get('kepsek_foto', ''),
            // Maps
            'maps_embed'      => Pengaturan::get('maps_embed', ''),
            // Statistik
            'jumlah_pendidik' => Pengaturan::get('jumlah_pendidik', 0),
            'jumlah_alumni'   => Pengaturan::get('jumlah_alumni', 0),
            'jumlah_eskul'    => Pengaturan::get('jumlah_eskul', 0),
            'jumlah_prestasi' => Pengaturan::get('jumlah_prestasi', 0),
        ];
        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah'    => 'required|string',
            'email_ppdb'      => 'required|email',
            'kuota_mipa'      => 'required|integer|min:1',
            'kuota_ips'       => 'required|integer|min:1',
            'jumlah_pendidik' => 'nullable|integer|min:0',
            'jumlah_alumni'   => 'nullable|integer|min:0',
            'jumlah_eskul'    => 'nullable|integer|min:0',
            'jumlah_prestasi' => 'nullable|integer|min:0',
            'kepsek_foto'     => 'nullable|image|max:2048',
        ]);

        // Handle upload foto kepsek
        if ($request->hasFile('kepsek_foto')) {
            $path = $request->file('kepsek_foto')->store('kepsek', 'public');
            Pengaturan::set('kepsek_foto', $path);
        }

        $keys = [
            'nama_sekolah','email_ppdb','no_wa_admin','alamat',
            'kuota_mipa','kuota_ips','tahun_ajaran','gelombang_aktif',
            'kepsek_nama','kepsek_sambutan','maps_embed',
            'jumlah_pendidik','jumlah_alumni','jumlah_eskul','jumlah_prestasi',
        ];
        foreach ($keys as $key) {
            if ($request->has($key)) Pengaturan::set($key, $request->$key);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}