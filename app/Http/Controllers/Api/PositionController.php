<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsensiResource;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index() {
        $position = Position::all();

        return new AbsensiResource(true, 'Position Berhasil Ditampilkan', $position);
    }
    
}
