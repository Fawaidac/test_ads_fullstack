<?php

use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::get('karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
Route::post('karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::get('karyawan/{id}', [KaryawanController::class, 'show'])->name('karyawan.show');
Route::get('karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
Route::put('karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
Route::delete('karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
