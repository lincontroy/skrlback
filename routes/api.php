<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController as ApiTransactionController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use Illuminate\Support\Facades\Route;

// Authentication
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User profile
    Route::get('/user', [ApiUserController::class, 'show']);
    Route::put('/user', [ApiUserController::class, 'update']);
    
    // Transactions
    Route::get('/transactions', [ApiTransactionController::class, 'index']);
    Route::get('/transactions/{transaction}', [ApiTransactionController::class, 'show']);
});