<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $fillable = ['judul', 'file', 'tipe', 'kategori', 'diupload_oleh'];

    public function uploader()
    {
        return $this->belongsTo(Admin::class, 'diupload_oleh');
    }
}