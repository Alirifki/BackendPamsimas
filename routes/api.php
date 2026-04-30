<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\MeterAirController;
use App\Http\Controllers\Api\TagihanController;
use App\Http\Controllers\Api\KasController;

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

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    // 🔹 Pelanggan
    Route::get('pelanggan/{id}/detail', [PelangganController::class, 'detail']);
    Route::apiResource('pelanggan', PelangganController::class);

    // 🔹 Meter
    Route::get('meter/{pelanggan_id}/last', [MeterAirController::class, 'lastMeter']);
    Route::apiResource('meter', MeterAirController::class);

    // 🔹 Tagihan
    Route::post('tagihan/{id}/bayar', [TagihanController::class, 'bayar']);
    Route::apiResource('tagihan', TagihanController::class);

    // 🔹 Kas
    Route::get('kas/saldo', [KasController::class, 'saldo']);
    Route::apiResource('kas', KasController::class);

});