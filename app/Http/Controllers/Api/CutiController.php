<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CutiResource;
use App\Models\Cuti;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CutiController extends Controller
{
    public function index() {
        $cuti = Cuti::all();

        return new CutiResource(true, 'Data Berhasil Ditampilkan', $cuti);
    }

    public function store(Request $request) {
        $cutiUser = Cuti::whereUserId($request->user_id)->first();

        if($cutiUser) {
            return response()->json([
                'error' => 'User ini telah mengajukan permohonan cuti, jika ingin mengajukan cuti hapus data cuti lama'
            ]);
        }

        $validate = Validator::make($request->all(), [
            'user_id' => 'required|unique:cutis',
            'tgl_mulai' => 'required|date_format:Y-m-d',
            'tgl_selesai' => 'required|date_format:Y-m-d',
            'jumlah_cuti' => 'required',
            'reason' => 'required',
            'status' => 'required'
        ]);

        if($validate->fails()) {
            return response()->json([ $validate->errors() ], 522);
        }

        $estimasi = explode(" ", $request->jumlah_cuti);
        $startDate = DateTime::createFromFormat('Y-m-d', $request->tgl_mulai);
        $endDate = DateTime::createFromFormat('Y-m-d', $request->tgl_selesai);

        $startTimeStamp = $startDate;
        $endTimeStamp = $endDate;
        // $timeDiff = abs($endTimeStamp - $startTimeStamp);
        // $numberDays = $timeDiff / 86400;  // 86400 hitungan per hari
        // $numberDays = intval($numberDays);
        $interval = $startDate->diff($endDate);
        $numberDays = $interval->days;
    

        if ($numberDays > 30) {
            return response()->json(['error' => 'Durasi cuti melebihi batas maksimum 30 hari'], 522);
        }

        // status default cuti
        $status = 'pending'; 

        // ubah status jika admin telah menyetujui atau menolak cuti
        if($status === 'approved' || $status === 'rejected') {
            $status = $request->status;
        };

        $data = [
            'user_id' => $request->user_id,
            'tgl_mulai' => $startTimeStamp,
            'tgl_selesai' => $endTimeStamp,
            'jumlah_cuti' => $numberDays,
            'reason' => $request->reason,
            'status' => $status
        ];

        $cuti = Cuti::create($data);

        return new CutiResource(true, 'Permohonan cuti berhasil dikirim', $cuti);


    }
}