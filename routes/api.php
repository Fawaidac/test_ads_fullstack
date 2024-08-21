<?php

use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\AuthController;
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

// Rute yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('karyawan', KaryawanController::class);
    Route::get('karyawan/first-joined', [KaryawanController::class, 'firstJoined']);
    Route::get('karyawan/with-leave', [KaryawanController::class, 'withLeave']);
    Route::get('karyawan/remaining-leave', [KaryawanController::class, 'remainingLeave']);
});

// Rute untuk login dan logout
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
