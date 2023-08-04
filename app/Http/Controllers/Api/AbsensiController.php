<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsensiResource;
use App\Models\Absensi;
use App\Models\JadwalKerja;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::all();

        return new AbsensiResource(true, 'Absen Berhasil', $absensi);
    }

    public function update(Request $request, Absensi $absensi , $id) {
        $data = $request->all();
        
        $absensi = $absensi->update($data);
    }

    
    public function absenMasuk(Request $request)
    {
        $timezone = "Asia/Makassar";
        $date = new DateTime('now', new DateTimeZone($timezone));
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');

        $absensi = Absensi::with('jadwalKerja')->whereUserId($request->user_id)->whereTanggal($tanggal)->first();
        $already_absen = $request->already_absen;
        if ($absensi) {
            return response()->json([
                'error' => 'Absen Masuk Sudah Terisi',
                'data' => $already_absen
            ]);
        }

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date_format:Y-m-d',
            // 'terlambat' => 'required',
            'keterangan' => 'required|in:masuk,alpha,telat,cuti,izin,sakit',
            'jam_masuk' => 'required|date_format:H:i:s',
            'image' => 'required',
 
        ]);

        // Validasi pesan ketika data json error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 402);
        }

        
    // Cek batasan absen masuk
    $user_id = $request->user_id;
    $jam_masuk = $localtime;
    $jadwalkerja_id = $request->jadwalkerja_id;


    // Cek jenis shift berdasarkan jadwalkerja_id
    $shift = '';
    if ($jadwalkerja_id == 1) {
        $shift = 'Shift Pagi';
    } elseif ($jadwalkerja_id == 2) {
        $shift = 'Shift Malam';
    }

    // Cek apakah karyawan terlambat
    $terlambat = 'Tidak Terlambat';
    $waktuAbsenPalingLambatPagi = now()->setTime(9, 0, 0); // Batas waktu terlambat shift pagi
    $waktuAbsenPalingLambatMalam = now()->setTime(21, 0, 0); // Batas waktu terlambat shift malam
    if ($jadwalkerja_id == 1 && strtotime($jam_masuk) > $waktuAbsenPalingLambatPagi->timestamp) {
        $terlambat = 'Terlambat Shift Pagi';
    } elseif ($jadwalkerja_id == 2 && strtotime($jam_masuk) > $waktuAbsenPalingLambatMalam->timestamp) {
        $terlambat = 'Terlambat Shift Malam';
    }
        
        $input = $request->all();
        $input['tanggal'] = $tanggal;
        $input['jam_masuk'] = $jam_masuk;
        $input['terlambat'] = $terlambat; // Sama seperti sebelumnya
        
        $absensi = Absensi::create($input);
            $response = [
                    'absensi' => $absensi,
                    'terlambat' => $terlambat,
                    'shift' => $shift
                ];
                return new AbsensiResource(true, 'Absen Berhasil Disimpan', $response);
                
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

    
    
    // Validasi data
    $validator = Validator::make($request->all(), [
        'jam_keluar' => 'required|date_format:H:i:s'
    ]);
    
    // Validasi pesan ketika data json error
    if ($validator->fails()) {
        return response()->json($validator->errors(), 402);
    }
    
    // Cek batasan absen masuk
        $user_id = $request->user_id;
        $jam_keluar = $localtime;
        $jadwalkerja_id = $request->jadwalkerja_id;
    
    
        // Cek jenis shift berdasarkan jadwalkerja_id
        $shift = '';
        if ($jadwalkerja_id == 1) {
            $shift = 'Shift Pagi';
        } elseif ($jadwalkerja_id == 2) {
            $shift = 'Shift Malam';
        }
    
        // Cek apakah karyawan terlambat
        $terlambat = 'Tidak Terlambat';
        $waktuAbsenPulangPalingLambatPagi = now()->setTime(18, 0, 0); // Batas waktu terlambat shift pagi
        $waktuAbsenPulangPalingLambatMalam = now()->setTime(7, 0, 0); // Batas waktu terlambat shift malam
        if ($jadwalkerja_id == 1 && strtotime($absensi->jam_masuk) > $waktuAbsenPulangPalingLambatPagi->timestamp) {
            $terlambat = 'Terlambat Pulang Shift Pagi';
        } elseif ($jadwalkerja_id == 2 && strtotime($absensi->jam_masuk) > $waktuAbsenPulangPalingLambatMalam->timestamp) {
            $terlambat = 'Terlambat Pulang Shift Malam';
        }
        
        
        $dt=[
            'user_id' => $user_id,
            'jam_masuk'=> $absensi->jam_masuk,
            'jam_keluar' => $jam_keluar,
            'jam_kerja' => date('H:i:s', strtotime($localtime) - strtotime($absensi->jam_masuk))
        ];
        
        if ($absensi->jam_keluar == "") {
            $absensi = $absensi->update($dt);
            return response()->json([
                'message' => 'Anda Berhasil Absen Keluar',
                'data' => $dt,
                'shift' => $shift,
                'pesanTerlambat' => $terlambat
            ]);
        } else {
            return response()->json(['message' => 'Sudah Absen Pulang']);
        }
}


                // if($absensi->jadwalkerja_id == 1) {
                    
                // }
        
        
                
                // $terlambat = 'tidak'; // Set default value untuk terlambat
                
                // // Batas waktu terlambat untuk shift pagi adalah pukul 09:00 pagi
                // $batasWaktuShiftPagi = new \DateTime($tanggal . ' 09:00:00');
                // // Batas waktu terlambat untuk shift malam adalah pukul 21:00 (9:00 PM)
                // $batasWaktuShiftMalam = new \DateTime($tanggal . ' 21:00:00');
                // // Ubah format jam masuk menjadi DateTime
                // $jamMasukDateTime = \DateTime::createFromFormat('H:i:s', $jam_masuk);
                // // Cek status terlambat berdasarkan shift
                // if ($jadwalkerja_id === 1 && $jamMasukDateTime > $batasWaktuShiftPagi) {
                //         $terlambat = 'Terlambat Shift Pagi';
                //     } elseif ($jadwalkerja_id === 2 && $jamMasukDateTime > $batasWaktuShiftMalam) {
                //     $terlambat = 'Terlambat Shift Malam';
                // }


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

    public function show($id) {
        $absensi = Absensi::findOrFail($id);

        return new AbsensiResource(true, 'Absensi Berhasil Ditampilkan', $absensi);
    }

}

