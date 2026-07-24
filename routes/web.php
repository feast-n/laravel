<?php

use Illuminate\Support\Facades\Route;

Route::resource('/',\App\Http\Controllers\HomeController::class);

Route::get('belajar-laravel', [App\Http\Controllers\BelajarController::class, 'index']);
Route::get('penjumlahan', [App\Http\Controllers\BelajarController::class, 'penjumlahan'])->name('penjumlahan');
Route::post('store-tambah', [\App\Http\Controllers\BelajarController::class, 'storeTambah'])->name('store-tambah');
Route::get('pengurangan', [App\Http\Controllers\BelajarController::class, 'kurang'])->name('pengurangan');
Route::post('store-kurang', [\App\Http\Controllers\BelajarController::class, 'storeKurang'])->name('store-kurang');
Route::get('perkalian', [App\Http\Controllers\BelajarController::class, 'kali'])->name('perkalian');
Route::post('store-kali', [\App\Http\Controllers\BelajarController::class, 'storeKali'])->name('store-kali');
Route::get('pembagian', [App\Http\Controllers\BelajarController::class, 'bagi'])->name('pembagian');
Route::post('store-bagi', [\App\Http\Controllers\BelajarController::class, 'storeBagi'])->name('store-bagi');

Route::get('login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('action-login', [\App\Http\Controllers\LoginController::class, 'actionLogin'])->name('action-login');
Route::prefix('admin')->group(function(){
    Route::resource('/dashboard', \App\Http\Controllers\DashboardController::class);
    });


