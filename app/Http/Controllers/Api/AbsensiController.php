<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsensiResource;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::latest();

        return new AbsensiResource(true, 'Absen Berhasil', $absensi);
    }

    public function absenMasuk(Request $request) {
        $validator = Validator::make($request->all, [
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'jam_masuk' => 'required|date_format:H:i:s',
            'jam_keluar' => 'required|date_format:H:i:s',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 402);
        }
        // membuat absensi dengan data yang telah dibuat
    }

    

    public function store(Request $request)
    {
        $absensi = Absensi::whereUserId($request->user_id)->whereTanggal(date('Y-m-d'))->first();
        if ($absensi) {
            return redirect()->back()->with('error','Absensi hari ini telah terisi');
        }

        // validasi data
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'keterangan' => 'required|in:masuk,alpha,telat,cuti,izin,sakit',
            'jam_masuk' => 'required|date_format:H:i:s',
            'jam_keluar' => 'required|date_format:H:i:s',
        ]);

        // validasi pesan ketika data json error
        if($validator->fails()) {
            return response()->json($validator->errors(), 402);
        }

        // create data
        $data = [
            "user_id" => $request->user_id,
            "keterangan" => $request->keterangan,
            "tanggal" => $request->tanggal,
            "jam_masuk" => $request->jam_masuk,
            "jam_keluar" => $request->jam_keluar,
        ]; 
        
        if ($request->keterangan == 'Masuk' || $request->keterangan == 'Telat') {
            $jamMasuk = strtotime($data['jam_masuk']);
            $jamPulang = strtotime(config('absensi.jam_pulang'));
            $jamMasukToleransi = strtotime(config('absensi.jam_masuk') .' -1 hours');

            if($jamMasuk >= $jamMasukToleransi && $jamMasuk <= strtotime(config('absensi.jam_masuk'))) {
                $data['keterangan'] = 'Masuk';
            } else if ($jamMasuk > strtotime(config('absensi.jam_masuk')) && $jamMasuk <= $jamPulang) {
                $data['keterangan'] = 'Telat'; 
            } else {
                $data['keterangan'] = 'Alpha';
            }
        }
        $absensi = Absensi::create($data);
        return new AbsensiResource(true, 'Absen', $absensi);

    }

    public function izinCuti(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 402);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan.'], 404);
        }

        $sisaJatahCuti = $user->sisaJatahCuti();

        if ($sisaJatahCuti <= 5) {
            return response()->json(['error' => 'Maaf, Anda telah melebihi jatah cuti.'], 402);
        }

        $absensi = Absensi::create([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'keterangan' => 'cuti',
            'keterangan_detail' => $request->keterangan,
        ]);

        return new AbsensiResource(true, 'CUTI', $absensi);
    }

    public function izinSakit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 402);
        }

        $absensi = Absensi::create([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'keterangan' => 'sakit',
            'keterangan_detail' => $request->keterangan,
        ]);

        return new AbsensiResource(true, 'Sakit', $absensi);
    }

    public function show(Absensi $absensi) {
        return new AbsensiResource(true, 'Absensi Berhasil Ditampilkan', $absensi);
    }

}
