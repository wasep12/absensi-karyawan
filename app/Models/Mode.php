<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    use HasFactory;

    protected $table = 'mode';
    protected $guarded = ['created_at', 'updated_at'];

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['mode', 'waktu_masuk', 'waktu_pulang'];
}