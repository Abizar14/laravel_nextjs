<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = 'cutis';

    protected $fillable = [
        'user_id', 'jumlah_cuti' , 'tgl_mulai', 'tgl_selesai', 'reason', 'status'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
