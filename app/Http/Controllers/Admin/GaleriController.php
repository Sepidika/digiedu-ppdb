<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index() { return view('admin.galeri.index', ['galeris' => Galeri::latest()->get()]); }
    public function store(Request $request)
    {
        $request->validate(['judul'=>'required|string','file'=>'required|file|mimes:jpg,jpeg,png,mp4|max:10240','kategori'=>'required']);
        $file = $request->file('file');
        Galeri::create([
            'judul'         => $request->judul,
            'file'          => $file->store('galeri','public'),
            'tipe'          => str_contains($file->getMimeType(),'video') ? 'video' : 'foto',
            'kategori'      => $request->kategori,
            'diupload_oleh' => Auth::guard('admin')->id(),
        ]);
        return redirect()->route('admin.galeri.index')->with('success','File berhasil diupload!');
    }
    public function destroy(Galeri $galeri)
    {
        Storage::disk('public')->delete($galeri->file);
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success','File dihapus.');
    }
}
