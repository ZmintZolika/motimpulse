<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Nyilvános útvonalak (nem kell bejelentkezés)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Védett útvonalak (kell Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
