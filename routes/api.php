<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\BookController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::apiResource('books', BookController::class);
});