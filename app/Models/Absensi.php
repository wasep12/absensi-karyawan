<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
	use HasFactory;

	protected $table = 'absen';  // Nama tabel yang digunakan
	protected $guarded = ['id', 'created_at', 'updated_at'];  // Kolom yang tidak bisa diisi langsung

	// Relasi ke model Karyawan
	public function Karyawan()
	{
		return $this->belongsTo(Karyawan::class, 'uid', 'uid');  // Jika menggunakan uid sebagai foreign key
		// return $this->belongsTo(Karyawan::class, 'karyawan_id');  // Jika menggunakan karyawan_id
	}
}