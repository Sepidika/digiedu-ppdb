<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'testimonials';
    protected $fillable = ['nama', 'profesi', 'isi', 'foto', 'aktif', 'urutan'];
}