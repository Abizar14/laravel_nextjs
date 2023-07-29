<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\JadwalKerja;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'jadwalkerja_id',
        'nik',
        'first_name',
        'last_name',
        'name',
        'email',
        // 'position',
        'dob',
        'phone_number',
        'image',
        'password',
        'position_id'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function jadwalKerja() {
        return $this->hasMany(JadwalKerja::class);
    }

    public function role() {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function cuti() {
        return $this->hasOne(Cuti::class);
    }
    public function izin() {
        return $this->hasOne(Izin::class);
    }

    public function salary() {
        return $this->hasMany(Salary::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function sisaJatahCuti()
    {
        $totalCuti = $this->absensis()->where('keterangan', 'cuti')->count();
        $jatahCuti = $this->jatah_cuti ?? 0;

        return max(0, $jatahCuti - $totalCuti);
    }

    public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }
    
}
