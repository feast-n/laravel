<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;

// --- PUBLIC ROUTES ---
Route::resource('/', HomeController::class);

// --- BELAJAR ROUTES ---
Route::get('belajar-laravel', [BelajarController::class, 'index']);
Route::get('penjumlahan', [BelajarController::class, 'penjumlahan'])->name('penjumlahan');
Route::post('store-tambah', [BelajarController::class, 'storeTambah'])->name('store-tambah');
Route::get('pengurangan', [BelajarController::class, 'kurang'])->name('pengurangan');
Route::post('store-kurang', [BelajarController::class, 'storeKurang'])->name('store-kurang');
Route::get('perkalian', [BelajarController::class, 'kali'])->name('perkalian');
Route::post('store-kali', [BelajarController::class, 'storeKali'])->name('store-kali');
Route::get('pembagian', [BelajarController::class, 'bagi'])->name('pembagian');
Route::post('store-bagi', [BelajarController::class, 'storeBagi'])->name('store-bagi');

// --- AUTHENTICATION ROUTES ---
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('action-login', [LoginController::class, 'actionLogin'])->name('action-login');
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('action-register', [RegisterController::class, 'actionRegister'])->name('action-register');

// Forgot & Reset Password Routes
Route::get('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');
Route::post('action-forgot-password', [ForgotPasswordController::class, 'actionForgotPassword'])->name('action-forgot-password');
Route::get('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');
Route::post('action-reset-password', [ForgotPasswordController::class, 'actionResetPassword'])->name('action-reset-password');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// --- PROTECTED ADMIN ROUTES ---
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Student Routes
    Route::get('/student', [StudentController::class, 'index'])->name('student');
    Route::post('/student/simpan', [StudentController::class, 'store'])->name('student.store');
    Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/hapus/{id}', [StudentController::class, 'hapus'])->name('student.hapus');
});
