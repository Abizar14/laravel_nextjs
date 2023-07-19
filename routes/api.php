<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\CutiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Users
Route::apiResource('/users', App\Http\Controllers\Api\UserController::class);

// Absensi
Route::post('/absensi/absenmasuk', [AbsensiController::class, 'absenMasuk']);
Route::post('/absensi/absenkeluar', [AbsensiController::class, 'absenKeluar']);
Route::post('/absensi/store', [AbsensiController::class, 'store']);

// Jadwal Kerja
Route::apiResource('/jadwalkerja', App\Http\Controllers\Api\JadwalKerjaController::class);

// Cuti
Route::get('/cuti',[CutiController::class, 'store']);
Route::post('/cuti',[CutiController::class, 'store']);

// Relationship Absensi Dan User
Route::apiResource('/users/absensi/jadwalkerja/cuti/izin/{id}', App\Http\Controllers\Api\UserAbsensiController::class);

