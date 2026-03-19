<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\JadwalPpdb;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPpdb::orderBy('tahap')->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }
    public function update(Request $request)
    {
        $request->validate(['jadwal'=>'required|array']);
        foreach ($request->jadwal as $id => $data) {
            JadwalPpdb::where('id',$id)->update([
                'tanggal_mulai'   => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'] ?? $data['tanggal_mulai'],
                'status'          => $data['status'],
            ]);
        }
        return back()->with('success','Jadwal berhasil diperbarui!');
    }
}
