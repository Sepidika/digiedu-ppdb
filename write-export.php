<?php
/**
 * DigiEdu PPDB - Export Writer
 * Jalankan: php write-export.php
 */

// ============================================================
// 1. Buat folder App/Exports
// ============================================================
if (!is_dir('app/Exports')) {
    mkdir('app/Exports', 0755, true);
}

// ============================================================
// 2. PendaftarExport.php
// ============================================================
$pendaftarExport = <<<'PHP'
<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendaftarExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    public function collection()
    {
        return Pendaftar::orderBy('created_at', 'desc')->get()->map(function ($p, $i) {
            return [
                'No'            => $i + 1,
                'No Reg'        => $p->no_reg,
                'NISN'          => $p->nisn,
                'Nama'          => $p->nama,
                'JK'            => $p->jenis_kelamin == 'Laki-Laki' ? 'L' : 'P',
                'Tempat Lahir'  => $p->tempat_lahir,
                'Tanggal Lahir' => $p->tanggal_lahir?->format('d/m/Y'),
                'Asal Sekolah'  => $p->asal_sekolah,
                'Jalur'         => $p->jalur,
                'Jurusan'       => $p->jurusan,
                'Nama Wali'     => $p->nama_wali,
                'No WA Wali'    => $p->no_wa,
                'Nilai Rata'    => $p->nilai_rata,
                'Status'        => $p->status,
                'Mendaftar'     => $p->created_at->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No', 'No Reg', 'NISN', 'Nama Lengkap', 'JK',
            'Tempat Lahir', 'Tanggal Lahir', 'Asal Sekolah',
            'Jalur', 'Jurusan', 'Nama Wali', 'No WA Wali',
            'Nilai Rata', 'Status', 'Tanggal Daftar',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,  'B' => 16, 'C' => 14, 'D' => 28,
            'E' => 5,  'F' => 16, 'G' => 14, 'H' => 24,
            'I' => 18, 'J' => 8,  'K' => 24, 'L' => 16,
            'M' => 10, 'N' => 14, 'O' => 14,
        ];
    }

    public function title(): string
    {
        return 'Data Pendaftar PPDB';
    }
}
PHP;

file_put_contents('app/Exports/PendaftarExport.php', $pendaftarExport);
echo "✅ app/Exports/PendaftarExport.php\n";

// ============================================================
// 3. Update BackupController - exportExcel & exportPdf
// ============================================================
$backupController = <<<'PHP'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PendaftarExport;
use App\Models\Pendaftar;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup.index');
    }

    public function jalankan()
    {
        return back()->with('success', 'Backup database berhasil dijalankan!');
    }

    public function exportExcel()
    {
        $filename = 'data-pendaftar-ppdb-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new PendaftarExport, $filename);
    }

    public function exportPdf()
    {
        $pendaftars = Pendaftar::orderBy('status')->orderBy('jurusan')->get();
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pendaftars'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-ppdb-' . date('Ymd') . '.pdf');
    }
}
PHP;

file_put_contents('app/Http/Controllers/Admin/BackupController.php', $backupController);
echo "✅ app/Http/Controllers/Admin/BackupController.php\n";

// ============================================================
// 4. Update LaporanController - tambah exportPdf
// ============================================================
$laporanController = <<<'PHP'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $rekap = [
            'total'         => Pendaftar::count(),
            'diterima'      => Pendaftar::where('status', 'Diterima')->count(),
            'ditolak'       => Pendaftar::where('status', 'Ditolak')->count(),
            'menunggu'      => Pendaftar::where('status', 'Menunggu')->count(),
            'diterima_mipa' => Pendaftar::where('status', 'Diterima')->where('jurusan', 'MIPA')->count(),
            'diterima_ips'  => Pendaftar::where('status', 'Diterima')->where('jurusan', 'IPS')->count(),
        ];

        $chart_harian = collect(range(6, 0))->map(fn($i) => [
            'label' => now()->subDays($i)->format('d M'),
            'count' => Pendaftar::whereDate('created_at', now()->subDays($i))->count(),
        ]);

        $jalur_data = [
            'Zonasi'            => Pendaftar::where('jalur', 'Zonasi')->count(),
            'Prestasi Akademik' => Pendaftar::where('jalur', 'Prestasi Akademik')->count(),
            'Afirmasi'          => Pendaftar::where('jalur', 'Afirmasi')->count(),
        ];

        return view('admin.laporan.index', compact('rekap', 'chart_harian', 'jalur_data'));
    }

    public function exportPdf()
    {
        $pendaftars = Pendaftar::orderBy('status')->orderBy('jurusan')->get();
        $rekap = [
            'total'         => Pendaftar::count(),
            'diterima'      => Pendaftar::where('status', 'Diterima')->count(),
            'ditolak'       => Pendaftar::where('status', 'Ditolak')->count(),
            'menunggu'      => Pendaftar::where('status', 'Menunggu')->count(),
            'diterima_mipa' => Pendaftar::where('status', 'Diterima')->where('jurusan', 'MIPA')->count(),
            'diterima_ips'  => Pendaftar::where('status', 'Diterima')->where('jurusan', 'IPS')->count(),
        ];
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pendaftars', 'rekap'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-ppdb-' . date('Ymd') . '.pdf');
    }
}
PHP;

file_put_contents('app/Http/Controllers/Admin/LaporanController.php', $laporanController);
echo "✅ app/Http/Controllers/Admin/LaporanController.php\n";

// ============================================================
// 5. Buat view PDF untuk laporan
// ============================================================
if (!is_dir('resources/views/admin/laporan')) {
    mkdir('resources/views/admin/laporan', 0755, true);
}

$laporanPdf = <<<'BLADE'
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
BLADE;

file_put_contents('resources/views/admin/laporan/pdf.blade.php', $laporanPdf);
echo "✅ resources/views/admin/laporan/pdf.blade.php\n";

// ============================================================
// 6. Hapus BOM dari controller yang baru ditulis
// ============================================================
$files = [
    'app/Exports/PendaftarExport.php',
    'app/Http/Controllers/Admin/BackupController.php',
    'app/Http/Controllers/Admin/LaporanController.php',
];

foreach ($files as $f) {
    $content = file_get_contents($f);
    $content = ltrim($content, "\xEF\xBB\xBF");
    file_put_contents($f, $content);
}
echo "✅ BOM dihapus dari semua file\n";

echo "\n========================================\n";
echo "Selesai! Export sudah berfungsi:\n";
echo "  • Export Excel → Download .xlsx lengkap\n";
echo "  • Export PDF   → Download .pdf landscape\n";
echo "========================================\n";
echo "Test: buka Backup & Export, klik tombol Download!\n";
