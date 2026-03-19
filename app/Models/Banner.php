<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['judul', 'file', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];
}