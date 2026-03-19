<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'slug', 'isi', 'foto_cover',
        'kategori', 'penulis', 'status',
        'dibuat_oleh', 'published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    protected static function booted(): void
    {
        static::creating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->judul) . '-' . time();
        });
    }

    public function pembuatAdmin()
    {
        return $this->belongsTo(Admin::class, 'dibuat_oleh');
    }
}