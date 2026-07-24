<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\StudentController;

// Public Routes
Route::resource('/', HomeController::class);

// Belajar Routes
Route::get('belajar-laravel', [BelajarController::class, 'index']);
Route::get('penjumlahan', [BelajarController::class, 'penjumlahan'])->name('penjumlahan');
Route::post('store-tambah', [BelajarController::class, 'storeTambah'])->name('store-tambah');
Route::get('pengurangan', [BelajarController::class, 'kurang'])->name('pengurangan');
Route::post('store-kurang', [BelajarController::class, 'storeKurang'])->name('store-kurang');
Route::get('perkalian', [BelajarController::class, 'kali'])->name('perkalian');
Route::post('store-kali', [BelajarController::class, 'storeKali'])->name('store-kali');
Route::get('pembagian', [BelajarController::class, 'bagi'])->name('pembagian');
Route::post('store-bagi', [BelajarController::class, 'storeBagi'])->name('store-bagi');

// Auth Routes
Route::get('login', [LoginController::class, 'login']);
Route::post('action-login', [LoginController::class, 'actionLogin'])->name('action-login');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
});

// Student Routes
Route::get('/student', [StudentController::class, 'index'])->name('student');
Route::post('/student/tambah', [StudentController::class, 'store'])->name('student.store');
Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('student.update');
Route::get('/student/hapus/{id}', [StudentController::class, 'hapus'])->name('student.hapus');
