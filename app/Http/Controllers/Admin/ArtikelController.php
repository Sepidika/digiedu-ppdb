<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    public function index() { return view('admin.artikel.index', ['artikels' => Artikel::latest()->paginate(10)]); }
    public function create() { return view('admin.artikel.create'); }
    public function store(Request $request)
    {
        $v = $request->validate([
            'judul'      => 'required|string|max:255',
            'isi'        => 'required|string',
            'kategori'   => 'required|in:Pengumuman,Esai / Jurnal Siswa,Kegiatan Sekolah',
            'penulis'    => 'required|string',
            'status'     => 'required|in:published,draft',
            'foto_cover' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('foto_cover')) $v['foto_cover'] = $request->file('foto_cover')->store('artikel','public');
        $v['dibuat_oleh']  = Auth::guard('admin')->id();
        $v['published_at'] = $v['status'] === 'published' ? now() : null;
        Artikel::create($v);
        return redirect()->route('admin.artikel.index')->with('success','Artikel berhasil dipublikasikan!');
    }
    public function edit(Artikel $artikel) { return view('admin.artikel.edit', compact('artikel')); }
    public function update(Request $request, Artikel $artikel)
    {
        $v = $request->validate([
            'judul'      => 'required|string|max:255',
            'isi'        => 'required|string',
            'kategori'   => 'required',
            'penulis'    => 'required|string',
            'status'     => 'required|in:published,draft',
            'foto_cover' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('foto_cover')) $v['foto_cover'] = $request->file('foto_cover')->store('artikel','public');
        $artikel->update($v);
        return redirect()->route('admin.artikel.index')->with('success','Artikel berhasil diperbarui!');
    }
    public function destroy(Artikel $artikel)
    {
        $artikel->delete();
        return redirect()->route('admin.artikel.index')->with('success','Artikel dihapus.');
    }
}
