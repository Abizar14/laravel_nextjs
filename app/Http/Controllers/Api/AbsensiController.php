<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsensiResource;
use App\Models\Absensi;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::latest();

        return new AbsensiResource(true, 'Absen Berhasil', $absensi);
    }

    



    // public function store(Request $request)
    // {
    //     $absensi = Absensi::whereUserId($request->user_id)->whereTanggal(date('Y-m-d'))->first();
    //     if ($absensi) {
    //         return redirect()->back()->with('error','Absensi hari ini telah terisi');
    //     }

    //     // Validasi data
    //     $validator = Validator::make($request->all(), [
    //         'tanggal' => 'required|date',
    //         'keterangan' => 'required|in:masuk,alpha,telat,cuti,izin,sakit',
    //         'jam_masuk' => 'required|date_format:H:i:s',
    //         'jam_keluar' => 'required|date_format:H:i:s',
    //         'image' => 'required',
    //         'coordinates' => 'required'
    //     ]);

    //     // Validasi pesan ketika data json error
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 402);
    //     }

    //     // Buat data absensi
    //     $data = [
    //         "user_id" => $request->user_id,
    //         "keterangan" => $request->keterangan,
    //         "tanggal" => $request->tanggal,
    //         "jam_masuk" => $request->jam_masuk,
    //         "jam_keluar" => $request->jam_keluar,
    //         "image" => $request->image,
    //         "coordinates" => $request->coordinates
    //     ];

    //     $jamMasuk = strtotime($data['jam_masuk']);
    //     $jamKeluar = strtotime($data['jam_keluar']);
    //     $jamPulang = strtotime(config('absensi.jam_pulang'));

    //     if ($request->keterangan == 'Masuk' || $request->keterangan == 'Telat') {
    //         $data['keterangan'] = $this->absensiMasuk($jamMasuk);
    //     } else {
    //         $data['keterangan'] = $this->absensiKeluar($jamMasuk, $jamKeluar, $jamPulang);
    //     }

    //     $absensi = Absensi::create($data);
    //     return new AbsensiResource(true, 'Absen', $absensi);
    // }

    
    public function absenMasuk(Request $request)
    {
        $timezone = "Asia/Makassar";
        $date = new DateTime('now', new DateTimeZone($timezone));
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        
        $absensi = Absensi::whereUserId($request->user_id)->whereTanggal($tanggal)->first();
        if ($absensi) {
            return response()->json(['error' => 'Absen Masuk Sudah Terisi']);
        }

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date_format:Y-m-d',
            'keterangan' => 'required|in:masuk,alpha,telat,cuti,izin,sakit',
            'jam_masuk' => 'required|date_format:H:i:s',
            'image' => 'required',
            'coordinates' => 'required|array',
            'coordinates.lat' => 'required|numeric',
            'coordinates.lng' => 'required|numeric',
 
        ]);

        // Validasi pesan ketika data json error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 402);
        }

        $latitude = $request->coordinates['lat'];
        $longitude = $request->coordinates['lng'];

        // cek batasan absen masuk
        $jamMasuk = $request->jam_masuk;

        // Batas absen masuk untuk shift pagi
        $batasAbsenShiftPagi = DateTime::createFromFormat('H:i:s', '07:00:00');
        $batasAbsenShiftPagi->modify('+2 hours');
        $batasAbsenShiftMalam = DateTime::createFromFormat('H:i:s', '18:00:00');
        $batasAbsenShiftMalam->modify('+2 hours');

        // Cek jenis shift berdasarkan jam masuk
        $shift = '';
        if($jamMasuk >= '07:00:00' && $jamMasuk <= '15:00:00') {
            $shift = 'pagi';
        } elseif($jamMasuk >= '18:00:00' && $jamMasuk <= '05:00:00') {
            $shift = 'malam';
        }

        // Validasi Absen Masuk Terlambat
        $isTerlambat = false;
        if(($shift === 'pagi' && $date > $batasAbsenShiftPagi) || ($shift === 'malam' && $date > $batasAbsenShiftMalam)) {
            $isTerlambat = true;
        }

        // Buat data absensi
        $data = [
            "user_id" => $request->user_id,
            "jadwalkerja_id" => $request->jadwalkerja_id,
            "keterangan" => $request->keterangan,
            "tanggal" => $tanggal,
            "jam_masuk" => $localtime,
            "image" => $request->image,
            "coordinates" => ['lat' => $latitude, 'lng' => $longitude]
        ];

        $absensi = Absensi::create($data);

        // Menambahkan pesan terlambat absen ke dalam respons JSON
    $response = [
    'absensi' => $absensi,
    'terlambat' => $isTerlambat ? 'Anda Terlambat Absen Masuk' : 'Absen masuk berhasil'
    ];
        return new AbsensiResource(true, 'Absen', $response);
    }

    public function absenKeluar(Request $request)
{
    $timezone = "Asia/Makassar";
    $date = new DateTime('now', new DateTimeZone($timezone));
    $tanggal = $date->format('Y-m-d');
    $localtime = $date->format('H:i:s');

    $absensi = Absensi::whereUserId($request->user_id)->whereTanggal($tanggal)->first();
    if (!$absensi) {
        return response()->json(['error' => 'Anda belum melakukan absensi masuk hari ini']);
    }

    $dt=[
        'jam_keluar' => $localtime,
        'jam_kerja' => date('H:i:s', strtotime($localtime) - strtotime($absensi->jam_masuk))
    ];

    
    // Validasi data
    $validator = Validator::make($request->all(), [
        'jam_keluar' => 'required|date_format:H:i:s'
    ]);
    
    // Validasi pesan ketika data json error
    if ($validator->fails()) {
        return response()->json($validator->errors(), 402);
    }

    // cek batasan jam keluar
    $jamKeluar = $request->jam_keluar;

    // Batas absen keluar untuk shift pagi (15.00 - 17 .00)
    $batasAbsenKeluarShiftPagi = DateTime::createFromFormat('H:i:s', '17:00:00');
    $batasAbsenKeluarShiftPagi->modify('-2 hours');

    $batasAbsenKeluarShiftMalam = DateTime::createFromFormat('H:i:s', '07:00:00');
    $batasAbsenKeluarShiftMalam->modify('-2 hours');

    // cek jenis shift berdasarkan jam masuk
    $shift = '';
    $jamMasuk = $absensi->jam_masuk;
    if ($jamMasuk >= '07:00:00' && $jamMasuk <= '15:00:00') {
        $shift = 'pagi';
    } elseif ($jamMasuk >= '18:00:00' || $jamMasuk <= '05:00:00') {
        $shift = 'malam';
    }

    // Validasi absen keluar terlambat
    $isTerlambat = false;
    if (($shift === 'pagi' && $jamKeluar > $batasAbsenKeluarShiftPagi) || ($shift === 'malam' && $jamKeluar > $batasAbsenKeluarShiftMalam)) {
        $isTerlambat = true;
    }

    if ($absensi->jam_keluar == "") {
        $absensi->update($dt);
        $pesan = $isTerlambat ? 'Anda terlambat absen keluar' : 'Absen keluar berhasil';
        return response()->json(['message' => $pesan]);
    } else {
        return response()->json(['message' => 'Already exists']);
    }
    


    return new AbsensiResource(true, 'Absen Keluar Berhasil', $absensi);
}



    // public function izinCuti(Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required|exists:users,id',
    //         'tanggal' => 'required|date',
    //         'keterangan' => 'required|string'
    //     ]);

    //     if($validator->fails()) {
    //         return response()->json($validator->errors(), 402);
    //     }

    //     $user = User::find($request->user_id);

    //     if (!$user) {
    //         return response()->json(['error' => 'User tidak ditemukan.'], 404);
    //     }

    //     $sisaJatahCuti = $user->sisaJatahCuti();

    //     if ($sisaJatahCuti <= 5) {
    //         return response()->json(['error' => 'Maaf, Anda telah melebihi jatah cuti.'], 402);
    //     }

    //     $absensi = Absensi::create([
    //         'user_id' => $request->user_id,
    //         'tanggal' => $request->tanggal,
    //         'keterangan' => 'cuti',
    //         'keterangan_detail' => $request->keterangan,
    //     ]);

    //     return new AbsensiResource(true, 'CUTI', $absensi);
    // }

    // public function izinSakit(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required|exists:users,id',
    //         'tanggal' => 'required|date',
    //         'keterangan' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 402);
    //     }

    //     $absensi = Absensi::create([
    //         'user_id' => $request->user_id,
    //         'tanggal' => $request->tanggal,
    //         'keterangan' => 'sakit',
    //         'keterangan_detail' => $request->keterangan,
    //     ]);

    //     return new AbsensiResource(true, 'Sakit', $absensi);
    // }

    public function show(Absensi $absensi) {
        return new AbsensiResource(true, 'Absensi Berhasil Ditampilkan', $absensi);
    }

}
