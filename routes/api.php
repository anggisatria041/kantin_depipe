<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\KomentarController;
use App\Http\Controllers\Api\UserController;


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


// Public Routes Resource
    // Kategori
    Route::apiResource('kategori', KategoriController::class);
     // Komentar
    Route::apiResource('komentar', KomentarController::class);
// End Resource

// Public Routes
Route::get('menu/{id}', [MenuController::class, 'show']);
Route::get('pesanan/{id}', [PesananController::class, 'show']);


// Public Routes User
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('auth', [UserController::class, 'auth'])->name('auth');

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('users', [UserController::class, 'show']);

    // Private Routes Menu
    Route::get('menu', [MenuController::class, 'index']);
    Route::post('menu', [MenuController::class, 'store']);
    Route::put('menu/{id}', [MenuController::class, 'update']);
    Route::delete('menu/{id}', [MenuController::class, 'destroy']);

    // Private Routes Pesanan
    Route::get('pesanan', [PesananController::class, 'index']);
    Route::post('pesanan', [PesananController::class, 'store']);
    Route::put('pesanan/{id}', [PesananController::class, 'update']);
    Route::delete('pesanan/{id}', [PesananController::class, 'destroy']);
});

