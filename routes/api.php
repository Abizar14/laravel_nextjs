<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CutiController;
use App\Http\Controllers\Api\IzinController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\SalaryController;
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
Route::get('/cuti',[CutiController::class, 'index']);
Route::post('/cuti',[CutiController::class, 'store']);

// Izin
Route::get('izin', [IzinController::class, 'index']);
Route::post('izin', [IzinController::class, 'store']);

// Salary
Route::get('/salary', [SalaryController::class, 'index']);
Route::post('/salary', [SalaryController::class, 'store']);

// Position
Route::get('/position', [PositionController::class, 'index']);
Route::post('/position', [PositionController::class, 'store']);

// Register
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register']);
// Login
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);
// Logout
Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
// Show Login
Route::get('/logined', [AuthController::class, 'logined'])->middleware(['auth:sanctum']);

// Relationship Absensi Dan User
Route::apiResource('/users/absensi/jadwalkerja/cuti/izin/salary/position/{id}', App\Http\Controllers\Api\UserAbsensiController::class);

