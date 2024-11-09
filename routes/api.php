<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataKandidatController;
use App\Http\Controllers\DataPemilihController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\PemilihanController;
use App\Http\Controllers\PemilihanKandidatController;
use App\Http\Controllers\PosisiKandidatController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VotingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('data-pemilih', DataPemilihController::class);
        Route::apiResource('data-kandidat', DataKandidatController::class);
        Route::apiResource('posisi-kandidat', PosisiKandidatController::class);
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/users', [AuthController::class, 'index']);       // Read User
        Route::get('/users/{id}', [AuthController::class, 'show']);       // Read User
        Route::put('/users/{id}', [AuthController::class, 'update']);     // Update User
        Route::delete('/users/{id}', [AuthController::class, 'destroy']); // Delete User
    });


    Route::middleware(['auth:api'])->group(function () {
        Route::resource('data-pemilih', DataPemilihController::class)
            ->only(['index', 'store', 'update', 'destroy']);
    });


    Route::prefix('data-kandidat')->group(function () {
        Route::post('/data-kandidat', [DataKandidatController::class, 'store']); // Create
        Route::get('/data-kandidat', [DataKandidatController::class, 'index']); // Read
        Route::put('data-kandidat/{id}', [DataKandidatController::class, 'update']); // Update
        Route::delete('/data-kandidat/{id}', [DataKandidatController::class, 'destroy']); // Delete
    });

    Route::prefix('posisi-kandidat')->group(function() {
        Route::post('/posisi-kandidat', [PosisiKandidatController::class, 'store']); // Create
        Route::get('/posisi-kandidat', [PosisiKandidatController::class, 'index']); // Read
        Route::put('/posisi-kandidat/{id}', [PosisiKandidatController::class, 'update']); // Update
        Route::delete('/posisi-kandidat/{id}', [PosisiKandidatController::class, 'destroy']); // Delete
    });

    Route::prefix('pemilihan')->group(function() {
        Route::post('/pemilihan', [PemilihanController::class, 'store']); // Create
        Route::get('/pemilihan', [PemilihanController::class, 'index']); // Read
        Route::put('/pemilihan/{id}', [PemilihanController::class, 'update']); // Update
        Route::delete('/pemilihan/{id}', [PemilihanController::class, 'destroy']); // Delete
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('pemilihan-kandidat', PemilihanKandidatController::class)->except(['create', 'edit']);
    });
});
