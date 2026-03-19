@extends('public.layout')

@section('content')
<div class="pt-32 pb-16 min-h-screen bg-slate-50 flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        
        <div class="bg-slate-900 p-8 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-500 opacity-90"></div>
            <div class="relative z-10">
                <h2 class="text-2xl font-extrabold text-white mb-1">Formulir PPDB Online</h2>
                <p class="text-blue-100 text-sm">Tahun Ajaran 2026/2027 • Lengkapi data dengan benar</p>
            </div>
        </div>

        <div class="p-8 md:p-10">
            <form action="{{ url('/daftar') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf 

                <div class="flex flex-col items-center justify-center mb-8 border-b border-slate-100 pb-8 relative">
                    <div class="absolute inset-0 bg-blue-50 opacity-60 blur-2xl rounded-full pointer-events-none"></div>
                    
                    <label for="foto_siswa_input" class="relative group cursor-pointer flex flex-col items-center z-10">
                        <div id="avatar_placeholder" class="w-28 h-28 md:w-32 md:h-32 rounded-full bg-blue-100 border-4 border-white shadow-xl flex items-center justify-center text-blue-600 font-extrabold text-5xl group-hover:bg-blue-200 transition">
                            S
                        </div>
                        <img id="avatar_preview" src="#" alt="Preview Foto Siswa" class="hidden w-28 h-28 md:w-32 md:h-32 rounded-full object-cover border-4 border-white shadow-xl">

                        <div class="absolute bottom-0 right-0 bg-blue-600 text-white p-2.5 rounded-full shadow-lg group-hover:scale-110 transition border-2 border-white">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                    </label>
                    
                    <p class="text-xs font-bold text-blue-700 mt-4 uppercase tracking-wider">Pas Foto Siswa (3x4)</p>
                    <p class="text-[10px] text-slate-500 mt-1 max-w-xs text-center">*Format JPG/PNG Maks. 2MB.</p>
                    
                    <input type="file" id="foto_siswa_input" name="foto_siswa" accept="image/*" required class="hidden">
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">A. Biodata Pendaftar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap (Sesuai Ijazah)</label>
                            <input type="text" name="nama" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">NISN Siswa</label>
                            <input type="number" name="nisn" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">NIK Kependudukan</label>
                            <input type="number" name="nik" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">No. WhatsApp Aktif</label>
                            <input type="number" name="no_wa" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Alamat Lengkap Tempat Tinggal</label>
                            <textarea name="alamat" rows="2" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Orang Tua / Wali</label>
                            <input type="text" name="nama_wali" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">B. Data Akademik</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Asal Sekolah Dasar (SMP/MTs)</label>
                            <input type="text" name="asal_sekolah" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jalur Pendaftaran</label>
                            <select name="jalur" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                                <option value="Zonasi">Zonasi</option>
                                <option value="Prestasi Akademik">Prestasi Akademik</option>
                                <option value="Afirmasi">Afirmasi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Pilihan Jurusan</label>
                            <select name="jurusan" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-bold text-blue-700 focus:ring-2 focus:ring-blue-500 outline-none bg-blue-50 focus:bg-white">
                                <option value="MIPA">MIPA</option>
                                <option value="IPS">IPS</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nilai Rata-Rata Rapor (Semester 1-5)</label>
                            <input type="number" step="0.01" name="nilai_rata" required placeholder="Contoh: 85.50" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none bg-slate-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">C. Upload Berkas Pendukung</h3>
                    <p class="text-xs text-slate-500 mb-4">*Format file harus berupa gambar (JPG/PNG/JPEG) maksimal ukuran 2MB.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="border border-dashed border-slate-300 p-4 rounded-xl bg-slate-50">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Scan Kartu Keluarga</label>
                            <input type="file" name="foto_kk" accept="image/*" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                        <div class="border border-dashed border-slate-300 p-4 rounded-xl bg-slate-50">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Scan Ijazah / SKL</label>
                            <input type="file" name="foto_ijazah" accept="image/*" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                        <div class="border border-dashed border-slate-300 p-4 rounded-xl bg-slate-50">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Scan Nilai Rapor</label>
                            <input type="file" name="foto_rapor" accept="image/*" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="pt-6 mt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-10 py-3.5 rounded-xl font-extrabold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                        Kirim Formulir Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const inputFotoSiswa = document.getElementById('foto_siswa_input');
    const placeholder = document.getElementById('avatar_placeholder');
    const preview = document.getElementById('avatar_preview');

    inputFotoSiswa.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                placeholder.classList.add('hidden');
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            placeholder.classList.remove('hidden');
            preview.classList.add('hidden');
        }
    });
</script>

@if(session('sukses'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: 'Sukses!',
        text: '{{ session('sukses') }}',
        icon: 'success',
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'Kembali ke Beranda'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url('/') }}";
        }
    });
</script>
@endif
@endsection