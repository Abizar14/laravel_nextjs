<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsensiResource;
use App\Http\Resources\UserResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function index() {
        $position = Position::all();

        return new AbsensiResource(true, 'Position Berhasil Ditampilkan', $position);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|in:Staff, Daily Worker, Magang',
            'salary' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Data yang anda masukkan tidak valid",
                'errors' => $validator->errors()
            ]);
        }

        $data = $request->all();

        Position::create($data);

        return new UserResource(true, 'Data Berhasil Ditampilkan', $data);

    }

    public function show($id) {
        $position = Position::findOrFail($id);
        if(!$position) {
            return response()->json([
                "success" => false,
                "message" => "Data Tidak Ada",
                "data"    => null
                ], 401);
        }

        return new UserResource(true, 'Data Berhasil Ditampilkan', $position);
    }
    
}
