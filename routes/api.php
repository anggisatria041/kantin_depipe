<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\KomentarController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PembayaranController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public Routes Pembayaran
Route::get('pembayaran', [PembayaranController::class, 'index']);
Route::get('pembayaran/{id}', [PembayaranController::class, 'show']);
Route::post('pembayaran', [PembayaranController::class, 'store']);
Route::put('pembayaran/{id}', [PembayaranController::class, 'update']);
Route::delete('pembayaran/{id}', [PembayaranController::class, 'destroy']);

// Public Routes Kategori
Route::get('kategori/{id}', [KategoriController::class, 'show']);
Route::post('kategori', [KategoriController::class, 'store']);
Route::put('kategori/{id}', [KategoriController::class, 'update']);
Route::delete('kategori/{id}', [KategoriController::class, 'destroy']);
// End Kategori

// Public Routes Menu
Route::get('menu/{id}', [MenuController::class, 'show']);
Route::delete('menu/{id}', [MenuController::class, 'destroy']);
// Public Routes Pesanan
Route::get('pesanan/{id}', [PesananController::class, 'show']);
Route::post('pesanan', [PesananController::class, 'store']);
Route::put('pesanan/{id}', [PesananController::class, 'update']);
Route::delete('pesanan/{id}', [PesananController::class, 'destroy']);

// Public Routes Komentar
Route::get('komentar/{id}', [KomentarController::class, 'show']);
Route::post('komentar', [KomentarController::class, 'store']);
Route::put('komentar/{id}', [KomentarController::class, 'update']);
Route::delete('komentar/{id}', [KomentarController::class, 'destroy']);

// Public Routes User
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('auth', [UserController::class, 'auth'])->name('auth');

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('users', [UserController::class, 'show']);
    Route::get('kategori', [KategoriController::class, 'index']);

    // Private Routes Menu
    Route::get('menu', [MenuController::class, 'index']);
    Route::post('menu', [MenuController::class, 'store']);
    Route::put('menu/{id}', [MenuController::class, 'update']);

    // Private Routes Pesanan
    Route::get('pesanan', [PesananController::class, 'index']);

    // Private Routes Komentar
    Route::get('komentar', [KomentarController::class, 'index']);
});

