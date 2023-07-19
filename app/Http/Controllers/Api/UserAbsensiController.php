<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAbsensiResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserAbsensiController extends Controller
{
    public function index($id) {
        $user = User::with('absensi', 'jadwalKerja', 'cuti', 'izin')->findOrFail($id);

        return new UserAbsensiResource(true, 'Succesfully', $user);
    }
    public function getUserAbsensi(User $user)
    {
        $user->load('absensi', 'jadwalKerja');
        if ($user == null){
            return response()->json([
                'message' => 'data tidak ditemukan'
            ], 402);
        };
            
        return new UserAbsensiResource(true, 'Succesfully', $user);
    }
}
