<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controller
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KasAgustusController;
use App\Http\Controllers\KepalaKeluargaController;
use App\Http\Controllers\PemudaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Kepala Keluarga
Route::apiResource('kk', KepalaKeluargaController::class);

// Warga
Route::apiResource('wg', WargaController::class);

// Kas Agustus
Route::apiResource('kas', KasAgustusController::class);

// Pemuda
Route::apiResource('pmd', PemudaController::class);

