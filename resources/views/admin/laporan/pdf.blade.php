<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan PPDB {{ date('Y') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; }
        .header { background: #1d4ed8; color: white; padding: 16px 20px; margin-bottom: 16px; }
        .header h1 { font-size: 18px; font-weight: bold; }
        .header p { font-size: 11px; opacity: 0.85; margin-top: 2px; }
        .rekap { display: flex; gap: 10px; margin: 0 20px 16px; }
        .rekap-item { flex: 1; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; text-align: center; }
        .rekap-item .num { font-size: 22px; font-weight: bold; color: #1d4ed8; }
        .rekap-item .label { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        table { width: calc(100% - 40px); margin: 0 20px; border-collapse: collapse; }
        thead tr { background: #1d4ed8; color: white; }
        th { padding: 8px 6px; text-align: left; font-size: 10px; font-weight: bold; }
        td { padding: 7px 6px; border-bottom: 1px solid #f1f5f9; font-size: 10px; }
        tr:nth-child(even) { background: #f8fafc; }
        .badge { padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: bold; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .badge-amber { background: #fef3c7; color: #92400e; }
        .footer { margin: 16px 20px 0; padding-top: 10px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Rekap Data PPDB {{ date('Y') }}/{{ date('Y')+1 }}</h1>
        <p>DigiEdu School Banyuwangi &nbsp;|&nbsp; Dicetak: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    @if(isset($rekap))
    <div class="rekap">
        <div class="rekap-item"><div class="num">{{ $rekap['total'] }}</div><div class="label">Total Pendaftar</div></div>
        <div class="rekap-item"><div class="num" style="color:#16a34a">{{ $rekap['diterima'] }}</div><div class="label">Diterima</div></div>
        <div class="rekap-item"><div class="num" style="color:#dc2626">{{ $rekap['ditolak'] }}</div><div class="label">Ditolak</div></div>
        <div class="rekap-item"><div class="num" style="color:#d97706">{{ $rekap['menunggu'] }}</div><div class="label">Menunggu</div></div>
        <div class="rekap-item"><div class="num">{{ $rekap['diterima_mipa'] }}</div><div class="label">Diterima MIPA</div></div>
        <div class="rekap-item"><div class="num" style="color:#7c3aed">{{ $rekap['diterima_ips'] }}</div><div class="label">Diterima IPS</div></div>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width:25px">No</th>
                <th>No Reg</th>
                <th>Nama Lengkap</th>
                <th>JK</th>
                <th>Asal Sekolah</th>
                <th>Jalur</th>
                <th>Jurusan</th>
                <th>Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftars as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->no_reg }}</td>
                <td><strong>{{ $p->nama }}</strong></td>
                <td>{{ $p->jenis_kelamin == 'Laki-Laki' ? 'L' : 'P' }}</td>
                <td>{{ $p->asal_sekolah }}</td>
                <td>{{ $p->jalur }}</td>
                <td>{{ $p->jurusan }}</td>
                <td>{{ $p->nilai_rata ?? '-' }}</td>
                <td>
                    @if($p->status == 'Diterima')
                        <span class="badge badge-green">Diterima</span>
                    @elseif($p->status == 'Ditolak')
                        <span class="badge badge-red">Ditolak</span>
                    @else
                        <span class="badge badge-amber">Menunggu</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <span>DigiEdu School &copy; {{ date('Y') }}</span>
        <span>Total: {{ $pendaftars->count() }} siswa</span>
    </div>
</body>
</html>