<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salary';

    protected $fillable = [
        'user_id', 'salary', 'tgl_salary', 'periode', 'total', 'status_gaji', 'status', 'jumlah_overtime'
    ];

    public function user() {
        return $this->belongsTo(user::class);
    }
}
