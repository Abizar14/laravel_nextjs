<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JadwalKerjaResource;
use App\Models\JadwalKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalKerjaController extends Controller
{
    public function index() {
        $jadwal = JadwalKerja::all();

        return new JadwalKerjaResource(true, 'Data Jadwal Kerja', $jadwal);
    }

    public function store(Request $request) {
        
        // Membuat Validasi Data Jadwal Kerja
        $validate = Validator::make($request->all(), [
            // 'user_id' => 'required',
            'shift' => 'required',
            'tgl_masuk' => 'required|date_format:Y-m-d',
            'jam_masuk' => 'required|date_format:H:i:s',
            'jam_keluar' => 'required|date_format:H:i:s'
        ]);

        // Mengembalikan response error validasi data jadwal kerja ke client dengan status error jika ada kesalahan
        if($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 402);
        }

        // jika validasi berhasil insert data ke database
        $jadwalkerja = JadwalKerja::create([
            // 'user_id' => $request->user_id,
            'shift' => $request->shift,
            'tgl_masuk' => $request->tgl_masuk,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar
        ]);

        return new JadwalKerjaResource(true, 'Data Jadwal Kerja Berhasil Ditambahkan', $jadwalkerja);

    }
}
