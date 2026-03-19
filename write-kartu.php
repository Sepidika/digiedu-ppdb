<?php
/**
 * DigiEdu PPDB - Fix Kartu PDF
 * Jalankan: php write-kartu.php
 */

$kartu = <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <title>Kartu Pendaftaran - {{ $pendaftar->nama }}</title>
    <style>
        @page { margin: 1.2cm; size: A4 portrait; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; }
        table { border-collapse: collapse; }

        .t-header { width: 100%; }
        .t-header td { padding-bottom: 10px; border-bottom: 3px solid #1d4ed8; }
        .logo-box { width: 52px; height: 52px; background-color: #1d4ed8; border-radius: 10px; text-align: center; font-size: 28px; font-weight: 900; color: white; line-height: 52px; }
        .sekolah-nama { font-size: 15px; font-weight: 900; color: #1d4ed8; }
        .sekolah-sub  { font-size: 9px; color: #64748b; margin-top: 2px; }
        .badge-ta { background-color: #1d4ed8; color: white; font-size: 9px; font-weight: bold; padding: 4px 12px; border-radius: 20px; }

        .t-noreg { width: 100%; margin-top: 14px; margin-bottom: 14px; background-color: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 8px; }
        .t-noreg td { padding: 9px 12px; }
        .noreg-label { font-size: 9px; font-weight: 700; color: #3b82f6; text-transform: uppercase; letter-spacing: 1px; }
        .noreg-value { font-size: 17px; font-weight: 900; color: #1d4ed8; letter-spacing: 2px; text-align: right; }

        .t-main { width: 100%; }
        .td-info { width: 63%; vertical-align: top; padding-right: 14px; }
        .td-foto { width: 37%; vertical-align: top; text-align: right; }

        .t-info { width: 100%; }
        .t-info tr { border-bottom: 1px solid #f1f5f9; }
        .t-info tr:last-child { border-bottom: none; }
        .t-info td { padding: 8px 3px; }
        .i-label { width: 42%; font-size: 9px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }
        .i-sep   { width: 4%; color: #cbd5e1; font-weight: bold; }
        .i-val   { font-weight: 700; color: #0f172a; font-size: 11px; }
        .i-blue  { font-weight: 700; color: #1d4ed8; font-size: 11px; }

        .badge-green { background-color: #dcfce7; color: #15803d; border: 1px solid #86efac; padding: 3px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; }
        .badge-amber { background-color: #fef9c3; color: #854d0e; border: 1px solid #fde047; padding: 3px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; }
        .badge-red   { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; padding: 3px 10px; border-radius: 20px; font-size: 9px; font-weight: 900; }

        .foto-wrapper { width: 120px; height: 160px; border: 2px solid #1d4ed8; border-radius: 8px; overflow: hidden; background-color: #f1f5f9; }
        .foto-wrapper img { width: 120px; height: 160px; object-fit: cover; display: block; }
        .foto-kosong { width: 120px; height: 160px; text-align: center; font-size: 9px; color: #94a3b8; font-weight: bold; padding-top: 65px; }

        .t-footer { width: 100%; margin-top: 14px; }
        .td-catatan { vertical-align: top; font-size: 8px; color: #94a3b8; font-style: italic; line-height: 1.8; }
        .td-ttd { width: 210px; vertical-align: top; text-align: right; }
        .ttd-kota    { font-size: 10px; color: #334155; }
        .ttd-jabatan { font-size: 10px; font-weight: 700; color: #0f172a; }
        .ttd-space   { height: 46px; }
        .ttd-garis   { border-top: 1px solid #334155; padding-top: 3px; font-size: 9px; color: #64748b; font-style: italic; }

        .t-strip { width: 100%; margin-top: 16px; background-color: #1d4ed8; border-radius: 6px; }
        .t-strip td { padding: 7px 14px; text-align: center; font-size: 8px; font-weight: bold; color: white; letter-spacing: 0.5px; }
    </style>
</head>
<body>

<table class="t-header">
    <tr>
        <td style="width:60px; vertical-align:middle; padding-right:12px;">
            <div class="logo-box">D</div>
        </td>
        <td style="vertical-align:middle;">
            <div class="sekolah-nama">{{ strtoupper($settings['nama_sekolah']) }}</div>
            <div class="sekolah-sub">PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB)</div>
            <div class="sekolah-sub">{{ $settings['alamat'] }}</div>
        </td>
        <td style="width:130px; vertical-align:middle; text-align:right;">
            <span class="badge-ta">T.A. {{ $settings['tahun_ajaran'] }}</span>
        </td>
    </tr>
</table>

<table style="width:100%; margin-top:14px; margin-bottom:2px;">
    <tr><td style="text-align:center; font-size:12px; font-weight:900; letter-spacing:2.5px; text-transform:uppercase; color:#0f172a;">Kartu Bukti Pendaftaran Online</td></tr>
    <tr><td style="text-align:center; padding-top:5px;">
        <table style="margin:0 auto;"><tr><td style="width:60px; height:3px; background-color:#1d4ed8; font-size:1px;">&nbsp;</td></tr></table>
    </td></tr>
</table>

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
                    <td class="i-sep">:</td>
                    <td class="i-val">{{ strtoupper($pendaftar->nama) }}</td>
                </tr>
                <tr>
                    <td class="i-label">NISN</td>
                    <td class="i-sep">:</td>
                    <td class="i-blue">{{ $pendaftar->nisn }}</td>
                </tr>
                <tr>
                    <td class="i-label">Tempat / Tgl Lahir</td>
                    <td class="i-sep">:</td>
                    <td class="i-val">{{ $pendaftar->tempat_lahir }}, {{ $pendaftar->tanggal_lahir?->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td class="i-label">Jenis Kelamin</td>
                    <td class="i-sep">:</td>
                    <td class="i-val">{{ $pendaftar->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <td class="i-label">Asal Sekolah</td>
                    <td class="i-sep">:</td>
                    <td class="i-val">{{ $pendaftar->asal_sekolah }}</td>
                </tr>
                <tr>
                    <td class="i-label">Jalur / Jurusan</td>
                    <td class="i-sep">:</td>
                    <td class="i-blue">{{ $pendaftar->jalur }} / {{ $pendaftar->jurusan }}</td>
                </tr>
                <tr>
                    <td class="i-label">Nilai Rata-rata</td>
                    <td class="i-sep">:</td>
                    <td class="i-val">{{ $pendaftar->nilai_rata ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="i-label">Nama Orang Tua</td>
                    <td class="i-sep">:</td>
                    <td class="i-val">{{ $pendaftar->nama_wali }}</td>
                </tr>
                <tr>
                    <td class="i-label">Status Seleksi</td>
                    <td class="i-sep">:</td>
                    <td class="i-val">
                        @if($pendaftar->status == 'Diterima')
                            <span class="badge-green">DITERIMA</span>
                        @elseif($pendaftar->status == 'Ditolak')
                            <span class="badge-red">DITOLAK</span>
                        @else
                            <span class="badge-amber">MENUNGGU</span>
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
                    <div class="foto-kosong">Foto<br>3 x 4</div>
                @endif
            </div>
        </td>
    </tr>
</table>

<table style="width:100%; margin-top:14px; margin-bottom:14px;">
    <tr><td style="border-top:1px dashed #e2e8f0; font-size:1px;">&nbsp;</td></tr>
</table>

<table class="t-footer">
    <tr>
        <td class="td-catatan">
            * Simpan kartu ini sebagai bukti pendaftaran yang sah.<br>
            * Tunjukkan kartu ini beserta dokumen asli saat daftar ulang di sekolah.<br>
            * Kartu dicetak secara digital melalui sistem PPDB Online.
        </td>
        <td class="td-ttd">
            <div class="ttd-kota">Banyuwangi, {{ date('d F Y') }}</div>
            <div class="ttd-jabatan">Panitia PPDB,</div>
            <div class="ttd-space"></div>
            <div class="ttd-garis">( Kepala Panitia PPDB )</div>
        </td>
    </tr>
</table>

<table class="t-strip">
    <tr>
        <td>{{ strtoupper($settings['nama_sekolah']) }} &nbsp;|&nbsp; PPDB {{ $settings['tahun_ajaran'] }} &nbsp;|&nbsp; Dicetak: {{ now()->format('d/m/Y H:i') }} WIB</td>
    </tr>
</table>

</body>
</html>
HTML;

file_put_contents('resources/views/public/cetak-kartu.blade.php', $kartu);
echo "✅ resources/views/public/cetak-kartu.blade.php berhasil diupdate!\n";

// Pastikan controller juga pakai view yang benar
$controller = file_get_contents('app/Http/Controllers/PublicController.php');
if (str_contains($controller, "'public.kartu'")) {
    $controller = str_replace("'public.kartu'", "'public.cetak-kartu'", $controller);
    file_put_contents('app/Http/Controllers/PublicController.php', $controller);
    echo "✅ PublicController diupdate — view: public.cetak-kartu\n";
} else {
    echo "ℹ️  Controller sudah pakai view yang benar.\n";
}

echo "\nJalankan: php artisan view:clear\nLalu test cetak kartu lagi!\n";