<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IzinResource;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IzinController extends Controller
{
    public function index() {
        $izin = Izin::all();

        return new IzinResource(true, 'Data Izin Berhasil Ditampilkan', $izin);
    }

    public function store(Request $request) {
        $izin = Izin::whereUserId($request->user_id)->first();

        if($izin) {
            return response()->json([
                "error" => 'User Ini Sudah Melakukan Izin'
            ]);
        }

        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'keterangan' => 'required',
            'reason' => 'required'
        ]);

        if($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 522);
        }

        $data = [
            'user_id' => $request->user_id,
            'keterangan' => $request->keterangan,
            'reason' => $request->reason
        ];

        $izin = Izin::create($data);

        return new IzinResource(true, 'Permohonan Izin Telah Dibuat', $izin);
    }
}
