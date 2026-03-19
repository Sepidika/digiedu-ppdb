<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1e293b; }
        .card { width: 100%; padding: 24px; border: 2px solid #2563eb; border-radius: 8px; }
        .header { background: #1e3a8a; color: white; padding: 16px; border-radius: 6px 6px 0 0; text-align: center; margin: -24px -24px 20px -24px; }
        .header h1 { font-size: 16px; font-weight: bold; margin-bottom: 4px; }
        .header p { font-size: 10px; opacity: 0.8; }
        .badge { background: #dbeafe; color: #1d4ed8; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: bold; display: inline-block; margin-bottom: 16px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .field label { font-size: 9px; color: #64748b; text-transform: uppercase; font-weight: bold; }
        .field p { font-size: 12px; font-weight: bold; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-top: 2px; }
        .status { text-align: center; padding: 10px; border-radius: 6px; margin-top: 16px; font-weight: bold; font-size: 14px; }
        .status.diterima { background: #dcfce7; color: #166534; }
        .status.menunggu { background: #fef9c3; color: #854d0e; }
        .status.ditolak  { background: #fee2e2; color: #991b1b; }
        .footer { text-align: center; margin-top: 16px; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
<div class="card">
    <div class="header">
        <h1>KARTU PESERTA PPDB</h1>
        <p>{{ $settings['nama_sekolah'] ?? 'SMA DigiEdu' }} — Tahun Ajaran {{ $settings['tahun_ajaran'] ?? '2026/2027' }}</p>
    </div>

    <div style="text-align:center">
        <div class="badge">{{ $pendaftar->no_reg }}</div>
    </div>

    <div class="grid">
        <div class="field">
            <label>Nama Lengkap</label>
            <p>{{ $pendaftar->nama }}</p>
        </div>
        <div class="field">
            <label>NISN</label>
            <p>{{ $pendaftar->nisn }}</p>
        </div>
        <div class="field">
            <label>Tempat, Tanggal Lahir</label>
            <p>{{ $pendaftar->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d M Y') }}</p>
        </div>
        <div class="field">
            <label>Jenis Kelamin</label>
            <p>{{ $pendaftar->jenis_kelamin }}</p>
        </div>
        <div class="field">
            <label>Asal Sekolah</label>
            <p>{{ $pendaftar->asal_sekolah }}</p>
        </div>
        <div class="field">
            <label>Jalur Pendaftaran</label>
            <p>{{ $pendaftar->jalur }}</p>
        </div>
        <div class="field">
            <label>Jurusan Dipilih</label>
            <p>{{ $pendaftar->jurusan }}</p>
        </div>
        <div class="field">
            <label>Nilai Rata-rata</label>
            <p>{{ $pendaftar->nilai_rata }}</p>
        </div>
    </div>

    <div class="status {{ strtolower($pendaftar->status) }}">
        STATUS: {{ strtoupper($pendaftar->status) }}
    </div>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y H:i') }} — {{ $settings['nama_sekolah'] ?? '' }}
    </div>
</div>
</body>
</html>