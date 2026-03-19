<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftar::query();
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama','like','%'.$request->search.'%')
                  ->orWhere('nisn','like','%'.$request->search.'%');
            });
        }
        if ($request->filled('jurusan')) $query->where('jurusan',$request->jurusan);
        if ($request->filled('status'))  $query->where('status',$request->status);
        $pendaftars = $query->latest()->paginate(15)->withQueryString();
        return view('admin.pendaftar.index', compact('pendaftars'));
    }
    public function create() { return view('admin.pendaftar.create'); }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn'          => 'required|unique:pendaftars,nisn',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'nullable|string',
            'asal_sekolah'  => 'required|string',
            'jalur'         => 'required|in:Zonasi,Prestasi Akademik,Afirmasi',
            'jurusan'       => 'required|in:MIPA,IPS',
            'nama_wali'     => 'required|string',
            'no_wa'         => 'required|string',
            'nilai_rata'    => 'nullable|numeric|min:0|max:100',
        ]);
        foreach (['foto_kk','foto_ijazah','foto_rapor','foto_siswa'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('pendaftar','public');
            }
        }
        Pendaftar::create($validated);
        return redirect()->route('admin.pendaftar.index')->with('success','Data pendaftar berhasil ditambahkan.');
    }
    public function edit(Pendaftar $pendaftar) { return view('admin.pendaftar.edit', compact('pendaftar')); }
    public function update(Request $request, Pendaftar $pendaftar)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'nullable|string',
            'asal_sekolah'  => 'required|string',
            'jalur'         => 'required|in:Zonasi,Prestasi Akademik,Afirmasi',
            'jurusan'       => 'required|in:MIPA,IPS',
            'nama_wali'     => 'required|string',
            'no_wa'         => 'required|string',
            'nilai_rata'    => 'nullable|numeric|min:0|max:100',
            'status'        => 'required|in:Menunggu,Diterima,Ditolak',
            'catatan_admin' => 'nullable|string',
        ]);
        $pendaftar->update($validated);
        return redirect()->route('admin.pendaftar.index')->with('success','Biodata berhasil diperbarui.');
    }
    public function destroy(Pendaftar $pendaftar)
    {
        $pendaftar->delete();
        return redirect()->route('admin.pendaftar.index')->with('success','Data berhasil dihapus.');
    }
}
