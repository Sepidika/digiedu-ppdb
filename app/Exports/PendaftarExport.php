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