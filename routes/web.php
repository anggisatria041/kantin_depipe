<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\HistoriSewaController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\InventoriController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StokBarangController;
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
Route::middleware(['auth:sanctum'])->group(function () {
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

    // Tenant
    Route::prefix('tenant')->group(function () {
        Route::get('/', [TenantController::class, 'index'])->name('tenant.index');
        Route::post('/store', [TenantController::class, 'store'])->name('tenant.store');
        Route::get('/edit/{id}', [TenantController::class, 'edit'])->name('tenant.edit');
        Route::post('/update', [TenantController::class, 'update'])->name('tenant.update');
        Route::delete('/{id}', [TenantController::class, 'destroy'])->name('tenant.destroy');
        Route::get('/password/{id}', [TenantController::class, 'password'])->name('tenant.password');
        Route::post('/update_password', [TenantController::class, 'updatePassword'])->name('tenant.update_password');
        Route::post('/data_list', [TenantController::class, 'data_list'])->name('tenant.data_list');
    });

    // Barcode
    Route::prefix('barcode')->group(function () {
        Route::get('/', [BarcodeController::class, 'index'])->name('barcode.index');
        Route::post('/store', [BarcodeController::class, 'store'])->name('barcode.store');
        Route::get('/edit/{id}', [BarcodeController::class, 'edit'])->name('barcode.edit');
        Route::post('/update', [BarcodeController::class, 'update'])->name('barcode.update');
        Route::delete('/{id}', [BarcodeController::class, 'destroy'])->name('barcode.destroy');
        Route::post('/data_list', [BarcodeController::class, 'data_list'])->name('barcode.data_list');
        Route::get('/cetak/{id}', [BarcodeController::class, 'cetak']);
    });

    // Stok Barang
    Route::prefix('stok_barang')->group(function () {
        Route::get('/', [StokBarangController::class, 'index'])->name('stok_barang.index');
        Route::post('/store', [StokBarangController::class, 'store'])->name('stok_barang.store');
        Route::get('/edit/{id}', [StokBarangController::class, 'edit'])->name('stok_barang.edit');
        Route::post('/update', [StokBarangController::class, 'update'])->name('stok_barang.update');
        Route::delete('/{id}', [StokBarangController::class, 'destroy'])->name('stok_barang.destroy');
        Route::post('/data_list', [StokBarangController::class, 'data_list'])->name('stok_barang.data_list');
    });

    //Auth
    Route::get('/logout', [AuthController::class, 'logout']);
});
Route::post('/postlogin', [AuthController::class, 'postlogin']);
Route::get('/portal', [AuthController::class, 'login']);
Route::get('/lawang', [AuthController::class, 'lawang'])->name('lawang');






