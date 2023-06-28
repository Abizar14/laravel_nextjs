<?php

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

Route::apiResource('/users', App\Http\Controllers\Api\UserController::class);

Route::apiResource('/absensi', App\Http\Controllers\Api\AbsensiController::class);

Route::apiResource('/users/{id}/absensi', App\Http\Controllers\Api\UserAbsensiController::class);
Route::apiResource('/users/absensi/cuti', App\Http\Controllers\Api\AbsensiController::class);
Route::apiResource('/users/absensi/sakit', App\Http\Controllers\Api\AbsensiController::class);
