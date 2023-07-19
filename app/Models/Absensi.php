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
        'jadwalkerja_id',
        'tanggal',
        'keterangan',
        'jam_masuk',
        'jam_keluar',
        'jam_kerja',
        'image',
        // 'coordinates'
    ];

    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
