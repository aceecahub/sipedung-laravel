<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

// controller
use App\Http\Controllers\WargaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasAgustusController;
use App\Http\Controllers\KepalaKeluargaController;
use App\Http\Controllers\RondaController;
use App\Http\Controllers\DendaRondaController;

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
    // Admin and RT can access master data
    Route::middleware('role:admin,rt')->group(function () {
        // kepala keluarga
        Route::resource('kepala-keluarga', KepalaKeluargaController::class);
        // warga
        Route::resource('warga', WargaController::class);
    });

    // Admin, RT, and KK can access these (KK is restricted by middleware logic inside role:admin,rt,kk)
    Route::middleware('role:admin,rt,kk')->group(function () {
        // Kas Agustus
        Route::resource('kas-agustus', KasAgustusController::class);
        // Ronda
        Route::get('ronda/jadwal', [RondaController::class, 'getJadwal'])->name('ronda.jadwal');
        Route::get('ronda/today', [RondaController::class, 'getTodayAttendance'])->name('ronda.today');
        Route::resource('ronda', RondaController::class);

        // Denda Ronda
        Route::post('denda-ronda/generate', [DendaRondaController::class, 'generateAutoFines'])->name('denda-ronda.generate');
        Route::resource('denda-ronda', DendaRondaController::class);
    });
});

require __DIR__ . '/auth.php';
