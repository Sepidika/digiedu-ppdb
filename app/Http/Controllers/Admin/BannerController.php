<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index() { return view('admin.banner.index', ['banners' => Banner::orderBy('urutan')->get()]); }
    public function store(Request $request)
    {
        $request->validate(['judul'=>'required|string','file'=>'required|image|max:5120']);
        Banner::create(['judul'=>$request->judul,'file'=>$request->file('file')->store('banner','public'),'urutan'=>Banner::max('urutan')+1,'aktif'=>true]);
        return redirect()->route('admin.banner.index')->with('success','Banner ditambahkan!');
    }
    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->file);
        $banner->delete();
        return redirect()->route('admin.banner.index')->with('success','Banner dihapus.');
    }
}
