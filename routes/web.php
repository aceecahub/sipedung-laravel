<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

// controller
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KepalaKeluargaController;
use App\Http\Controllers\WargaController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// login page
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

//RT permission
Route::middleware(['auth', 'verified'])->group(function () {
    // kepala keluarga
    Route::resource('kepala-keluarga', KepalaKeluargaController::class);
    // warga
    Route::resource('warga', WargaController::class);
});

require __DIR__ . '/auth.php';
