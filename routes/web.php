<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\KaryawanController;


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

Route::get('/', function () {
    return view('layout.main');
});
// Sewa
Route::prefix('sewa')->group(function () {
    Route::get('/', [SewaController::class, 'index'])->name('sewa.index');
    Route::post('/store', [SewaController::class, 'store'])->name('sewa.store');
    Route::get('/edit/{id}', [SewaController::class, 'edit'])->name('sewa.edit');
    Route::post('/update', [SewaController::class, 'update'])->name('sewa.update');
    Route::delete('/{id}', [SewaController::class, 'destroy'])->name('sewa.destroy');
    Route::post('/data_list', [SewaController::class, 'data_list'])->name('sewa.data_list');
});

// Karyawan
Route::prefix('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::post('/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/edit/{id}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::post('/update', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::post('/data_list', [KaryawanController::class, 'data_list'])->name('karyawan.data_list');
});






