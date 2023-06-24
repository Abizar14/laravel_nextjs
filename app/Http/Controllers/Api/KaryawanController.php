<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function absensiMasuk(Karyawan $karyawan) {
        $karyawan->absensi()->create([
            'masuk_at' => now()
        ]);
        return response()->json(['message'=>'Berhasil absen masuk'], 201);

    }

    public function absensiKeluar(Karyawan $karyawan) {
        $absensi = $karyawan->absensi()->latest()->first();
        if ($absensi && !$absensi->keluar_at){
            $absensi->update([
                'keluar_at'=>now()
                ]);

                return response()->json(['message' => 'Berhasil Absen Keluar'], 201);
    }

}
}
