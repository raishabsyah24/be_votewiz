<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataKandidatController;
use App\Http\Controllers\DataPemilihController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\PemilihanController;
use App\Http\Controllers\PosisiKandidatController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VotingController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('data-pemilih', DataPemilihController::class);
        Route::apiResource('data-kandidat', DataKandidatController::class);
        Route::apiResource('posisi-kandidat', PosisiKandidatController::class);
        Route::apiResource('pemilihan', PemilihanController::class);
        Route::get('/rekapitulasi-voting', [RekapitulasiController::class, 'index']);
        Route::get('/settings', [SettingsController::class, 'index']);
    });

    Route::middleware('role:user')->group(function () {
        Route::get('/kandidat', [KandidatController::class, 'index']);
        Route::get('/voting', [VotingController::class, 'index']);
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
        Route::delete('data-kandidat/{id}', [DataKandidatController::class, 'destroy']); // Delete
    });
});
