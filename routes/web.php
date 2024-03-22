<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\HistoriSewaController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\InventoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;


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
    return view('page.login');
});

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Sewa
Route::prefix('sewa')->group(function () {
    Route::get('/', [SewaController::class, 'index'])->name('sewa.index');
    Route::post('/store', [SewaController::class, 'store'])->name('sewa.store');
    Route::get('/edit/{id}', [SewaController::class, 'edit'])->name('sewa.edit');
    Route::post('/update', [SewaController::class, 'update'])->name('sewa.update');
    Route::delete('/{id}', [SewaController::class, 'destroy'])->name('sewa.destroy');
    Route::post('/data_list', [SewaController::class, 'data_list'])->name('sewa.data_list');
});

// Histori Sewa
Route::prefix('histori_sewa')->group(function () {
    Route::get('/', [HistoriSewaController::class, 'index'])->name('histori_sewa.index');
    Route::post('/data_list', [HistoriSewaController::class, 'data_list'])->name('histori_sewa.data_list');
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

// Gaji
Route::prefix('gaji')->group(function () {
    Route::get('/', [GajiController::class, 'index'])->name('gaji.index');
    Route::post('/store', [GajiController::class, 'store'])->name('gaji.store');
    Route::get('/edit/{id}', [GajiController::class, 'edit'])->name('gaji.edit');
    Route::post('/update', [GajiController::class, 'update'])->name('gaji.update');
    Route::delete('/{id}', [GajiController::class, 'destroy'])->name('gaji.destroy');
    Route::post('/data_list', [GajiController::class, 'data_list'])->name('gaji.data_list');
});

// Inventori
Route::prefix('inventori')->group(function () {
    Route::get('/', [InventoriController::class, 'index'])->name('inventori.index');
    Route::post('/store', [InventoriController::class, 'store'])->name('inventori.store');
    Route::get('/edit/{id}', [InventoriController::class, 'edit'])->name('inventori.edit');
    Route::post('/update', [InventoriController::class, 'update'])->name('inventori.update');
    Route::delete('/{id}', [InventoriController::class, 'destroy'])->name('inventori.destroy');
    Route::post('/data_list', [InventoriController::class, 'data_list'])->name('inventori.data_list');
});

//Auth
Route::post('/postlogin', [AuthController::class, 'postlogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/portal', [AuthController::class, 'login']);






