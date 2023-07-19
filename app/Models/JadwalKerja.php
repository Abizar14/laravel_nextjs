<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Absensi;

class JadwalKerja extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kerjas';

    protected $fillable = [
        'user_id','slug', 'tgl_masuk', 'jam_masuk', 'jam_keluar'    
    ];

    public function absensi() {
        return $this->hasMany(Absensi::class);
    }
}
