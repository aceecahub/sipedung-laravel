<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controller
use App\Http\Controllers\KepalaKeluargaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Kepala Keluarga
Route::apiResource('kk', KepalaKeluargaController::class);

