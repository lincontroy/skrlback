<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Users Resource
    Route::resource('users', UserController::class);
    
    // Transactions Resource
    Route::resource('transactions', TransactionController::class);
    
    // Home redirect
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
});