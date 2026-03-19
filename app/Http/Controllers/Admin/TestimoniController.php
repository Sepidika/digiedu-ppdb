<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonials = Testimoni::orderBy('urutan')->orderBy('id')->get();
        return view('admin.testimoni.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'profesi' => 'required|string|max:100',
            'isi'     => 'required|string',
            'foto'    => 'nullable|image|max:1024',
        ]);

        $data = $request->only('nama', 'profesi', 'isi', 'urutan');
        $data['aktif'] = $request->boolean('aktif', true);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
        }

        Testimoni::create($data);
        return back()->with('success', 'Testimoni berhasil ditambahkan!');
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'profesi' => 'required|string|max:100',
            'isi'     => 'required|string',
            'foto'    => 'nullable|image|max:1024',
        ]);

        $data = $request->only('nama', 'profesi', 'isi', 'urutan');
        $data['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
        }

        $testimoni->update($data);
        return back()->with('success', 'Testimoni berhasil diperbarui!');
    }

    public function destroy(Testimoni $testimoni)
    {
        $testimoni->delete();
        return back()->with('success', 'Testimoni berhasil dihapus!');
    }
}