<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index() { return view('admin.admin-user.index', ['admins' => Admin::latest()->paginate(20)]); }
    public function create() { return view('admin.admin-user.create'); }
    public function store(Request $request)
    {
        $request->validate(['nama'=>'required|string','email'=>'required|email|unique:admins,email','password'=>'required|min:8|confirmed','role'=>'required|in:super_admin,operator_verifikasi,operator_konten,viewer','no_wa'=>'nullable|string']);
        Admin::create(['nama'=>$request->nama,'email'=>$request->email,'password'=>Hash::make($request->password),'role'=>$request->role,'no_wa'=>$request->no_wa,'status'=>'aktif']);
        return redirect()->route('admin.admin-user.index')->with('success','Akun admin baru berhasil dibuat!');
    }
    public function edit(Admin $adminUser) { return view('admin.admin-user.edit', compact('adminUser')); }
    public function update(Request $request, Admin $adminUser)
    {
        $request->validate(['nama'=>'required|string','role'=>'required','status'=>'required|in:aktif,nonaktif']);
        $adminUser->update($request->only('nama','role','status','no_wa'));
        if ($request->filled('password')) {
            $request->validate(['password'=>'min:8|confirmed']);
            $adminUser->update(['password'=>Hash::make($request->password)]);
        }
        return redirect()->route('admin.admin-user.index')->with('success','Data admin diperbarui!');
    }
    public function destroy(Admin $adminUser)
    {
        if ($adminUser->id === Auth::guard('admin')->id()) return back()->with('error','Tidak bisa menghapus akun sendiri!');
        $adminUser->delete();
        return redirect()->route('admin.admin-user.index')->with('success','Akun admin dihapus.');
    }
}
