<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pendaftar extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'no_reg', 'nisn', 'nik', 'nama', 'jenis_kelamin',
        'tempat_lahir', 'tanggal_lahir', 'alamat', 'asal_sekolah',
        'jalur', 'jurusan', 'nama_wali', 'no_wa',
        'nilai_rata', 'status', 'catatan_admin',
        'foto_kk', 'foto_ijazah', 'foto_rapor', 'foto_siswa',
        'diverifikasi_oleh', 'diverifikasi_at',
    ];

    protected $casts = [
        'tanggal_lahir'   => 'date',
        'diverifikasi_at' => 'datetime',
    ];

    /**
     * Konfigurasi Log Otomatis Spatie
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()                // Rekam semua kolom yang ada di fillable
            ->logOnlyDirty()               // Hanya rekam kolom yang nilainya berubah (efisiensi database)
            ->dontSubmitEmptyLogs()        // Jangan simpan log kalau tidak ada perubahan data
            ->useLogName('Pendaftar')      // Nama kategori log
            ->setDescriptionForEvent(fn(string $eventName) => "Data pendaftar ini telah di-{$eventName}");
    }

    protected static function booted(): void
    {
        static::creating(function ($pendaftar) {
            $count = static::whereYear('created_at', now()->year)->count() + 1;
            $pendaftar->no_reg = 'PPDB-' . now()->year . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }

    public function verifikator()
    {
        return $this->belongsTo(Admin::class, 'diverifikasi_oleh');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'Diterima' => '<span class="px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-[10px] font-extrabold flex items-center w-max gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Diterima</span>',
            'Ditolak'  => '<span class="px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-[10px] font-extrabold flex items-center w-max gap-1"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Ditolak</span>',
            default    => '<span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-extrabold flex items-center w-max gap-1"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>Menunggu</span>',
        };
    }
}