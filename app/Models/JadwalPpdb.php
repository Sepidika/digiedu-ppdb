<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPpdb extends Model
{
    protected $table = 'jadwal_ppdb';

    protected $fillable = [
        'tahap', 'nama_tahap',
        'tanggal_mulai', 'tanggal_selesai', 'status',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];
}