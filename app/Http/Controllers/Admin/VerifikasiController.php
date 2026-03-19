<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $antrean = Pendaftar::where('status','Menunggu')->get();
        
        // Cek ID aktif, tapi PASTIKAN statusnya masih 'Menunggu'
        $aktif = null;
        if ($request->filled('aktif')) {
            $aktif = Pendaftar::where('id', $request->aktif)->where('status', 'Menunggu')->first();
        }
        
        // Kalau $aktif kosong (karena barusan disetujui/ditolak), otomatis panggil antrean paling atas
        if (!$aktif) {
            $aktif = $antrean->first();
        }

        return view('admin.verifikasi.index', compact('antrean','aktif'));
    }

    public function setuju(Request $request, $id)
    {
        $p = Pendaftar::findOrFail($id);
        $p->update(['status'=>'Diterima','diverifikasi_oleh'=>Auth::guard('admin')->id(),'diverifikasi_at'=>now()]);
        
        // UBAH: Ganti back() menjadi redirect ke halaman utama verifikasi yang bersih
        return redirect()->route('admin.verifikasi.index')->with('success','Berkas '.$p->nama.' disetujui.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate(['catatan_admin'=>'required|string|min:5']);
        $p = Pendaftar::findOrFail($id);
        $p->update(['status'=>'Ditolak','catatan_admin'=>$request->catatan_admin,'diverifikasi_oleh'=>Auth::guard('admin')->id(),'diverifikasi_at'=>now()]);
        
        // UBAH: Ganti back() menjadi redirect
        return redirect()->route('admin.verifikasi.index')->with('success','Berkas '.$p->nama.' ditolak.');
    }
}