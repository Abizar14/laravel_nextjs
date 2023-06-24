<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $fillable = [
        'user_id',
        'tanggal',
        'keterangan',
        'jam_masuk',
        'jam_keluar'
    ];

    public $timestamps = false;
}
