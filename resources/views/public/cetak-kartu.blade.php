<!DOCTYPE html>
<html>
<head>
    <title>Kartu Pendaftaran - {{ $pendaftar->nama }}</title>
    <style>
        @page { margin: 1cm; size: A4 portrait; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; padding: 1cm; }
        
        /* Header */
        .t-header { width: 100%; border-bottom: 3px solid #1d4ed8; padding-bottom: 10px; }
        .logo-box { width: 50px; height: 50px; background-color: #1d4ed8; border-radius: 8px; text-align: center; font-size: 24px; font-weight: 900; color: white; line-height: 50px; display: inline-block; }
        .sekolah-nama { font-size: 16px; font-weight: 900; color: #1d4ed8; }
        .sekolah-sub { font-size: 9px; color: #64748b; }

        /* No Registrasi Box */
        .t-noreg { width: 100%; margin: 20px 0; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; }
        .t-noreg td { padding: 10px 15px; }
        .noreg-label { font-size: 9px; font-weight: bold; color: #3b82f6; text-transform: uppercase; }
        .noreg-value { font-size: 18px; font-weight: 900; color: #1d4ed8; text-align: right; }

        /* Content Table */
        .t-main { width: 100%; border-collapse: collapse; }
        .td-info { width: 65%; vertical-align: top; }
        .td-foto { width: 35%; vertical-align: top; text-align: right; }

        .t-info { width: 100%; }
        .t-info td { padding: 7px 0; border-bottom: 1px solid #f1f5f9; }
        .i-label { width: 40%; font-size: 9px; font-weight: bold; color: #94a3b8; text-transform: uppercase; }
        .i-val { font-weight: 700; color: #0f172a; }

        /* Foto Box */
        .foto-wrapper { width: 120px; height: 160px; border: 2px solid #1d4ed8; border-radius: 6px; overflow: hidden; display: inline-block; background-color: #f8fafc; }
        .foto-wrapper img { width: 100%; height: 100%; object-fit: cover; }

        /* Status Badges */
        .badge { padding: 3px 10px; border-radius: 12px; font-size: 9px; font-weight: 900; }
        .badge-green { background-color: #dcfce7; color: #15803d; }
        .badge-amber { background-color: #fef9c3; color: #854d0e; }

        /* Footer */
        .t-footer { width: 100%; margin-top: 30px; }
        .td-ttd { width: 200px; text-align: right; }
        .ttd-space { height: 60px; }

        .strip-footer { width: 100%; background: #1d4ed8; color: white; text-align: center; padding: 6px; font-size: 8px; margin-top: 30px; border-radius: 4px; }
    </style>
</head>
<body>

<table class="t-header">
    <tr>
        <td style="width: 60px;">
            <div class="logo-box">D</div>
        </td>
        <td>
            <div class="sekolah-nama">{{ strtoupper($settings['nama_sekolah']) }}</div>
            <div class="sekolah-sub">PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB)</div>
            <div class="sekolah-sub">{{ $settings['alamat'] }}</div>
        </td>
        <td style="text-align: right;">
            <div style="background: #1d4ed8; color: white; padding: 4px 10px; border-radius: 4px; font-size: 9px; font-weight: bold; display: inline-block;">
                T.A. {{ $settings['tahun_ajaran'] }}
            </div>
        </td>
    </tr>
</table>

<h2 style="text-align: center; margin-top: 20px; letter-spacing: 2px; text-transform: uppercase; font-size: 14px;">Kartu Bukti Pendaftaran Online</h2>

<table class="t-noreg">
    <tr>
        <td class="noreg-label">No. Registrasi</td>
        <td class="noreg-value">{{ $pendaftar->no_reg }}</td>
    </tr>
</table>

<table class="t-main">
    <tr>
        <td class="td-info">
            <table class="t-info">
                <tr>
                    <td class="i-label">Nama Lengkap</td>
                    <td class="i-val">: {{ strtoupper($pendaftar->nama) }}</td>
                </tr>
                <tr>
                    <td class="i-label">NISN</td>
                    <td class="i-val" style="color: #1d4ed8;">: {{ $pendaftar->nisn }}</td>
                </tr>
                <tr>
                    <td class="i-label">Tempat / Tgl Lahir</td>
                    <td class="i-val">: {{ $pendaftar->tempat_lahir }}, {{ $pendaftar->tanggal_lahir ? date('d M Y', strtotime($pendaftar->tanggal_lahir)) : '-' }}</td>
                </tr>
                <tr>
                    <td class="i-label">Jenis Kelamin</td>
                    <td class="i-val">: {{ $pendaftar->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <td class="i-label">Asal Sekolah</td>
                    <td class="i-val">: {{ $pendaftar->asal_sekolah }}</td>
                </tr>
                <tr>
                    <td class="i-label">Jalur / Jurusan</td>
                    <td class="i-val" style="color: #1d4ed8;">: {{ $pendaftar->jalur }} / {{ $pendaftar->jurusan }}</td>
                </tr>
                <tr>
                    <td class="i-label">Nilai Rata-rata</td>
                    <td class="i-val">: {{ $pendaftar->nilai_rata ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="i-label">Status Seleksi</td>
                    <td class="i-val">: 
                        @if($pendaftar->status == 'Diterima')
                            <span class="badge badge-green">DITERIMA</span>
                        @else
                            <span class="badge badge-amber">MENUNGGU</span>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        <td class="td-foto">
            <div class="foto-wrapper">
                @if($pendaftar->foto_siswa)
                    <img src="{{ public_path('storage/' . $pendaftar->foto_siswa) }}">
                @else
                    <div style="padding-top: 70px; font-size: 10px; color: #94a3b8;">FOTO 3X4</div>
                @endif
            </div>
        </td>
    </tr>
</table>

<table class="t-footer">
    <tr>
        <td style="font-size: 8px; color: #94a3b8; font-style: italic;">
            * Simpan kartu ini sebagai bukti pendaftaran yang sah.<br>
            * Tunjukkan kartu ini beserta dokumen asli saat daftar ulang.<br>
            * Dicetak secara digital pada: {{ now()->format('d/m/Y H:i') }} WIB.
        </td>
        <td class="td-ttd">
            <div style="font-size: 10px;">Banyuwangi, {{ date('d F Y') }}</div>
            <div style="font-weight: bold; margin-top: 5px;">Panitia PPDB,</div>
            <div class="ttd-space"></div>
            <div style="border-top: 1px solid #334155; display: inline-block; width: 150px; padding-top: 5px; font-weight: bold;">
                ( Kepala Panitia )
            </div>
        </td>
    </tr>
</table>

<div class="strip-footer">
    {{ strtoupper($settings['nama_sekolah']) }} | PPDB {{ $settings['tahun_ajaran'] }} | NO-REG: {{ $pendaftar->no_reg }}
</div>

</body>
</html>