<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;


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
//Sewa//
Route::Resource('sewa',SewaController::class);
Route::post('/sewa/data_list',[SewaController::class,'data_list'])->name('data_list');
Route::post('/sewa/update', [SewaController::class,'update'])->name('sewa.update');
Route::delete('/sewa/{id}', [SewaController::class, 'destroy']);
Route::get('/edit/{id}', [SewaController::class, 'edit']);






