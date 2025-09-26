<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialTransferController;
use App\Http\Controllers\AuthController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [MaterialTransferController::class, 'index'])->name('material-transfer.index');
    Route::get('/transfer/{route}', [MaterialTransferController::class, 'create'])->name('material-transfer.create');
    Route::get('/records/{route}', [MaterialTransferController::class, 'show'])->name('material-transfer.show');
    Route::get('/edit/{id}', [MaterialTransferController::class, 'edit'])->name('material-transfer.edit');
    Route::put('/update/{id}', [MaterialTransferController::class, 'update'])->name('material-transfer.update');
    Route::get('/next-sl/{route}', [MaterialTransferController::class, 'getNextSlNo'])->name('material-transfer.next-sl');
    Route::post('/material-transfer', [MaterialTransferController::class, 'store'])->name('material-transfer.store');
    Route::post('/approve/{id}', [MaterialTransferController::class, 'approve'])->name('material-transfer.approve');
});
