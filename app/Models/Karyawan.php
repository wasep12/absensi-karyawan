<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;  // SoftDeletes untuk menandai karyawan yang dihapus tanpa menghapus data secara fisik

    protected $table = 'karyawan';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relasi dengan Absensi
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'uid', 'uid');  // Relasi ke absensi, sesuaikan jika menggunakan karyawan_id
    }
}